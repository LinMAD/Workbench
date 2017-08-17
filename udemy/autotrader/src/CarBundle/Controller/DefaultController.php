<?php

namespace CarBundle\Controller;

use CarBundle\Entity\Car;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
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

        $form = $this->createFormBuilder()
            ->setMethod(Request::METHOD_GET)
            ->add('search', TextType::class)
            ->getForm();

        return $this->render('CarBundle:Default:index.html.twig', [
            'cars' => $cars,
            'form' => $form->createView()
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
