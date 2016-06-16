<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * offer
 *
 * @ORM\Table(name="offer")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\offerRepository")
 */
class offer
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
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="available", type="string", length=150)
     */
    private $available;

    /**
     * @var string
     *
     * @ORM\Column(name="catch_line", type="string", length=100)
     */
    private $catchLine;


    /**
     * @ORM\ManyToOne(targetEntity="restaurant")
     * @ORM\JoinColumn(name="rest_ID", referencedColumnName="id")
     */
    private $restID;

    /**
     *
     * @var string
     *
     * @ORM\Column(name="image_path", type="text", length=255, nullable=false)
     */
    protected $image_path;


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
     * Set description
     *
     * @param string $description
     *
     * @return offer
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
     * Set available
     *
     * @param string $available
     *
     * @return offer
     */
    public function setAvailable($available)
    {
        $this->available = $available;

        return $this;
    }

    /**
     * Get available
     *
     * @return string
     */
    public function getAvailable()
    {
        return $this->available;
    }

    /**
     * Set catchLine
     *
     * @param string $catchLine
     *
     * @return offer
     */
    public function setCatchLine($catchLine)
    {
        $this->catchLine = $catchLine;

        return $this;
    }

    /**
     * Get catchLine
     *
     * @return string
     */
    public function getCatchLine()
    {
        return $this->catchLine;
    }



    /**
     * Set restID
     *
     * @param \AppBundle\Entity\restaurant $restID
     *
     * @return offer
     */
    public function setRestID(\AppBundle\Entity\restaurant $restID = null)
    {
        $this->restID = $restID;

        return $this;
    }

    /**
     * Get restID
     *
     * @return \AppBundle\Entity\restaurant
     */
    public function getRestID()
    {
        return $this->restID;
    }

    /**
     * Set imagePath
     *
     * @param string $imagePath
     *
     * @return offer
     */
    public function setImagePath($imagePath)
    {
        $this->image_path = $imagePath;

        return $this;
    }

    /**
     * Get imagePath
     *
     * @return string
     */
    public function getImagePath()
    {
        return $this->image_path;
    }
}
