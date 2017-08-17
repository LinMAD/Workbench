<?php

namespace CarBundle\Controller;

use CarBundle\Entity\Car;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use CarBundle\Form\CarType;

/**
 * Car controller.
 *
 * @Route("/admin/car")
 */
class CarController extends Controller
{
    /**
     * Lists all car entities.
     *
     * @Route("/", name="car_index")
     * @Method("GET")
     * @Template(template="@Car/car/index.html.twig")
     *
     * @throws \InvalidArgumentException
     * @throws \LogicException
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $cars = $em->getRepository('CarBundle:Car')->findAll();

        return [
            'cars' => $cars,
        ];
    }

    /**
     * Creates a new car entity.
     *
     * @Route("/new", name="car_new")
     * @Method({"GET", "POST"})
     * @Template(template="@Car/car/new.html.twig")
     *
     * @param Request $request
     *
     * @return array|RedirectResponse
     *
     * @throws \LogicException
     */
    public function newAction(Request $request)
    {
        $car = new Car();
        $form = $this->createForm(CarType::class, $car);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($car);
            $em->flush();

            return $this->redirectToRoute('car_show', ['id' => $car->getId()]);
        }

        return [
            'car'  => $car,
            'form' => $form->createView(),
        ];
    }

    /**
     * Finds and displays a car entity.
     *
     * @Route("/{id}", name="car_show")
     * @Method("GET")
     * @Template(template="@Car/car/show.html.twig")
     *
     * @param Car $car
     *
     * @return array
     */
    public function showAction(Car $car): array
    {
        $deleteForm = $this->createDeleteForm($car);

        return [
            'car'         => $car,
            'delete_form' => $deleteForm->createView(),
        ];
    }

    /**
     * Displays a form to edit an existing car entity.
     *
     * @Route("/{id}/edit", name="car_edit")
     * @Method({"GET", "POST"})
     * @Template(template="@Car/car/edit.html.twig")
     *
     * @param Request $request
     * @param Car     $car
     *
     * @return array|RedirectResponse
     * @throws \LogicException
     */
    public function editAction(Request $request, Car $car)
    {
        $deleteForm = $this->createDeleteForm($car);
        $editForm = $this->createForm(CarType::class, $car);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('car_edit', ['id' => $car->getId()]);
        }

        return [
            'car'         => $car,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ];
    }

    /**
     * Deletes a car entity.
     *
     * @Route("/{id}", name="car_delete")
     * @Method("DELETE")
     *
     * @param Request $request
     * @param Car     $car
     *
     * @return RedirectResponse
     *
     * @throws \LogicException
     * @throws \InvalidArgumentException
     */
    public function deleteAction(Request $request, Car $car): RedirectResponse
    {
        $form = $this->createDeleteForm($car);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($car);
            $em->flush();
        }

        return $this->redirectToRoute('car_index');
    }

    /**
     * Creates a form to delete a car entity.
     *
     * @param Car $car The car entity
     *
     * @return Form The form
     */
    private function createDeleteForm(Car $car): Form
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('car_delete', ['id' => $car->getId()]))
            ->setMethod(Request::METHOD_DELETE)
            ->getForm();
    }
}
