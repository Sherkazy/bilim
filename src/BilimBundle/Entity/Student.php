<?php

namespace BilimBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Student
 *
 * @ORM\Table(name="student")
 * @ORM\Entity(repositoryClass="BilimBundle\Repository\StudentRepository")
 */
class Student
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="BilimBundle\Entity\Region",cascade={"persist"})
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="region_id", referencedColumnName="id")
     * })
     */
    private $region;

    /**
     * @var float
     *
     * @ORM\Column(name="science", type="float")
     */
    private $science;

    /**
     * @var float
     *
     * @ORM\Column(name="humanitary", type="float")
     */
    private $humanitary;

    /**
     * @var float
     *
     * @ORM\Column(name="general", type="float")
     */
    private $general;

    /**
     * @ORM\ManyToOne(targetEntity="BilimBundle\Entity\Test",cascade={"persist"})
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="test_id", referencedColumnName="id")
     * })
     */
    private $test;



    public function __toString()
    {
        return $this->getName();
        // TODO: Implement __toString() method.
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
     * Set name
     *
     * @param string $name
     * @return Student
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set state
     *
     * @param integer $state
     * @return Student
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }


    /**
     * Set average
     *
     * @param float $average
     * @return Student
     */
    public function setAverage($average)
    {
        $this->average = $average;

        return $this;
    }

    /**
     * Get average
     *
     * @return float
     */
    public function getAverage()
    {
        return $this->average;
    }

    /**
     * @return float
     */
    public function getScience()
    {
        return $this->science;
    }

    /**
     * @param float $science
     */
    public function setScience($science)
    {
        $this->science = $science;
    }

    /**
     * @return float
     */
    public function getHumanitary()
    {
        return $this->humanitary;
    }

    /**
     * @param float $humanitary
     */
    public function setHumanitary($humanitary)
    {
        $this->humanitary = $humanitary;
    }

    /**
     * @return float
     */
    public function getGeneral()
    {
        return $this->general;
    }

    /**
     * @param float $general
     */
    public function setGeneral($general)
    {
        $this->general = $general;
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
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * @param mixed $region
     */
    public function setRegion($region)
    {
        $this->region = $region;
    }
}
