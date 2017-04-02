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

		$exams      = $em->getRepository('BilimBundle:Exam')->findAll();
		$request    = new Request();
		$paginator  = $this->get('knp_paginator');
		$pagination = $paginator->paginate(
			$exams, $request->query->getInt('page', 1), 20
		);
		$test       = $this->getDoctrine()->getRepository('BilimBundle:Test')->findAll();

		return $this->render('BilimBundle:Exam:index.html.twig', array(
			'exams' => $pagination,
			'tests' => $test
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
		$suroo  = array();

		foreach ($exam->getSuroo() as $entity) {
			$suroo[$entity] = $entity;
		}
		return $this->render('BilimBundle:Exam:show.html.twig', array(
			'suroo'       => $suroo,
			'exam'        => $exam,
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
		$editForm   = $this->createForm('BilimBundle\Form\ExamType', $exam);
		$editForm->handleRequest($request);

		if ($editForm->isSubmitted() && $editForm->isValid()) {
			$this->getDoctrine()->getManager()->flush();

			return $this->redirectToRoute('exam_edit', array('id' => $exam->getId()));
		}

		return $this->render('BilimBundle:Exam:edit.html.twig', array(
			'exam'        => $exam,
			'edit_form'   => $editForm->createView(),
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
					->getForm();
	}

	public function generateAction()
	{
		$test    = $_POST['test'];
		$test    = $this->getDoctrine()->getRepository('BilimBundle:Test')->find($test);
		$suroo   = $this->getDoctrine()->getRepository('BilimBundle:Suroo')->findAll();
		$subject = $this->getDoctrine()->getRepository('BilimBundle:Subject')->findAll();

//        $random = (array)$suroo;
//        $random = array_rand($random);


		$exam     = new Exam();
		$surooArr = array();
		foreach ($subject as $sub) {
			$subjectSuroo       = $this->getSur()->findBySubject($sub);
			$dif1               = 1;
			$dif2               = 1;
			$dif3               = 1;
			$subjectSurooRandom = (array)$subjectSuroo;
			shuffle($subjectSurooRandom);
			foreach ($subjectSurooRandom as $ran) {

//                dump($ran);
//                die();
				if ($ran->getDifficulty() == 1 && $dif1 <= 3) {
					$dif1++;
					array_push($surooArr, $ran->getId());
				}
				if ($ran->getDifficulty() == 2 && $dif2 <= 3) {
					$dif2++;
					array_push($surooArr, $ran->getId());
				}
				if ($ran->getDifficulty() == 3 && $dif3 <= 3) {
					$dif3++;
					array_push($surooArr, $ran->getId());
				}
				if ($dif1 == 4 && $dif2 == 4 && $dif3 == 4) {
//                    dump($surooArr);
//                    die('keldi');
					break;
				}
			}

		}
		$exam->setTest($test);
		$exam->setSuroo($surooArr);
		$this->getEm()->persist($exam);
		$this->getEm()->flush();

//		dump($exam);
//		die('keldi');
		$students = $this->getStu()->findByTest($test);
		$i        = 0;


		foreach ($students as $stu) {
//            $bilim = $this->getBil()->findByStudent($stu);
			foreach ($exam->getSuroo() as $exa) {
				$sur   = $this->getSur()->find($exa);

				$bilim = $this->getBil()->createQueryBuilder('bilim')
							  ->where('bilim.student =:student')
							  ->andWhere('bilim.suroo =:suroo')
							  ->setParameter('student', $stu)
							  ->setParameter('suroo', $sur)
							  ->getQuery()
							  ->getOneOrNullResult();

				if ($bilim) {
					if ($bilim->getSuroo()->getSubject()->getType()->getName() == 'естественные') {
						$stu->setScience(($bilim->getSuroo()->getDifficulty()) + $stu->getScience());

					}
					if ($bilim->getSuroo()->getSubject()->getType()->getName() == 'гуманитарный') {
						$stu->setHumanitary(($bilim->getSuroo()->getDifficulty()) + $stu->getHumanitary());
					}
				}
			}
			$stu->setGeneral(($stu->getScience() + $stu->getHumanitary()) / 2);
			$this->getEm()->persist($stu);

//            if($i==50 || count($students)-1 == $i){
//            die('keldi');
			$this->getEm()->flush();
//            }

			$i++;
		}

		return $this->redirect($this->generateUrl('student_index'));
	}

	public function getSur()
	{
		return $this->getDoctrine()->getRepository('BilimBundle:Suroo');
	}

	public function getTes()
	{
		return $this->getDoctrine()->getRepository('BilimBundle:Test');
	}

	public function getSub()
	{
		return $this->getDoctrine()->getRepository('BilimBundle:Subject');
	}

	public function getBil()
	{
		return $this->getDoctrine()->getRepository('BilimBundle:Bilim');
	}

	public function getStu()
	{
		return $this->getDoctrine()->getRepository('BilimBundle:Student');
	}

	public function getEm()
	{
		return $this->getDoctrine()->getManager();
	}
}
