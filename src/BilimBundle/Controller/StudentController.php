<?php

namespace BilimBundle\Controller;

use BilimBundle\Entity\Student;
use BilimBundle\Entity\Test;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Student controller.
 *
 */
class StudentController extends Controller
{
	/**
	 * Lists all student entities.
	 *
	 */
	public function indexAction()
	{
		$em = $this->getDoctrine()->getManager();

		$students = $em->getRepository('BilimBundle:Student')->findBy(array(), array('id' => 'DESC'));

		$request    = new Request();
		$paginator  = $this->get('knp_paginator');
		$pagination = $paginator->paginate(
			$students, $request->query->getInt('page', 1), 999
		);

		return $this->render('BilimBundle:Student:index.html.twig', array(
			'students' => $pagination,
		));
	}

	public function listByTestAction(Test $test)
	{
		$students   = $this->getDoctrine()->getRepository('BilimBundle:Student')
						   ->findByTest($test);
		$request    = new Request();
		$paginator  = $this->get('knp_paginator');
		$pagination = $paginator->paginate(
			$students, $request->query->getInt('page', 1), 999
		);
		return $this->render('BilimBundle:Student:index.html.twig', array(
			'students' => $pagination,
		));
	}

	/**
	 * Creates a new student entity.
	 *
	 */
	public function newAction(Request $request)
	{
		$student = new Student();
		$form    = $this->createForm('BilimBundle\Form\StudentType', $student);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$em->persist($student);
			$em->flush($student);

			return $this->redirectToRoute('student_show', array('id' => $student->getId()));
		}

		return $this->render('BilimBundle:Student:new.html.twig', array(
			'student' => $student,
			'form'    => $form->createView(),
		));
	}

	public function randomGenerateAction()
	{
		$test   = $_POST['test'];
		$test   = $this->getDoctrine()->getRepository('BilimBundle:Test')->find($test);
		$region = $this->getDoctrine()->getRepository('BilimBundle:Region')->find(1);
		$em     = $this->getDoctrine()->getManager();
		$size   = 10000;
		for ($item = 1; $item <= $size; $item++) {
			$numbers = rand(1, 9);
			$region  = $this->getDoctrine()->getRepository('BilimBundle:Region')->find($numbers);
			$student = new Student();
			$student->setName('Student' . $item);
			$student->setTest($test);
			$student->setRegion($region);
			$em->persist($student);
			if ($item % 100 == 0 || $item == $size) {
				$em->flush();
			}
		}
		return $this->redirect($this->generateUrl('student_index'));

	}

	/**
	 * Finds and displays a student entity.
	 *
	 */
	public function showAction(Student $student)
	{
		$deleteForm = $this->createDeleteForm($student);

		return $this->render('BilimBundle:Student:show.html.twig', array(
			'student'     => $student,
			'delete_form' => $deleteForm->createView(),
		));
	}

	/**
	 * Displays a form to edit an existing student entity.
	 *
	 */
	public function editAction(Request $request, Student $student)
	{
		$deleteForm = $this->createDeleteForm($student);
		$editForm   = $this->createForm('BilimBundle\Form\StudentType', $student);
		$editForm->handleRequest($request);

		if ($editForm->isSubmitted() && $editForm->isValid()) {
			$this->getDoctrine()->getManager()->flush();

			return $this->redirectToRoute('student_edit', array('id' => $student->getId()));
		}

		return $this->render('BilimBundle:Student:edit.html.twig', array(
			'student'     => $student,
			'edit_form'   => $editForm->createView(),
			'delete_form' => $deleteForm->createView(),
		));
	}

	public function generatorAction()
	{
		$tests = $this->getDoctrine()->getRepository('BilimBundle:Test')->findAll();
		return $this->render('BilimBundle:Student:generator.html.twig', array('tests' => $tests));
	}

	/**
	 * Deletes a student entity.
	 *
	 */
	public function deleteAction(Request $request, Student $student)
	{
		$form = $this->createDeleteForm($student);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$em->remove($student);
			$em->flush($student);
		}

		return $this->redirectToRoute('student_index');
	}

	/**
	 * Creates a form to delete a student entity.
	 *
	 * @param Student $student The student entity
	 *
	 * @return \Symfony\Component\Form\Form The form
	 */
	private function createDeleteForm(Student $student)
	{
		return $this->createFormBuilder()
					->setAction($this->generateUrl('student_delete', array('id' => $student->getId())))
					->setMethod('DELETE')
					->getForm();
	}


	public function counterAction($number, Test $test)
	{
		$student = $this->getDoctrine()->getRepository('BilimBundle:Student')
						->createQueryBuilder('s')
						->where('s.test =:test')
						->andWhere('s.general=:number')
						->setParameter('test', $test)
						->setParameter('number', $number)
						->getQuery()
						->getResult();
		return $this->render('BilimBundle:Student:counter.html.twig',array(
			'counter' => count($student))
		);
	}
}
