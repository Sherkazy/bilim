<?php

namespace BilimBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Suroo
 *
 * @ORM\Table(name="suroo")
 * @ORM\Entity(repositoryClass="BilimBundle\Repository\SurooRepository")
 */
class Suroo
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
     * @ORM\ManyToOne(targetEntity="BilimBundle\Entity\Subject", cascade={"persist"})
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="subject_id", referencedColumnName="id")
     * })
     */
    private $subject;

    /**
     * @ORM\ManyToOne(targetEntity="BilimBundle\Entity\Suroo", inversedBy="suroo")
     * @ORM\JoinColumn(name="exam_id", referencedColumnName="id")
     */
    private $exam;

    /**
     * @var int
     *
     * @ORM\Column(name="difficulty", type="integer")
     */
    private $difficulty;

    public function __toString()
    {
        return $this->getId()."-суроо";
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
     * @return int
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @param int $subject
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    /**
     * @return int
     */
    public function getDifficulty()
    {
        return $this->difficulty;
    }

    /**
     * @param int $difficulty
     */
    public function setDifficulty($difficulty)
    {
        $this->difficulty = $difficulty;
    }

    /**
     * @return mixed
     */
    public function getExam()
    {
        return $this->exam;
    }

    /**
     * @param mixed $exam
     */
    public function setExam($exam)
    {
        $this->exam = $exam;
    }
}
