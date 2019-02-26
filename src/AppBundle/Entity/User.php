<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

<<<<<<< HEAD
=======
    public function __construct()
    {
        parent::__construct();
        // your own logic
    }
>>>>>>> 30a24b2eed29a611d0978ac1882dfb4a47f00c2c

    /**
     * @var string
     *
     * @ORM\Column(name="firstName", type="string", length=255)
     */
    private $firstName;

<<<<<<< HEAD

    public function __construct()
=======
    /**
     * @var string
     *
     * @ORM\Column(name="lastName", type="string", length=255)
     */
    private $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="descriptionUser", type="string", length=255)
     */
    private $descriptionUser;

    /**
     * @return string
     */
    public function getDescriptionUser()
>>>>>>> 30a24b2eed29a611d0978ac1882dfb4a47f00c2c
    {
        return $this->descriptionUser;
    }

    /**
     * @param string $descriptionUser
     */
    public function setDescriptionUser($descriptionUser)
    {
        $this->descriptionUser = $descriptionUser;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    public function __toString()
    {
        return (string) $this->getUsername();

    }


}

