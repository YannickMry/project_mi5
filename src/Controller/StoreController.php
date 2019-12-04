<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\ProductRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StoreController extends AbstractController
{
    /**
     * @Route("/boutique", name="store_index")
     */
    public function index(ProductRepository $productRepository)
    {
        $products = $productRepository->findAll();

        return $this->render('store/index.html.twig', [
            'current_menu' => 'store_index',
            'products' => $products,
        ]);
    }

    /**
     * Undocumented function
     * 
     * @Route("/rayon/{category}", name="store_category", defaults={"idCategory"="8"})
     *
     * @return void
     */
    public function rayon(Category $category)
    {
        $products = $category->getProducts();

        return $this->render('store/productsByCat.html.twig', [
            'current_menu' => 'store_category',
            'products' => $products,
            'category' => $category
        ]);
    }
}
