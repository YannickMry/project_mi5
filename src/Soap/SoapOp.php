<?php

namespace App\Soap;

use App\Entity\User;
use App\Soap\CommandeSoap;
use Doctrine\ORM\EntityManager;

class SoapOp
{
    private $em;

    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    /**
     * Dis "Hello" à la personne passée en paramètre
     * @param string $name Le nom de la personne à qui dire "Hello!"
     * @return string The hello string
     */
    public function sayHello(string $name) : string
    {
        return 'Hello '.$name.'!';
    }

    /**
     * Réalise la somme de deux entiers
     * @param int $a 1er nombre
     * @param int $b 2ème nombre
     * @return int La somme des deux entiers
     */
    public function sumHello(int $a, int $b) : int {
        return (int)($a+$b);
    }

    /**
     * Récupère la dernière commande d'un utilisateur placé en paramètre
     * @param int $id utilisateur id
     * @return \App\Soap\CommandeSoap La dernière commande de l'utilisateur
     */
    public function getLastCommandForUserId(int $id): \App\Soap\CommandeSoap
    {
        $user = $this->em->getRepository(User::class)->findOneById($id);
        $commande = $user->getCommands()->first();

        $commandeSoap = new CommandeSoap();
        $commandeSoap->setStatut($commande->getStatut());
        $commandeSoap->setDateCommande(date_format($commande->getDateCommande(), 'Y-m-d H:i:s'));
        $commandeSoap->setId($commande->getId());
        return $commandeSoap;
    }
}