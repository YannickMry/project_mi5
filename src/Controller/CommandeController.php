<?php

namespace App\Controller;

use App\Entity\Commande;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/commande", name="commande_")
 */
class CommandeController extends AbstractController
{

    /**
     * Undocumented function
     * 
     * @Route("/", name="index")
     */
    public function index()
    {
        return $this->render('commande/index.html.twig', [
            'current_menu' => 'commande',
            'commandes' => $this->getUser()->getCommandes(),
        ]);
    }

    /**
     * Undocumented function
     * 
     * @Route("/show/{idCommande}", name="show")
     *
     * @param Commande $commande
     * @return void
     */
    public function show(Commande $idCommande)
    {
        return $this->render('commande/show.html.twig', [
            'current_menu' => 'commande',
            'commande' => $idCommande
        ]);
    }
}
