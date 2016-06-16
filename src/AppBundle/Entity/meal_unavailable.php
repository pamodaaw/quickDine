<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * meal_unavailable
 *
 * @ORM\Table(name="meal_unavailable")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\meal_unavailableRepository")
 */
class meal_unavailable
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /*
     * @ORM\ManyToOne(targetEntity="meal", inversedBy="unavailability")
     * @ORM\JoinColumn(name="meal_ID", referencedColumnName="id")
     */
    private $mealID;

    /**
     * @var string
     *
     * @ORM\Column(name="day", type="string", length=15)
     */
    private $day;

    /**
     * @var int
     *
     * @ORM\Column(name="timeslot", type="integer")
     */
    //timeslots= 1->morning 2->noon 3-> dinner 4- wholeday
    private $timeslot;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set mealID
     *
     * @param integer $mealID
     *
     * @return meal_unavailable
     */
    public function setMealID($mealID)
    {
        $this->mealID = $mealID;

        return $this;
    }

    /**
     * Get mealID
     *
     * @return int
     */
    public function getMealID()
    {
        return $this->mealID;
    }

    /**
     * Set day
     *
     * @param string $day
     *
     * @return meal_unavailable
     */
    public function setDay($day)
    {
        $this->day = $day;

        return $this;
    }

    /**
     * Get day
     *
     * @return string
     */
    public function getDay()
    {
        return $this->day;
    }

    /**
     * Set timeslot
     *
     * @param integer $timeslot
     *
     * @return meal_unavailable
     */
    public function setTimeslot($timeslot)
    {
        $this->timeslot = $timeslot;

        return $this;
    }

    /**
     * Get timeslot
     *
     * @return int
     */
    public function getTimeslot()
    {
        return $this->timeslot;
    }
}
