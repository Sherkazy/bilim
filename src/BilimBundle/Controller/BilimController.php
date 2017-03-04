<?php

namespace BilimBundle\Controller;

use BilimBundle\Entity\Bilim;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Bilim controller.
 *
 */
class BilimController extends Controller
{
    /**
     * Lists all bilim entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $request = new Request();
        $bilims = $em->getRepository('BilimBundle:Bilim')->findAll();
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $bilims, $request->query->getInt('page', 1), 20
        );

        return $this->render('BilimBundle:Bilim:index.html.twig', array(
            'bilims' => $pagination,
        ));
    }

    /**
     * Creates a new bilim entity.
     *
     */
    public function newAction(Request $request)
    {
        $bilim = new Bilim();
        $form = $this->createForm('BilimBundle\Form\BilimType', $bilim);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($bilim);
            $em->flush($bilim);

            return $this->redirectToRoute('bilim_show', array('id' => $bilim->getId()));
        }

        return $this->render('BilimBundle:Bilim:new.html.twig', array(
            'bilim' => $bilim,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a bilim entity.
     *
     */
    public function showAction(Bilim $bilim)
    {
        $deleteForm = $this->createDeleteForm($bilim);

        return $this->render('BilimBundle:Bilim:show.html.twig', array(
            'bilim' => $bilim,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing bilim entity.
     *
     */
    public function editAction(Request $request, Bilim $bilim)
    {
        $deleteForm = $this->createDeleteForm($bilim);
        $editForm = $this->createForm('BilimBundle\Form\BilimType', $bilim);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('bilim_edit', array('id' => $bilim->getId()));
        }

        return $this->render('BilimBundle:Bilim:edit.html.twig', array(
            'bilim' => $bilim,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a bilim entity.
     *
     */
    public function deleteAction(Request $request, Bilim $bilim)
    {
        $form = $this->createDeleteForm($bilim);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($bilim);
            $em->flush($bilim);
        }

        return $this->redirectToRoute('bilim_index');
    }

    /**
     * Creates a form to delete a bilim entity.
     *
     * @param Bilim $bilim The bilim entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Bilim $bilim)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('bilim_delete', array('id' => $bilim->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
}
