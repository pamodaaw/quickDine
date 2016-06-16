<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * restaurant
 *
 * @ORM\Table(name="restaurant")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\restaurantRepository")
 */
class restaurant
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
     * @ORM\Column(name="name", type="string", length=50)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="website_url", type="string", length=100, nullable=true, unique=true)
     */
    private $websiteUrl;
    /**
     * @var int
     *
     * @ORM\Column(name="capacity", type="integer")
     */
    private $capacity;
    /**
     * @var string
     *
     * @ORM\Column(name="rating", type="integer", nullable=false )
     */
    private $rating=0;
    /**
     * @var string
     *
     * @ORM\Column(name="location", type="string", length=200, nullable=true, unique=false)
     */
    private $location;
    /**
     * @var string
     *
     * @ORM\Column(name="contact_number", type="string", length=10)
     */
    private $contactNumber;

    /**
     * @var float
     *
     * @ORM\Column(name="cost_for_two", type="float")
     */
    private $costForTwo;

    /**
     * @var float
     *
     * @ORM\Column(name="loc_lat", type="float")
     */
    private $locLat;

    /**
     * @var float
     *
     * @ORM\Column(name="loc_log", type="float")
     */
    private $locLog;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

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
     * @ORM\OneToMany(targetEntity="meal", mappedBy="rest_ID")
     */
    private $meals;

    /**
     * @ORM\OneToMany(targetEntity="offer", mappedBy="rest_ID")
     */
    private $offers;

    /**
     * @ORM\OneToOne(targetEntity="registered_user")
     * @ORM\JoinColumn(name="userID", referencedColumnName="id")
     */
    private $userID;

    /**
     * @var bool
     *
     * @ORM\Column(name="activate", type="boolean")
     */
    private $activate=0;




    public function __construct() {
        $this->meals = new ArrayCollection();
        $this->offers = new ArrayCollection();
    }
   

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
     * Set name
     *
     * @param string $name
     *
     * @return restaurant
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
     * Set websiteUrl
     *
     * @param string $websiteUrl
     *
     * @return restaurant
     */
    public function setWebsiteUrl($websiteUrl)
    {
        $this->websiteUrl = $websiteUrl;

        return $this;
    }

    /**
     * Get websiteUrl
     *
     * @return string
     */
    public function getWebsiteUrl()
    {
        return $this->websiteUrl;
    }

    /**
     * Set location
     *
     * @param string $location
     *
     * @return restaurant
     */
    public function setLocation($location)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * Get location
     *
     * @return string
     */
    public function getLocation()
    {
        return $this->location;
    }
    /**
     * Set contactNumber
     *
     * @param string $contactNumber
     *
     * @return restaurant
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
     * Set costForTwo
     *
     * @param float $costForTwo
     *
     * @return restaurant
     */
    public function setCostForTwo($costForTwo)
    {
        $this->costForTwo = $costForTwo;

        return $this;
    }

    /**
     * Get costForTwo
     *
     * @return float
     */
    public function getCostForTwo()
    {
        return $this->costForTwo;
    }

    /**
     * Set locLat
     *
     * @param float $locLat
     *
     * @return restaurant
     */
    public function setLocLat($locLat)
    {
        $this->locLat = $locLat;

        return $this;
    }

    /**
     * Get locLat
     *
     * @return float
     */
    public function getLocLat()
    {
        return $this->locLat;
    }

    /**
     * Set locLog
     *
     * @param float $locLog
     *
     * @return restaurant
     */
    public function setLocLog($locLog)
    {
        $this->locLog = $locLog;

        return $this;
    }

    /**
     * Get locLog
     *
     * @return float
     */
    public function getLocLog()
    {
        return $this->locLog;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return restaurant
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }


    /**
     * Add meal
     *
     * @param \AppBundle\Entity\meal $meal
     *
     * @return restaurant
     */
    public function addMeal(\AppBundle\Entity\meal $meal)
    {
        $this->meals[] = $meal;

        return $this;
    }

    /**
     * Remove meal
     *
     * @param \AppBundle\Entity\meal $meal
     */
    public function removeMeal(\AppBundle\Entity\meal $meal)
    {
        $this->meals->removeElement($meal);
    }

    /**
     * Get meals
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMeals()
    {
        return $this->meals;
    }

    /**
     * Add offer
     *
     * @param \AppBundle\Entity\offer $offer
     *
     * @return restaurant
     */
    public function addOffer(\AppBundle\Entity\offer $offer)
    {
        $this->offers[] = $offer;

        return $this;
    }

    /**
     * Remove offer
     *
     * @param \AppBundle\Entity\offer $offer
     */
    public function removeOffer(\AppBundle\Entity\offer $offer)
    {
        $this->offers->removeElement($offer);
    }

    /**
     * Get offers
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOffers()
    {
        return $this->offers;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return restaurant
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
     * Set capacity
     *
     * @param integer $capacity
     *
     * @return restaurant
     */
    public function setCapacity($capacity)
    {
        $this->capacity = $capacity;

        return $this;
    }

    /**
     * Get capacity
     *
     * @return integer
     */
    public function getCapacity()
    {
        return $this->capacity;
    }

    /**
     * Set rating
     *
     * @param integer $rating
     *
     * @return restaurant
     */
    public function setRating($rating)
    {
        $this->rating = $rating;

        return $this;
    }

    /**
     * Get rating
     *
     * @return integer
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * Set activate
     *
     * @param boolean $activate
     *
     * @return restaurant
     */
    public function setActivate($activate)
    {
        $this->activate = $activate;

        return $this;
    }

    /**
     * Get activate
     *
     * @return boolean
     */
    public function getActivate()
    {
        return $this->activate;
    }

    /**
     * Set userID
     *
     * @param \AppBundle\Entity\registered_user $userID
     *
     * @return restaurant
     */
    public function setUserID(\AppBundle\Entity\registered_user $userID = null)
    {
        $this->userID = $userID;

        return $this;
    }

    /**
     * Get userID
     *
     * @return \AppBundle\Entity\registered_user
     */
    public function getUserID()
    {
        return $this->userID;
    }
}
