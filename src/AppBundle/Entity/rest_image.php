<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * rest_image
 *
 * @ORM\Table(name="rest_image")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\rest_imageRepository")
 */
class rest_image
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
     * @var int
     *
     * @ORM\Column(name="rest_ID", type="integer")
     */
    private $restID;


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
     * Set imageId
     *
     * @param integer $imageId
     *
     * @return rest_image
     */
    public function setImageId($imageId)
    {
        $this->imageId = $imageId;

        return $this;
    }


    /**
     * Set restID
     *
     * @param integer $restID
     *
     * @return rest_image
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
}
