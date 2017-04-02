<?php

namespace MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;


class MainController extends Controller
{
	/**
	 * @Route("/", name="main_index")
	 * @Template()
	 */
	public function indexAction()
	{
		$test   = $this->getDoctrine()->getRepository('BilimBundle:Test')->findAll();
		$result = null;
		$testResult = null;
		return $this->render('MainBundle:Main:index.html.twig', array(
			'test' => $test,
			'result' => $result,
			'test_result' => $testResult
		));
	}

	/**
	 * @Route("/result", name="result")
	 * @Template()
	 */
	public function resultAction()
	{
		$result     = $_POST['select'];
		$testResult = $this->getDoctrine()->getRepository('BilimBundle:Test')
						   ->createQueryBuilder('test')
						   ->where('test.name=:name')
						   ->setParameter('name', $result)
						   ->getQuery()
						   ->getOneOrNullResult();

		$result = $this->getDoctrine()->getRepository('BilimBundle:Student')
					   ->createQueryBuilder('student')
					   ->where('student.test =:test')
					   ->orderBy('student.general', 'ASC')
					   ->setParameter('test', $testResult)
					   ->getQuery()
					   ->getResult();
		$test   = $this->getDoctrine()->getRepository('BilimBundle:Test')->findAll();

		$array = array();
		for ($i = 0; $i < 100; $i++) {
			array_push($array, $i);
		}

		return $this->render('MainBundle:Main:index.html.twig', array(
			'array'       => $array,
			'test'        => $test,
			'result'      => $result,
			'test_result' => $testResult
		));
	}


}
