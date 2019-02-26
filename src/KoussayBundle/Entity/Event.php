<?php

namespace KoussayBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert ;



/**
 * Event
 *
 * @ORM\Table(name="event")
 * @ORM\Entity(repositoryClass="KoussayBundle\Repository\EventRepository")
 * @Vich\Uploadable
 */
class Event
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
     * @ORM\Column(name="titre", type="string", length=255)
     */
    private $titre;


    /**
     * @var string
     *
     * @ORM\Column(name="etat", type="string", length=255)
     */
    private $etat;




    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="image1", type="string", length=255)
     */
    private $image1;


    /**
 * @var string
 *
 * @ORM\Column(name="description", type="string", length=255)
 */
    private $description;
    /**
     * @var float
     *
     * @ORM\Column(name="note", type="float")
     */
    private $note;

    /**
     * @var string
     *
     * @ORM\Column(name="lieu", type="string", length=255)
     */
    private $lieu;

    /**
     * @var int
     *
     * @ORM\Column(name="nbparticipants", type="integer")
     */
    private $nbparticipants;



    /**
     * @var string
     *
     * @ORM\Column(name="pub", type="string", length=255)
     */
    private $pub;

    /**
     * @ORM\ManyToOne(targetEntity="\IhebBundle\Entity\Club")
     * @ORM\JoinColumn(name="club",referencedColumnName="id")
     */
    private $club;

    /**
     * @return mixed
     */
    public function getClub()
    {
        return $this->club;
    }

    /**
     * @param mixed $club
     */
    public function setClub($club)
    {
        $this->club = $club;
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
     * Set titre
     *
     * @param string $titre
     *
     * @return Event
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set image1
     *
     * @param string $image1
     *
     * @return Event
     */
    public function setImage1($image1)
    {
        $this->image1 = $image1;

        return $this;
    }

    /**
     * Get image1
     *
     * @return string
     */
    public function getImage1()
    {
        return $this->image1;
    }




    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Event
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
     * Set description
     *
     * @param string $description
     *
     * @return Event
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
     * Set note
     *
     * @param float $note
     *
     * @return Event
     */
    public function setNote($note)
    {
        $this->note = $note;

        return $this;
    }

    /**
     * Get note
     *
     * @return float
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Set lieu
     *
     * @param string $lieu
     *
     * @return Event
     */
    public function setLieu($lieu)
    {
        $this->lieu = $lieu;

        return $this;
    }

    /**
     * Get lieu
     *
     * @return string
     */
    public function getLieu()
    {
        return $this->lieu;
    }

    /**
     * Set nbparticipants
     *
     * @param integer $nbparticipants
     *
     * @return Event
     */
    public function setNbparticipants($nbparticipants)
    {
        $this->nbparticipants = $nbparticipants;

        return $this;
    }

    /**
     * Get nbparticipants
     *
     * @return int
     */
    public function getNbparticipants()
    {
        return $this->nbparticipants;
    }

    /**
     * Set pub
     *
     * @param string $pub
     *
     * @return Event
     */
    public function setPub($pub)
    {
        $this->pub = $pub;

        return $this;
    }

    /**
     * Get pub
     *
     * @return string
     */
    public function getPub()
    {
        return $this->pub;
    }
    /**
     * Set etat
     *
     * @param string $etat
     *
     * @return Event
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * Get etat
     *
     * @return string
     */
    public function getEtat()
    {
<<<<<<< HEAD
        return (string)$this->getId() ;
        // TODO: Implement __toString() method.
=======
        return $this->etat;
>>>>>>> 30a24b2eed29a611d0978ac1882dfb4a47f00c2c
    }




}

