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
		return $this->render('MainBundle:Main:index.html.twig', array('test' => $test, 'result' => $result));
	}

	/**
	 * @Route("/result", name="result")
	 * @Template()
	 */
	public function resultAction()
	{
		$result = $_POST['select'];
		$test   = $this->getDoctrine()->getRepository('BilimBundle:Test')
					   ->createQueryBuilder('test')
					   ->where('test.name=:name')
					   ->setParameter('name', $result)
					   ->getQuery()
					   ->getOneOrNullResult();

		$result = $this->getDoctrine()->getRepository('BilimBundle:Student')->findByTest($test);
    	$test   = $this->getDoctrine()->getRepository('BilimBundle:Test')->findAll();

        return $this->render('MainBundle:Main:index.html.twig', array('test' => $test, 'result' => $result));
    }
}
