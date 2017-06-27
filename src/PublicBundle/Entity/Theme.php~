<?php

namespace PublicBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Theme
 *
 * @ORM\Table(name="theme")
 * @ORM\Entity(repositoryClass="PublicBundle\Repository\ThemeRepository")
 */
class Theme
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
     * @ORM\Column(name="name", type="string", length=65, unique=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="mask", type="string", length=255, unique=true)
     */
    private $mask;
    /**
     * @ORM\OneToMany(targetEntity="User", mappedBy="theme")
     */
    private $users;

    public function __construct(){
        $this->users = new ArrayCollection;
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
     * @return Theme
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
     * Set mask
     *
     * @param string $mask
     *
     * @return Theme
     */
    public function setMask($mask)
    {
        $this->mask = $mask;

        return $this;
    }

    /**
     * Get mask
     *
     * @return string
     */
    public function getMask()
    {
        return $this->mask;
    }

    /**
     * Set user
     *
     * @param \PublicBundle\Entity\User $user
     *
     * @return Theme
     */
    public function setUser(\PublicBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \PublicBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Add user
     *
     * @param \PublicBundle\Entity\User $user
     *
     * @return Theme
     */
    public function addUser(\PublicBundle\Entity\User $user)
    {
        $this->users[] = $user;

        return $this;
    }

    /**
     * Remove user
     *
     * @param \PublicBundle\Entity\User $user
     */
    public function removeUser(\PublicBundle\Entity\User $user)
    {
        $this->users->removeElement($user);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsers()
    {
        return $this->users;
    }
}
