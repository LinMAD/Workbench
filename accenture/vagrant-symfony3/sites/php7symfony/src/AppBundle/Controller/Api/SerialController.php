<?php

namespace AppBundle\Controller\Api;

use AppBundle\Entity\Serial;
use AppBundle\Form\SerialType;
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

class SerialController extends FOSRestController
{
    /**
     * @Get("/serials.{_format}", name="api_get_serials")
     *
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @throws \LogicException
     */
    public function getSerialsAction(): \Symfony\Component\HttpFoundation\Response
    {
        $serials = $this->getDoctrine()
            ->getRepository('AppBundle:Serial')
            ->findAll();

        if (empty($serials)) {
            throw new NotFoundHttpException(
                'No content',
                null,
                Response::HTTP_NO_CONTENT
            );
        }

        return $this->handleView($this->view($serials, Response::HTTP_OK));
    }

    /**
     * @Get("/serials/{id}.{_format}", name="api_get_serial")
     * @param Serial $serials
     * @return Response
     */
    public function getSerialAction(Serial $serials): \Symfony\Component\HttpFoundation\Response
    {
        return $this->handleView($this->view($serials, Response::HTTP_OK));
    }

    /**
     * @Post("/serials.{_format}", name="api_post_serial")
     * @param Request $request
     * @return Response
     * @throws \Symfony\Component\HttpKernel\Exception\BadRequestHttpException
     */
    public function postSerialAction(Request $request): \Symfony\Component\HttpFoundation\Response
    {
        $serial = new Serial();
        $form = $this->createForm(SerialType::class, $serial);
        $this->processForm($request, $form);

        if(!$form->isValid()){
            throw new BadRequestHttpException(
                'Bad request',
                null,
                Response::HTTP_BAD_REQUEST
            );
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($serial);
        $em->flush();

        return $this->handleView($this->view($serial, Response::HTTP_CREATED));
    }

    /**
     * @Put("/serials/{id}.{_format}", name="api_put_serial")
     * @param Request $request
     * @param Serial $serial
     * @return Response
     * @throws \Symfony\Component\HttpKernel\Exception\BadRequestHttpException
     */
    public function putMovieAction(Request $request, Serial $serial): \Symfony\Component\HttpFoundation\Response
    {
        $form = $this->createForm(SerialType::class, $serial);
        $this->processForm($request, $form);

        if(!$form->isValid()){
            throw new BadRequestHttpException(
                'Bad request',
                null,
                Response::HTTP_BAD_REQUEST
            );
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($serial);
        $em->flush();

        return $this->handleView($this->view($serial, Response::HTTP_OK));
    }

    /**
     * @Delete("/movies/{id}.{_format}", name="api_delete_movie")
     * @param Serial $serial
     * @return Response
     * @throws \LogicException
     * @throws \InvalidArgumentException
     */
    public function deleteMovieAction(Serial $serial): \Symfony\Component\HttpFoundation\Response
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($serial);
        $em->flush();

        return $this->handleView($this->view($serial, Response::HTTP_OK));
    }

    private function processForm(Request $request, FormInterface $form)
    {
        $data = json_decode($request->getContent(), true);
        $form->submit($data);
    }
}