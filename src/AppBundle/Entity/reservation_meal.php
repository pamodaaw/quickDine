<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * reservation_meal
 *
 * @ORM\Table(name="reservation_meal")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\reservation_mealRepository")
 */
class reservation_meal
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
     * @ORM\ManyToOne(targetEntity="meal" )
     * @ORM\JoinColumn(name="meal_ID", referencedColumnName="id")
     */
    private $mealID;

    /**
     * @var \DateTime
     * @Assert\Date()
     * @Assert\GreaterThanOrEqual("today")
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
     * @var \DateTime
     * @Assert\Time()
     * @ORM\Column(name="time", type="time")
     */
    private $time;

    /**
     * @var int
     *
     * @Assert\Type(
     *     type="integer",
     *     message="The value {{ value }} is not a valid {{ type }}."
     * )
    * @Assert\Range(
     *      min = 0,
     *      max = 10,
     *      minMessage = "Enter valid amount",
     *      maxMessage = "Reservations above 10 can not be made online"
     * )
     * @ORM\Column(name="no_of_items", type="integer")
     */

    private $noOfItems;

    /**
     * @var bool
     *
     * @ORM\Column(name="confirmation", type="boolean")
     */
    private $confirmation= False;

    /**
     * @var string
     *
     * @ORM\Column(name="customer_name", type="string", length=200)
     */
    private $customerName;

    /**
     * @var string
     *
     * @Assert\Email(
     *     message = "This is not a valid email.",
     *     checkMX = true
     * )
     * @ORM\Column(name="email", type="string", length=200)
     */
    private $email;

    /**
     * @var string
     * @Assert\Type(
     *      type="digit",
     *      message="Enter a valid phone number"
     * )
     * @Assert\Length(
     *      min = 9,
     *      max = 10,
     *      minMessage = "Enter a valid phone number." ,
     *      maxMessage = "Enter a valid phone number."
     * )
     * @ORM\Column(name="contact_number", type="string", length=10)
     */
    private $contactNumber;


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
     * @return reservation_meal
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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return reservation_meal
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set time
     *
     * @param \DateTime $time
     *
     * @return reservation_meal
     */
    public function setTime($time)
    {
        $this->time = $time;

        return $this;
    }

    /**
     * Get time
     *
     * @return \DateTime
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * Set noOfItems
     *
     * @param integer $noOfItems
     *
     * @return reservation_meal
     */
    public function setNoOfItems($noOfItems)
    {
        $this->noOfItems = $noOfItems;

        return $this;
    }

    /**
     * Get noOfItems
     *
     * @return int
     */
    public function getNoOfItems()
    {
        return $this->noOfItems;
    }

    /**
     * Set confirmation
     *
     * @param boolean $confirmation
     *
     * @return reservation_meal
     */
    public function setConfirmation($confirmation)
    {
        $this->confirmation = $confirmation;

        return $this;
    }

    /**
     * Get confirmation
     *
     * @return bool
     */
    public function getConfirmation()
    {
        return $this->confirmation;
    }

    /**
     * Set customerName
     *
     * @param string $customerName
     *
     * @return reservation_meal
     */
    public function setCustomerName($customerName)
    {
        $this->customerName = $customerName;

        return $this;
    }

    /**
     * Get customerName
     *
     * @return string
     */
    public function getCustomerName()
    {
        return $this->customerName;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return reservation_meal
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set contactNumber
     *
     * @param string $contactNumber
     *
     * @return reservation_meal
     */
    public function setContactNumber($contactNumber)
    {
        $this->contactNumber = $contactNumber;

        return $this;
    }

    /**
     * Get contactNumber
     *
     * @return string
     */
    public function getContactNumber()
    {
        return $this->contactNumber;
    }
}
