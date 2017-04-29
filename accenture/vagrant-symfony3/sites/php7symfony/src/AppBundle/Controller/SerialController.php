<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Serial;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Serial controller.
 *
 * @Route("admin/serials")
 */
class SerialController extends Controller
{
    /**
     * Lists all serial entities.
     *
     * @Route("/", name="admin_serials_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $serials = $em->getRepository('AppBundle:Serial')->findAll();

        return $this->render('serial/index.html.twig', array(
            'serials' => $serials,
        ));
    }

    /**
     * Creates a new serial entity.
     *
     * @Route("/new", name="admin_serials_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $serial = new Serial();
        $form = $this->createForm('AppBundle\Form\SerialType', $serial);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($serial);
            $em->flush();

            return $this->redirectToRoute('admin_serials_show', array('id' => $serial->getId()));
        }

        return $this->render('serial/new.html.twig', array(
            'serial' => $serial,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a serial entity.
     *
     * @Route("/{id}", name="admin_serials_show")
     * @Method("GET")
     */
    public function showAction(Serial $serial)
    {
        $deleteForm = $this->createDeleteForm($serial);

        return $this->render('serial/show.html.twig', array(
            'serial' => $serial,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing serial entity.
     *
     * @Route("/{id}/edit", name="admin_serials_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Serial $serial)
    {
        $deleteForm = $this->createDeleteForm($serial);
        $editForm = $this->createForm('AppBundle\Form\SerialType', $serial);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_serials_edit', array('id' => $serial->getId()));
        }

        return $this->render('serial/edit.html.twig', array(
            'serial' => $serial,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a serial entity.
     *
     * @Route("/{id}", name="admin_serials_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Serial $serial)
    {
        $form = $this->createDeleteForm($serial);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($serial);
            $em->flush();
        }

        return $this->redirectToRoute('admin_serials_index');
    }

    /**
     * Creates a form to delete a serial entity.
     *
     * @param Serial $serial The serial entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Serial $serial)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_serials_delete', array('id' => $serial->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
