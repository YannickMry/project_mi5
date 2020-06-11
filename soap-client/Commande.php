<?php

namespace SoapClient;

use DateTime;

class Commande
{
    /**
     * @var int
     * @ORM\Id()
     */
    public $id;

    /**
     * @var bool
     */
    public $statut;

    /**
     * @var DateTime
     */
    public $date_commande;

    public function setId($id): self {
        $this->id = $id;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatut(): ?bool
    {
        return $this->statut;
    }

    public function setStatut(bool $statut): self
    {
        $this->status = $statut;

        return $this;
    }

    public function getDateCommande(): ?\DateTimeInterface
    {
        return $this->date_commande;
    }

    public function setDateCommande(\DateTimeInterface $date_commande): self
    {
        $this->date_commande = $date_commande;

        return $this;
    }

}