<?php

namespace IhebBundle\Entity;

use AppBundle\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Club
 *
 * @ORM\Table(name="club")
 * @ORM\Entity(repositoryClass="IhebBundle\Repository\ClubRepository")
 */
class Club
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
     * @ORM\Column(name="nameClub", type="string", length=255)
     */
    private $nameClub;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateCreationClub", type="date")
     */
    private $dateCreationClub;

    /**
     * @var string
     *
     * @ORM\Column(name="typeClub", type="string", length=255)
     */
    private $typeClub;

    /**
     * @var string
     *
     * @ORM\Column(name="statusClub", type="string", length=255)
     */
    private $statusClub;

    /**
     * @var string
     *
     * @ORM\Column(name="descriptionClub", type="string", length=255)
     */
    private $descriptionClub;


    /**
     * Many Clubs have Many Users.
     * @ORM\ManyToMany(targetEntity="\AppBundle\Entity\User",cascade={"remove"})
     * @ORM\JoinTable(name="clubs_users",
     *      joinColumns={@ORM\JoinColumn(name="club_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")}
     *      )
     */
    private $membersClub;

    /**
     *  One userAdmin has Many club .
     * @ORM\ManyToOne(targetEntity="\AppBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="admin_id", referencedColumnName="id")
     * })
     */
    private $adminClub;


    /**
     * @ORM\Column(type="string")
     *
     * @Assert\NotBlank(message="Please, upload the product brochure as a PDF file.")
     * @Assert\File(mimeTypes={ "application/pdf" })
     */
    private $photoClub;



    public function __construct()
    {
        $this->membersClub = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function addMember(User $user)
    {
        $this->membersClub[] = $user;
    }

    public function findMembre(User $user){
        if ($this->membersClub->contains($user)) {
            return true;
        }
    }


    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getNameClub()
    {
        return $this->nameClub;
    }

    /**
     * @param string $nameClub
     */
    public function setNameClub($nameClub)
    {
        $this->nameClub = $nameClub;
    }

    /**
     * @return \DateTime
     */
    public function getDateCreationClub()
    {
        return $this->dateCreationClub;
    }

    /**
     * @param \DateTime $dateCreationClub
     */
    public function setDateCreationClub($dateCreationClub)
    {
        $this->dateCreationClub = $dateCreationClub;
    }

    /**
     * @return string
     */
    public function getTypeClub()
    {
        return $this->typeClub;
    }

    /**
     * @param string $typeClub
     */
    public function setTypeClub($typeClub)
    {
        $this->typeClub = $typeClub;
    }

    /**
     * @return string
     */
    public function getDescriptionClub()
    {
        return $this->descriptionClub;
    }

    /**
     * @param string $descriptionClub
     */
    public function setDescriptionClub($descriptionClub)
    {
        $this->descriptionClub = $descriptionClub;
    }

    /**
     * @return string
     */
    public function getMembersClub()
    {
        return $this->membersClub;
    }

    /**
     * @param string $membersClub
     */
    public function setMembersClub($membersClub)
    {
        $this->membersClub = $membersClub;
    }

    /**
     * @return string
     */
    public function getAdminClub()
    {
        return $this->adminClub;
    }

    /**
     * @param string $adminClub
     */
    public function setAdminClub($adminClub)
    {
        $this->adminClub = $adminClub;
    }

    /**
     * @return string
     */
    public function getStatusClub()
    {
        return $this->statusClub;
    }

    /**
     * @param string $statusClub
     */
    public function setStatusClub($statusClub)
    {
        $this->statusClub = $statusClub;
    }

    /**
     * @return mixed
     */
    public function getPhotoClub()
    {
        return $this->photoClub;
    }

    /**
     * @param mixed $photoClub
     */
    public function setPhotoClub($photoClub)
    {
        $this->photoClub = $photoClub;
    }
}

