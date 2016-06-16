<?php

namespace AppBundle\Entity;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * meal
 *
 * @ORM\Table(name="meal")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\mealRepository")
 */
class meal
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
     * @ORM\Column(name="code", type="string", length=5)
     */
    private $code;

    /**
     * @ORM\ManyToOne(targetEntity="cuisine")
     * @ORM\JoinColumn(name="cuisine_ID", referencedColumnName="id")
     */
    private $cuisineID;

    /**
     * @ORM\ManyToOne(targetEntity="restaurant")
     * @ORM\JoinColumn(name="rest_ID", referencedColumnName="id")
     */
    private $restID;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     *
     * @var string
     *
     * @ORM\Column(name="path", type="text", length=255, nullable=false)
     */
    protected $path;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=50)
     */
    private $name;

    /**
     * @var float
     *
     * @ORM\Column(name="cost_for_two", type="float")
     */
    private $costForTwo;

    /**
     * @var bool
     *
     * @ORM\Column(name="availability", type="boolean")
     */
    private $availability;


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
     * Set code
     *
     * @param string $code
     *
     * @return meal
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set cuisineID
     *
     * @param integer $cuisineID
     *
     * @return meal
     */
    public function setCuisineID($cuisineID)
    {
        $this->cuisineID = $cuisineID;

        return $this;
    }

    /**
     * Get cuisineID
     *
     * @return int
     */
    public function getCuisineID()
    {
        return $this->cuisineID;
    }

    /**
     * Set restID
     *
     * @param integer $restID
     *
     * @return meal
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
     * Set description
     *
     * @param string $description
     *
     * @return meal
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
     * Set name
     *
     * @param string $name
     *
     * @return meal
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
     * Set path
     *
     * @param string $path
     *
     * @return meal
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    public function getAbsolutePath()
    {
        return null === $this->path
            ? null
            : $this->getUploadRootDir().'/'.$this->path;
    }

    public function getWebPath()
    {
        return null === $this->path
            ? null
            : $this->getUploadDir().'/'.$this->path;
    }

    protected function getUploadRootDir()
    {
        // the absolute directory path where uploaded
        // documents should be saved
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw up
        // when displaying uploaded doc/image in the view.
        return 'uploads/images';
    }

    /**
     * Set availability
     *
     * @param boolean $availability
     *
     * @return meal
     */
    public function setAvailability($availability)
    {
        $this->availability = $availability;

        return $this;
    }

    /**
     * Get availability
     *
     * @return boolean
     */
    public function getAvailability()
    {
        return $this->availability;
    }
}
