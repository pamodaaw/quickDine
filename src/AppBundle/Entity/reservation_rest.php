<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * reservation_rest
 *
 * @ORM\Table(name="reservation_rest")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\reservation_restRepository")
 */
class reservation_rest
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
     * @ORM\ManyToOne(targetEntity="restaurant" )
     * @ORM\JoinColumn(name="rest_ID", referencedColumnName="id")
     */
    private $restID;

    /**
     * @var \DateTime
     * @Assert\Date()
     * @Assert\GreaterThanOrEqual("today")
     * @Assert\LessThan("+7 days")
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
     * @var \DateTime
     * @Assert\Time()
     * @ORM\Column(name="start_time", type="time")
     */
    private $startTime;

    /**
     * @var \DateTime
     * @Assert\Time()
     * @ORM\Column(name="end_time", type="time")
     */
    private $endTime;

    /**
     * @var int
     * @Assert\Type(
     *     type="integer",
     *     message="The value {{ value }} is not a valid {{ type }}."
     * )
     * @Assert\Range(
     *      min = 0,
     *      max = 15,
     *      minMessage = "Enter valid amount",
     *      maxMessage = "Reservations above 15 can not be made online"
     * )
     * @ORM\Column(name="no_of_people", type="integer")
     */
    private $noOfPeople;

    /**
     * @var int
     *
     * @ORM\Column(name="expected_hours", type="integer")
     */
    private $expectedHours;

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
     * Set restID
     *
     * @param integer $restID
     *
     * @return reservation_rest
     */
    public function setRestID($restID)
    {
        $this->restID = $restID;

        return $this;
    }

    /**
     * Get restID
     *
     * @return int
     */
    public function getRestID()
    {
        return $this->restID;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return reservation_rest
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
     * Set noOfPeople
     *
     * @param integer $noOfPeople
     *
     * @return reservation_rest
     */
    public function setNoOfPeople($noOfPeople)
    {
        $this->noOfPeople = $noOfPeople;

        return $this;
    }

    /**
     * Get noOfPeople
     *
     * @return int
     */
    public function getNoOfPeople()
    {
        return $this->noOfPeople;
    }

    /**
     * Set expectedHours
     *
     * @param integer $expectedHours
     *
     * @return reservation_rest
     */
    public function setExpectedHours($expectedHours)
    {
        $this->expectedHours = $expectedHours;

        return $this;
    }

    /**
     * Get expectedHours
     *
     * @return int
     */
    public function getExpectedHours()
    {
        return $this->expectedHours;
    }

    /**
     * Set confirmation
     *
     * @param boolean $confirmation
     *
     * @return reservation_rest
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
     * @return reservation_rest
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
     * @return reservation_rest
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
     * @return reservation_rest
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

    /**
     * Set startTime
     *
     * @param \DateTime $startTime
     *
     * @return reservation_rest
     */
    public function setStartTime($startTime)
    {
        $this->startTime = $startTime;

        return $this;
    }

    /**
     * Get startTime
     *
     * @return \DateTime
     */
    public function getStartTime()
    {
        return $this->startTime;
    }

    /**
     * Set endTime
     *
     * @param \DateTime $endTime
     *
     * @return reservation_rest
     */
    public function setEndTime($endTime)
    {
        $this->endTime = $endTime;

        return $this;
    }

    /**
     * Get endTime
     *
     * @return \DateTime
     */
    public function getEndTime()
    {
        return $this->endTime;
    }
}
