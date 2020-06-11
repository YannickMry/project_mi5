<?php

namespace App\Soap;

class CommandeSoap
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var bool
     */
    public $statut;

    /**
     * @var string
     */
    public $date_commande;

    /**
     *
     * @param int $id
     * @param bool $statut
     * @param string $date_commande
     */
    public function __construct(int $id, bool $statut, bool $date_commande)
    {
        $this->id = $id;
        $this->statut = $statut;
        $this->date_commande = $date_commande;
    }


    public function setId($id): self
    {
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
        $this->statut = $statut;

        return $this;
    }

    public function getdateCommande()
    {
        return $this->date_commande;
    }

    public function setdateCommande($date_commande): self
    {
        $this->date_commande = $date_commande;

        return $this;
    }


}