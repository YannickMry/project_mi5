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
        return $this->render('cart/index.html.twig', [
            'current_menu' => 'cart_index',
            'fullCart' => $this->cartService->getFullCart(),
            'price' => $this->cartService->getFullPrice(),
        ]);
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
     * @Route("/panier/remove-one/{productId}", name="cart_remove_one")
     *
     * @param integer $productId
     * @return void
     */
    public function removeOne(int $productId)
    {
        $this->cartService->removeOne($productId);
        return $this->redirectToRoute('cart_index');
    }

    /**
     * @Route("/panier/remove-all/{productId}", name="cart_remove_all")
     *
     * @param integer $productId
     * @return void
     */
    public function removeAll(int $productId)
    {
        $this->cartService->removeAll($productId);
        return $this->redirectToRoute('cart_index');
    }
}