<?php

namespace AppBundle\Controller\Api;

use AppBundle\Entity\Movie;
use AppBundle\Form\MovieType;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormInterface;

use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Put;
use FOS\RestBundle\Controller\Annotations\Delete;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class MovieController extends FOSRestController
{
    /**
     * @Get("/movies.{_format}", name="api_get_movies")
     */
    public function getMoviesAction()
    {
        $movies = $this->getDoctrine()
            ->getRepository('AppBundle:Movie')
            ->findAll();

        if (empty($movies)) {
            throw new NotFoundHttpException(
                'No content',
                null,
                Response::HTTP_NO_CONTENT
            );
        }

        return $this->handleView($this->view($movies, Response::HTTP_OK));
    }

    /**
     * @Get("/movies/{id}.{_format}", name="api_get_movie")
     */
    public function getMovieAction(Movie $movie)
    {
        return $this->handleView($this->view($movie, Response::HTTP_OK));
    }

    /**
     * @Post("/movies.{_format}", name="api_post_movie")
     */
    public function postMoviesAction(Request $request)
    {
        $movie = new Movie();
        $form = $this->createForm(MovieType::class, $movie);
        $this->processForm($request, $form);

        if(!$form->isValid()){
            throw new BadRequestHttpException(
                'Bad request',
                null,
                Response::HTTP_BAD_REQUEST
            );
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($movie);
        $em->flush();

        return $this->handleView($this->view($movie, Response::HTTP_CREATED));
    }

    /**
     * @Put("/movies/{id}.{_format}", name="api_put_movie")
     */
    public function putMovieAction(Request $request, Movie $movie)
    {
        $form = $this->createForm(MovieType::class, $movie);
        $this->processForm($request, $form);

        if(!$form->isValid()){
            throw new BadRequestHttpException(
                'Bad request',
                null,
                Response::HTTP_BAD_REQUEST
            );
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($movie);
        $em->flush();

        return $this->handleView($this->view($movie, Response::HTTP_OK));
    }

    /**
     * @Delete("/movies/{id}.{_format}", name="api_delete_movie")
     */
    public function deleteMovieAction(Movie $movie)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($movie);
        $em->flush();

        return $this->handleView($this->view($movie, Response::HTTP_OK));
    }

    private function processForm(Request $request, FormInterface $form)
    {
        $data = json_decode($request->getContent(), true);
        $form->submit($data);
    }
}
