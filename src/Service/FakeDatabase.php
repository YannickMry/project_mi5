<?php

namespace App\Service;

use App\Entity\Category;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class FakeDatabase extends Fixture {

    public function load(ObjectManager $manager)
    {
        $texte = "Lorem ipsum, dolor sit amet consectetur adipisicing elit. Porro eos cumque aperiam deserunt, delectus doloremque libero sapiente nulla quis atque? Esse commodi facere quidem? Dolore ipsam fuga eaque sit fugiat.";
        $image = [
            'dynastar.png',
            'head.jpg',
            'rossignol.png',
            'atomic.png'
        ];

        
        for ($c=0; $c < 3; $c++) { 
            $category = new Category();
            $category->setLibelle("Catégorie ". $c)
                ->setVisuel("images/visuel".$c.".png")
                ->setTexte($texte);
            $manager->persist($category);
            
            $categories[] = $category;
        }

        for ($i=0; $i < 10; $i++) { 
            $product = new Product();
            $product->setLibelle("Ski ".$i)
                ->setTexte($texte)
                ->setPrix(rand(200,500))
                ->setVisuel('images/'.$image[rand(0,3)])
                ->setCategory($categories[rand(0,2)]);
            
            $manager->persist($product);
        }

        $manager->flush();
    }
}