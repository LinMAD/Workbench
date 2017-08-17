<?php

namespace CarBundle\Controller;

use CarBundle\Entity\Car;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/our-cars", name="offer")
     *
     * @return Response
     *
     * @throws \LogicException
     */
    public function indexAction()
    {
        $carRepository = $this->getDoctrine()->getRepository(Car::class);
        $cars = $carRepository->findCarsWithDetails();

        return $this->render('CarBundle:Default:index.html.twig', [
            'cars' => $cars,
        ]);
    }

    /**
     * @Route("/car/{id}", name="show_car")
     *
     * @param $id
     *
     * @return Response
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \LogicException
     */
    public function showAction($id): Response
    {
        $carRepository = $this->getDoctrine()->getRepository(Car::class);
        $car = $carRepository->findCarWithDetailsById($id);

        return $this->render('CarBundle:Default:show.html.twig', [
            'car' => $car,
        ]);
    }
}
