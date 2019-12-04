<?php

namespace App\Controller;

use App\Service\CartService;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{

    private $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    /**
     * @Route("/panier", name="cart_index")
     *
     * @return void
     */
    public function index()
    {
        dd($this->cartService->getFullCart());
        return $this->render('cart/index.html.twig');
    }

    /**
     * @Route("/panier/add/{productId}", name="cart_add")
     *
     * @param integer $productId
     * @return void
     */
    public function add(int $productId)
    {
        $this->cartService->add($productId);
        return $this->redirectToRoute('cart_index');
    }

    /**
     * @Route("/panier/remove/{productId}", name="cart_remove")
     *
     * @param integer $productId
     * @return void
     */
    public function remove(int $productId)
    {
        $this->cartService->remove($productId);
        return $this->redirectToRoute('cart_index');
    }
}