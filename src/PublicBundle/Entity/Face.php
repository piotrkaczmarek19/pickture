<?php

namespace PublicBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Face
 *
 * @ORM\Table(name="face")
 * @ORM\Entity(repositoryClass="PublicBundle\Repository\FaceRepository")
 */
class Face
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
    * @ORM\ManyToOne(targetEntity="Image", inversedBy="faces")
    * @ORM\JoinColumn(name="image_id", referencedColumnName="id", onDelete="CASCADE")
    */
    private $image;

    /**
     * @var int
     *
     * @ORM\Column(name="x", type="integer")
     */
    private $x;

    /**
     * @var int
     *
     * @ORM\Column(name="y", type="integer")
     */
    private $y;

    /**
     * @var int
     *
     * @ORM\Column(name="width", type="integer")
     */
    private $width;

    /**
     * @var int
     *
     * @ORM\Column(name="height", type="integer")
     */
    private $height;


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
     * @return Face
     */
    public function setImageId($imageId)
    {
        $this->imageId = $imageId;

        return $this;
    }

    /**
     * Get imageId
     *
     * @return int
     */
    public function getImageId()
    {
        return $this->imageId;
    }

    /**
     * Set x
     *
     * @param string $x
     *
     * @return Face
     */
    public function setX($x)
    {
        $this->x = $x;

        return $this;
    }

    /**
     * Get x
     *
     * @return string
     */
    public function getX()
    {
        return $this->x;
    }

    /**
     * Set y
     *
     * @param integer $y
     *
     * @return Face
     */
    public function setY($y)
    {
        $this->y = $y;

        return $this;
    }

    /**
     * Get y
     *
     * @return int
     */
    public function getY()
    {
        return $this->y;
    }

    /**
     * Set width
     *
     * @param integer $width
     *
     * @return Face
     */
    public function setWidth($width)
    {
        $this->width = $width;

        return $this;
    }

    /**
     * Get width
     *
     * @return int
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * Set height
     *
     * @param string $height
     *
     * @return Face
     */
    public function setHeight($height)
    {
        $this->height = $height;

        return $this;
    }

    /**
     * Get height
     *
     * @return string
     */
    public function getHeight()
    {
        return $this->height;
    }


    /**
     * Set image
     *
     * @param \PublicBundle\Entity\Image $image
     *
     * @return Face
     */
    public function setImage(\PublicBundle\Entity\Image $image = null)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \PublicBundle\Entity\Image
     */
    public function getImage()
    {
        return $this->image;
    }
}
