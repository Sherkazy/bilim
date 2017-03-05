<?php

namespace BilimBundle\Controller;

use BilimBundle\Entity\Exam;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Exam controller.
 *
 */
class ExamController extends Controller
{
    /**
     * Lists all exam entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $exams = $em->getRepository('BilimBundle:Exam')->findAll();
        $request = new Request();
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $exams, $request->query->getInt('page', 1), 20
        );

        return $this->render('BilimBundle:Exam:index.html.twig', array(
            'exams' => $pagination,
        ));
    }

    /**
     * Creates a new exam entity.
     *
     */
    public function newAction(Request $request)
    {
        $exam = new Exam();
        $form = $this->createForm('BilimBundle\Form\ExamType', $exam);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($exam);
            $em->flush($exam);

            return $this->redirectToRoute('exam_show', array('id' => $exam->getId()));
        }

        return $this->render('BilimBundle:Exam:new.html.twig', array(
            'exam' => $exam,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a exam entity.
     *
     */
    public function showAction(Exam $exam)
    {
        $deleteForm = $this->createDeleteForm($exam);

        $suroos = $this->getDoctrine()->getRepository('BilimBundle:Suroo')->findAll();
        $suroo = array();

        foreach ($exam->getSuroo() as $entity){
            $suroo[$entity] = $entity;
        }
        return $this->render('BilimBundle:Exam:show.html.twig', array(
            'suroo' => $suroo,
            'exam' => $exam,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing exam entity.
     *
     */
    public function editAction(Request $request, Exam $exam)
    {
        $deleteForm = $this->createDeleteForm($exam);
        $editForm = $this->createForm('BilimBundle\Form\ExamType', $exam);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('exam_edit', array('id' => $exam->getId()));
        }

        return $this->render('BilimBundle:Exam:edit.html.twig', array(
            'exam' => $exam,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a exam entity.
     *
     */
    public function deleteAction(Request $request, Exam $exam)
    {
        $form = $this->createDeleteForm($exam);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($exam);
            $em->flush($exam);
        }

        return $this->redirectToRoute('exam_index');
    }

    /**
     * Creates a form to delete a exam entity.
     *
     * @param Exam $exam The exam entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Exam $exam)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('exam_delete', array('id' => $exam->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
