<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use App\Service\CartService;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{

    private $cartService;
    private $productRepository;

    public function __construct(CartService $cartService, ProductRepository $productRepository)
    {
        $this->cartService = $cartService;
        $this->productRepository = $productRepository;
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
        $this->isProductExist($productId);

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
        $this->isProductExist($productId);
        
        $this->cartService->removeOne($productId);
        return $this->redirectToRoute('cart_index');
    }

    /**
     * @Route("/panier/remove-row/{productId}", name="cart_remove_row")
     *
     * @param integer $productId
     * @return void
     */
    public function removeRow(int $productId)
    {
        $this->isProductExist($productId);

        $this->cartService->removeRow($productId);
        return $this->redirectToRoute('cart_index');
    }

    /**
     * @Route("/panier/remove-all", name="cart_remove_all")
     *
     * @return void
     */
    public function removeAll()
    {
        $this->cartService->removeAll();
        $this->addFlash('success', "Le panier a été supprimé avec succès !");
        return $this->redirectToRoute('cart_index');
    }

    /**
     * Vérifie si un produit existe en base de donée
     *
     * @param integer $productId
     * @return boolean
     */
    private function isProductExist(int $productId){
        $product = $this->productRepository->find($productId);

        if(!$product){
            throw $this->createNotFoundException("L'article $productId n'a pas pu être trouvé.");
        }
    }

}