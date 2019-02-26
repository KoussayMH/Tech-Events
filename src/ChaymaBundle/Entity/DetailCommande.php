<?php

namespace ChaymaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DetailCommande
 *
 * @ORM\Table(name="detail_commande")
 * @ORM\Entity(repositoryClass="ChaymaBundle\Repository\DetailCommandeRepository")
 */
class DetailCommande
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
     * @ORM\Column(name="quantite", type="integer")
     */
    private $quantite;
    /**
     * @ORM\ManyToOne(targetEntity="\ChaymaBundle\Entity\Ticket")
     * @ORM\JoinColumn(name="ticket",referencedColumnName="id")
     */
    private $ticket;

    /**
     * @ORM\ManyToOne(targetEntity="\ChaymaBundle\Entity\Commande")
     * @ORM\JoinColumn(name="commande",referencedColumnName="id")
     */
    private $commande;

    /**
     * @return mixed
     */
    public function getCommande()
    {
        return $this->commande;
    }

    /**
     * @param mixed $commande
     */
    public function setCommande($commande)
    {
        $this->commande = $commande;
    }


    /**
     * @return mixed
     */
    public function getTicket()
    {
        return $this->ticket;
    }

    /**
     * @param mixed $ticket
     */
    public function setTicket($ticket)
    {
        $this->ticket = $ticket;
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
     * Set quantite
     *
     * @param integer $quantite
     *
     * @return DetailCommande
     */
    public function setQuantite($quantite)
    {
        $this->quantite = $quantite;

        return $this;
    }

    /**
     * Get quantite
     *
     * @return int
     */
    public function getQuantite()
    {
        return $this->quantite;
    }
}

