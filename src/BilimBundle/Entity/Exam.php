<?php

namespace BilimBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Exam
 *
 * @ORM\Table(name="exam")
 * @ORM\Entity(repositoryClass="BilimBundle\Repository\ExamRepository")
 */
class Exam
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="BilimBundle\Entity\Test",cascade={"persist"})
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="test_id", referencedColumnName="id")
     * })
     */
    private $test;


    /**
     * @var string
     *
     * @ORM\Column(name="suroo", type="array", nullable=true)
     */
    private $suroo;

    public function __construct() {
        $suroo = array();
        $this->suroo = $suroo;
    }


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getTest()
    {
        return $this->test;
    }

    /**
     * @param mixed $test
     */
    public function setTest($test)
    {
        $this->test = $test;
    }

    /**
     * @return mixed
     */
    public function getSuroo()
    {
        return $this->suroo;
    }

    /**
     * @param mixed $suroo
     */
    public function setSuroo($suroo)
    {
        $this->suroo = $suroo;
    }

}
