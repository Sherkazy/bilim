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
        $test = $this->getDoctrine()->getRepository('BilimBundle:Test')->findAll();
//        $bilims = $em->getRepository('BilimBundle:Bilim')->findAll();
//        die('keldi');
//        $paginator = $this->get('knp_paginator');
//        $pagination = $paginator->paginate(
//            $bilims, $request->query->getInt('page', 1), 120
//        );


        return $this->render('BilimBundle:Bilim:index.html.twig', array(
//            'bilims' => $pagination,
            'tests' => $test
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

    public function generateAction()
    {
        $test = $_POST['test'];
        $test = $this->getDoctrine()->getRepository('BilimBundle:Test')->find($test);
        $suroos = $this->getDoctrine()->getRepository('BilimBundle:Suroo')->findAll();
        $student = $this->getDoctrine()->getRepository('BilimBundle:Student')->findBy(
            array('test' => $test),
            array('id' => 'ASC'));
        $em = $this->getEm();
        $min = $student[0]->getId();
        $max = $student[count($student) - 1]->getId();


        foreach ($suroos as $item) {
            $difficulty = $item->getDifficulty();
            $randomNumbers = range($min, $max);
            shuffle($randomNumbers);
            $i = 0;
            if ($difficulty == 1) {
                foreach ($randomNumbers as $rand) {
                    $bilim = new Bilim();
                    $bilim->setStudent($this->getStu()->find($rand));
                    $bilim->setSuroo($item);
                    $em->persist($bilim);
                    if ($i == 100) {
                        $em->flush();
                    }
                    $i++;
                    if (count($randomNumbers) * 85 / 100 == $i) {
                        $em->flush();
                        break;
                    }
                }
            }
            if ($difficulty == 2) {
                foreach ($randomNumbers as $rand) {
                    $bilim = new Bilim();
                    $bilim->setStudent($this->getStu()->find($rand));
                    $bilim->setSuroo($item);
                    $em->persist($bilim);
                    if ($i == 100) {
                        $em->flush();
                    }
                    $i++;
                    if (count($randomNumbers) * 60 / 100 == $i) {
                        $em->flush();
                        break;
                    }
                }
            }
            if ($difficulty == 3) {
                foreach ($randomNumbers as $rand) {
                    $bilim = new Bilim();
                    $bilim->setStudent($this->getStu()->find($rand));
                    $bilim->setSuroo($item);
                    $em->persist($bilim);
                    if ($i == 100) {
                        $em->flush();
                    }
                    $i++;
                    if (count($randomNumbers) * 35 / 100 == $i) {
                        $em->flush();
                        break;
                    }
                }
            }
        }
        return $this->redirect($this->generateUrl('bilim_index'));
    }

    public function insertAction($stuId = 1)
    {
        $test = $_POST['test'];
        $test = $this->getDoctrine()->getRepository('BilimBundle:Test')->find($test);
        $suroos = $this->getDoctrine()->getRepository('BilimBundle:Suroo')->findAll();
        $student = $this->getDoctrine()->getRepository('BilimBundle:Student')->findBy(
            array('test' => $test),
            array('id' => 'ASC'));
        $em = $this->getEm();
        $em = $this->getDoctrine()->getEntityManager();
        $min = $suroos[0]->getId();
        $max = $suroos[count($suroos) - 1]->getId();
        $p = 0.16;
        $count = count($student);

        $minStu = $student[0]->getId();
        $maxStu = $student[count($student) - 1]->getId();
        $randomStudent = range($minStu, $maxStu);
        shuffle($randomStudent);

        $arr = array(0.01, 0.03, 0.3, 2.13, 7.24, 12.98, 15.11, 13.86, 11.35, 9.18, 7.49, 5.9, 4.49, 3.41, 2.47, 1.75, 1.15, 0.72, 0.3, 0.12, 0.01);
        $check = 0;
        foreach ($arr as $a) {

            for ($key1 = $check; $key1 < count($randomStudent) * $a / 100; $key1++) {

                $randomNumbers = range($min, $max);
                shuffle($randomNumbers);
                $value = "";


//                dump($key1);
//                dump($randomStudent[$key1]);

                    foreach ($randomNumbers as $key => $ranNum) {

                        $sur = $em->getRepository('BilimBundle:Suroo')->find($ranNum);

                        if ($sur->getDifficulty() == 1) {
                            if (count($randomNumbers) / 3 * $p * 0.6 > $key)
                                if (count($randomNumbers) - 1 == $key) {
                                    $value .= '(' . $ranNum . ',' . $randomStudent[$key1] . ');';
                                } else {
                                    $value .= '(' . $ranNum . ',' . $randomStudent[$key1] . '),';
                                }
                        } elseif ($sur->getDifficulty() == 2) {
                            if (count($randomNumbers) / 3 * $p * 0.3 > $key)
                                if (count($randomNumbers) - 1 == $key) {
                                    $value .= '(' . $ranNum . ',' . $randomStudent[$key1] . ');';
                                } else {
                                    $value .= '(' . $ranNum . ',' . $randomStudent[$key1] . '),';
                                }
                        } elseif ($sur->getDifficulty() == 3) {

                            if (count($randomNumbers) / 3 * $p * 0.1 > $key)
                                if (count($randomNumbers) - 1 == $key) {
                                    $value .= '(' . $ranNum . ',' . $randomStudent[$key1] . ');';
                                } else {
                                    $value .= '(' . $ranNum . ',' . $randomStudent[$key1] . '),';
                                }
                        }


                        $p += 0.04;

                    }

                if ($value != "") {
                    $sql = "Insert into bilim (suroo_id, student_id) VALUES $value";

                    $stmt = $em->getConnection()->prepare($sql);
                    $stmt->execute();
                }
            }

            $check = count($randomStudent) * $a / 100;
//            dump($check);
//            die();



        }

        return $this->redirect($this->generateUrl('bilim_index'));
    }


    public function getRep()
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
