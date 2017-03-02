<?php

namespace BilimBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Bilim
 *
 * @ORM\Table(name="bilim")
 * @ORM\Entity(repositoryClass="BilimBundle\Repository\BilimRepository")
 */
class Bilim
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
     * @ORM\ManyToOne(targetEntity="BilimBundle\Entity\Suroo",cascade={"persist"})
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="suroo_id", referencedColumnName="id")
     * })
     */
    private $suroo;

    /**
     * @ORM\ManyToOne(targetEntity="BilimBundle\Entity\Student",cascade={"persist"})
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="student_id", referencedColumnName="id")
     * })
     */
    private $student;


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

    /**
     * @return mixed
     */
    public function getStudent()
    {
        return $this->student;
    }

    /**
     * @param mixed $student
     */
    public function setStudent($student)
    {
        $this->student = $student;
    }

}
