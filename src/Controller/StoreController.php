<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/boutique")
 */
class StoreController extends AbstractController
{
    /**
     * @Route("/", name="store_index")
     */
    public function index(CategoryRepository $categoryRepository)
    {
        $categories = $categoryRepository->findAll();

        return $this->render('store/index.html.twig', [
            'current_menu' => 'store_index',
            'categories' => $categories,
        ]);
    }

     /**
     * Undocumented function
     * 
     * @Route("/{categoryId}/produits", name="store_products_category", defaults={"categoryId"="8"})
     *
     * @return void
     */
    public function rayon(Category $categoryId)
    {
        $products = $categoryId->getProducts();

        return $this->render('store/products.html.twig', [
            'current_menu' => 'store_index',
            'products' => $products,
            'category' => $categoryId
        ]);
    }

    /**
     * Undocumented function
     * 
     * @Route("/search", name="store_search")
     *
     * @param ProductRepository $productRepository
     * @param Request $request
     * @return void
     */
    public function search(ProductRepository $productRepository, Request $request)
    {
        $search = $request->query->get('product');
        $products = $productRepository->findByProductNameAndText($search);

        return $this->render('store/products.html.twig', [
            'current_menu' => 'store_index',
            'products' => $products,
        ]);
    }
}
