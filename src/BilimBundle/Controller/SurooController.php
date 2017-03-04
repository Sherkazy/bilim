<?php

namespace BilimBundle\Controller;

use BilimBundle\Entity\Suroo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Suroo controller.
 *
 */
class SurooController extends Controller
{
    /**
     * Lists all suroo entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $suroos = $em->getRepository('BilimBundle:Suroo')->findAll();

        $request = new Request();
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $suroos, $request->query->getInt('page', 1), 20
        );

        return $this->render('BilimBundle:Suroo:index.html.twig', array(
            'suroos' => $pagination,
        ));
    }

    /**
     * Creates a new suroo entity.
     *
     */
    public function newAction(Request $request)
    {
        $suroo = new Suroo();
        $form = $this->createForm('BilimBundle\Form\SurooType', $suroo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($suroo);
            $em->flush($suroo);

            return $this->redirectToRoute('suroo_show', array('id' => $suroo->getId()));
        }

        return $this->render('BilimBundle:Suroo:new.html.twig', array(
            'suroo' => $suroo,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a suroo entity.
     *
     */
    public function showAction(Suroo $suroo)
    {
        $deleteForm = $this->createDeleteForm($suroo);

        return $this->render('BilimBundle:Suroo:show.html.twig', array(
            'suroo' => $suroo,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing suroo entity.
     *
     */
    public function editAction(Request $request, Suroo $suroo)
    {
        $deleteForm = $this->createDeleteForm($suroo);
        $editForm = $this->createForm('BilimBundle\Form\SurooType', $suroo);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('suroo_edit', array('id' => $suroo->getId()));
        }

        return $this->render('BilimBundle:Suroo:edit.html.twig', array(
            'suroo' => $suroo,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a suroo entity.
     *
     */
    public function deleteAction(Request $request, Suroo $suroo)
    {
        $form = $this->createDeleteForm($suroo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($suroo);
            $em->flush($suroo);
        }

        return $this->redirectToRoute('suroo_index');
    }

    /**
     * Creates a form to delete a suroo entity.
     *
     * @param Suroo $suroo The suroo entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Suroo $suroo)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('suroo_delete', array('id' => $suroo->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
