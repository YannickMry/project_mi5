<?php

namespace App\Service;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartService
{
    private $session;
    private $productRepository;

    public function __construct(SessionInterface $session, ProductRepository $productRepository)
    {
        $this->session = $session;
        $this->productRepository = $productRepository;
    }

    public function add(int $id)
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

    public function removeAll(int $id)
    {
        $cart = $this->session->get('cart', []);

        if(isset($cart[$id])){
            unset($cart[$id]);
        }
        
        $this->session->set('cart', $cart);
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