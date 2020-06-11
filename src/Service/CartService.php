<?php

namespace App\Service;

use App\Entity\Commande;
use App\Entity\LigneCommande;
use App\Entity\Usager;
use App\Repository\ProductRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartService
{
    private $session;
    private $productRepository;
    private $em;

    public function __construct(SessionInterface $session, ProductRepository $productRepository, EntityManagerInterface $em)
    {
        $this->session = $session;
        $this->productRepository = $productRepository;
        $this->em = $em;
    }

    public function panierToCommande(Usager $usager){
        $sessionCart = $this->getFullCart();

        $commande = new Commande();
        $commande->setUsager($usager)
            ->setStatut(false)
            ->setDateCommande(new DateTime());
        $this->em->persist($commande);

        foreach ($sessionCart as $cart) {
            $ligneCommande = new LigneCommande();
            $ligneCommande->setArticle($cart['product'])
                ->setCommande($commande)
                ->setQuantite($cart['quantity'])
                ->setPrix($cart['product']->getPrix());
            $commande->addLigneCommande($ligneCommande);
            $this->em->persist($ligneCommande);
        }
        $this->em->flush();

        $this->session->set('cart', []);
        $this->updateProductsQuantityInSession();

        return $commande;
    }

    public function add(?int $id)
    {
        $cart = $this->session->get('cart', []);

        if(isset($cart[$id])){
            $cart[$id]++;
        } else {
            $cart[$id] = 1;
        }
        
        $this->session->set('cart', $cart);

        $this->updateProductsQuantityInSession();
    }

    public function removeOne(int $id)
    {
        $cart = $this->session->get('cart', []);

        if(isset($cart[$id])){
            $cart[$id]--;

            if($cart[$id] === 0){
                unset($cart[$id]);
            }
        }

        $this->session->set('cart', $cart);
        $this->updateProductsQuantityInSession();
    }

    public function removeRow(int $id)
    {
        $cart = $this->session->get('cart', []);

        if(isset($cart[$id])){
            unset($cart[$id]);
        }
        
        $this->session->set('cart', $cart);
        $this->updateProductsQuantityInSession();
    }

    public function removeAll()
    {
        $cart = $this->session->get('cart', []);

        if(isset($cart)){
            unset($cart);
        }
        
        $this->session->set('cart', []);
        $this->updateProductsQuantityInSession();
    }

    public function getFullCart()
    {
        $productsWithData = [];
        foreach ($this->session->get('cart', []) as $product => $quantity) {
            if(!is_string($product)){
                $productsWithData[] = [
                    'product' => $this->productRepository->find($product),
                    'quantity' => $quantity
                ];
            }
        }

        return $productsWithData;
    }

    public function getFullPrice()
    {
        $total = 0;

        foreach ($this->getFullCart() as $v) {
            $total += $v['quantity'] * $v['product']->getPrix();
        }

        return $total;
    }

    private function updateProductsQuantityInSession()
    {
        $total = 0;

        foreach ($this->getFullCart() as $v) {
            $total += $v['quantity'];
        }

        $cart = $this->session->get('cart', []);

        $cart['productsQuantityInCart'] = $total;
        
        $this->session->set('cart', $cart);
    }

    public function supSession(){
        $this->session->remove('cart');
    }
}