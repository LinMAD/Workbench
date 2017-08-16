<?php

namespace CarBundle\Controller;

use CarBundle\Entity\Car;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/our-cars", name="offer")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \LogicException
     */
    public function indexAction()
    {
        $carRepository = $this->getDoctrine()->getRepository(Car::class);
        $cars = $carRepository->findAll();

        return $this->render('CarBundle:Default:index.html.twig', [
            'cars' => $cars,
        ]);
    }

    /**
     * @Route("/car/{id}", name="show_car")
     *
     * @param $id
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction($id): \Symfony\Component\HttpFoundation\Response
    {
        $carRepository = $this->getDoctrine()->getRepository(Car::class);
        $car = $carRepository->find($id);

        return $this->render('CarBundle:Default:show.html.twig', [
            'car' => $car,
        ]);
    }
}
