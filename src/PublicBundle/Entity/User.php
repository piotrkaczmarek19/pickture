<?php

namespace PublicBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="PublicBundle\Repository\UserRepository")
 * @UniqueEntity(fields="username", message="A user with this username already exists")
 */
class User implements AdvancedUserInterface, \Serializable
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
     * @var string $username
     * @Assert\NotBlank()
     * 
     * @ORM\Column(name="username", type="string", length=25, unique=true)
     */
    private $username;

    /**
     * @var string 
     * @ORM\Column(name="password", type="string", length=64)
     */
    private $password;
    /**
     * @Assert\NotBlank()
     * @Assert\Length(max = 4096)
     */
    private $plainPassword;
    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Email()
     * @ORM\Column(name="email", type="string", length=60, unique=true)
     */
    private $email;
    /**
    * @var string
    * @ORM\Column(name="roles", type="string", length=60, options={"default": "ROLE_USER"})
    */
    private $roles;
    /**
     * @var \DateTime
     * @ORM\Column(name="joined", type="datetime")
     */
    private $joined;
    /**
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;
    /**
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="user", cascade={"remove"})
     */
    private $comments;

    /**
     * @ORM\OneToMany(targetEntity="Image", mappedBy="user", cascade={"remove"})
     */
    private $images;
    /**
     * @ORM\ManyToOne(targetEntity="Theme", inversedBy="users")
     * @ORM\JoinColumn(name="theme_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $theme;

    /**
     * @ORM\ManyToMany(targetEntity="Image", inversedBy="voters")
     * @ORM\JoinTable(name="users_images_voted")
     */
    private $images_voted;

    /**
     * @var string
     * @ORM\Column(name="activation", type="string")
     */
    private $activation;

    public function __construct()
    {
        $this->isActive = true;
        $this->comments = new ArrayCollection();
        $this->images = new ArrayCollection();
        $this->images_voted = new ArrayCollection();
        $this->roles = "ROLE_USER";
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
     * Set username
     *
     * @param string $username
     *
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }


    /**
     * Set email
     *
     * @param string $email
     *
     * @return User
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
     * Set theme
     *
     * @param string $theme
     *
     * @return User
     */
    public function setTheme($theme)
    {
        $this->theme = $theme;

        return $this;
    }

    /**
     * Get theme
     *
     * @return string
     */
    public function getTheme()
    {
        return $this->theme;
    }

    /**
     * @ORM\PrePersist
     */
    public function setJoinedValue(){
        $this->joined = new \DateTime();
    }
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
            $this->isActive
        ));
    }

    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
            $this->isActive
            ) = unserialize($serialized);
    }

    // UserInterface
    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }
    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    public function setPlainPassword($password)
    {
        $this->plainPassword = $password;
    }
    public function getRoles()
    {
        return array($this->roles);
    }
    public function getSalt()
    {
        return null;
    }
    public function eraseCredentials()
    {
    }

    public function isAccountNonExpired()
    {
        return true;
    }

    public function isAccountNonLocked()
    {
        return true;
    }

    public function isCredentialsNonExpired()
    {
        return true;
    }

    public function isEnabled()
    {
        return $this->isActive;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return User
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Add comment
     *
     * @param \PublicBundle\Entity\Comment $comment
     *
     * @return User
     */
    public function addComment(\PublicBundle\Entity\Comment $comment)
    {
        $this->comments[] = $comment;

        return $this;
    }

    /**
     * Remove comment
     *
     * @param \PublicBundle\Entity\Comment $comment
     */
    public function removeComment(\PublicBundle\Entity\Comment $comment)
    {
        $this->comments->removeElement($comment);
    }

    /**
     * Get comments
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Add image
     *
     * @param \PublicBundle\Entity\Image $image
     *
     * @return User
     */
    public function addImage(\PublicBundle\Entity\Image $image)
    {
        $this->images[] = $image;

        return $this;
    }

    /**
     * Remove image
     *
     * @param \PublicBundle\Entity\Image $image
     */
    public function removeImage(\PublicBundle\Entity\Image $image)
    {
        $this->images->removeElement($image);
    }

    /**
     * Get images
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * Set joined
     *
     * @param \DateTime $joined
     *
     * @return User
     */
    public function setJoined($joined)
    {
        $this->joined = $joined;

        return $this;
    }

    /**
     * Get joined
     *
     * @return \DateTime
     */
    public function getJoined()
    {
        return $this->joined;
    }



    /**
     * Add imagesVoted
     *
     * @param \PublicBundle\Entity\Image $imagesVoted
     *
     * @return User
     */
    public function addImagesVoted(\PublicBundle\Entity\Image $imagesVoted)
    {
        $this->images_voted[] = $imagesVoted;

        return $this;
    }

    /**
     * Remove imagesVoted
     *
     * @param \PublicBundle\Entity\Image $imagesVoted
     */
    public function removeImagesVoted(\PublicBundle\Entity\Image $imagesVoted)
    {
        $this->images_voted->removeElement($imagesVoted);
    }

    /**
     * Get imagesVoted
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getImagesVoted()
    {
        return $this->images_voted;
    }

    /**
     * Set activation
     *
     * @param string $activation
     *
     * @return User
     */
    public function setActivation($activation)
    {
        $this->activation = $activation;

        return $this;
    }

    /**
     * Get activation
     *
     * @return string
     */
    public function getActivation()
    {
        return $this->activation;
    }
}
