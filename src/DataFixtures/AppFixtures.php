<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        /**
         * Catégories
         */
        $categorie_ski = new Category();
        $categorie_ski->setLibelle('Nos skis de piste')
            ->setVisuel('images/skis/img_categorie.jpg');
        $manager->persist($categorie_ski);

        $categorie_chaussure = new Category();
        $categorie_chaussure->setLibelle('Nos chaussures')
            ->setVisuel('images/chaussures/img_categorie.jpg');
        $manager->persist($categorie_chaussure);

        $categorie_snowboard = new Category();
        $categorie_snowboard->setLibelle('Nos snowboards')
            ->setVisuel('images/snowboards/img_categorie.jpg');
        $manager->persist($categorie_snowboard);

        /**
         * Skis
         */
        $p1 = new Product();
        $p1->setLibelle('Ski alpin Experience 84 AI konect Rossignol')
            ->setPrix(mt_rand(11000, 46800)/100)
            ->setVisuel('images/skis/ski_alpin_experience_84_ai_konect_rossignol.jpeg')
            ->setTexte(null)
            ->setCategory($categorie_ski);
        $manager->persist($p1);

        $p2 = new Product();
        $p2->setLibelle('Ski Alpin Hero Elite MT CA konect Rossignol')
            ->setPrix(mt_rand(11000, 46800)/100)
            ->setVisuel('images/skis/ski_alpin_hero_elite_mt_ca_konect_rossignol.jpeg')
            ->setTexte(null)
            ->setCategory($categorie_ski);
        $manager->persist($p2);

        $p3 = new Product();
        $p3->setLibelle('Ski Alpin V-Shape V4s lyt Head')
            ->setPrix(mt_rand(11000, 46800)/100)
            ->setVisuel('images/skis/ski_alpin_v-shape_v4s_lyt_head.jpeg')
            ->setTexte(null)
            ->setCategory($categorie_ski);
        $manager->persist($p3);

        /**
         * Snowboards
         */
        $p4 = new Product();
        $p4->setLibelle('Planche Snowboard line-149 Apo')
            ->setPrix(mt_rand(11000, 46800)/100)
            ->setVisuel('images/snowboards/planche_snowboard_apo_line-149.jpeg')
            ->setTexte(null)
            ->setCategory($categorie_snowboard);
        $manager->persist($p4);

        $p5 = new Product();
        $p5->setLibelle('Planche Snowboard Assassin Salomon')
            ->setPrix(mt_rand(11000, 46800)/100)
            ->setVisuel('images/snowboards/planche_snowboard_salomon_assassin.jpeg')
            ->setTexte(null)
            ->setCategory($categorie_snowboard);
        $manager->persist($p5);

        $p6 = new Product();
        $p6->setLibelle('Planche Snowboard Pulse Salomon')
            ->setPrix(mt_rand(11000, 46800)/100)
            ->setVisuel('images/snowboards/planche_snowboard_salomon_pulse.jpeg')
            ->setTexte(null)
            ->setCategory($categorie_snowboard);
        $manager->persist($p6);

        /**
         * Chaussures
         */
        $p7 = new Product();
        $p7->setLibelle('Chaussure Ski Allspeed pro 100 black Rossignol')
            ->setPrix(mt_rand(11000, 46800)/100)
            ->setVisuel('images/chaussures/chaussure_ski_allspeed_pro_100_black_rossignol.jpeg')
            ->setTexte(null)
            ->setCategory($categorie_chaussure);
        $manager->persist($p7);

        $p8 = new Product();
        $p8->setLibelle('Chaussure Ski Hawx magna 100 black red Atomic')
            ->setPrix(mt_rand(11000, 46800)/100)
            ->setVisuel('images/chaussures/chaussure_ski_hawx_magna_100_black_red_atomic.jpeg')
            ->setTexte(null)
            ->setCategory($categorie_chaussure);
        $manager->persist($p8);

        $p9 = new Product();
        $p9->setLibelle('Chaussure Ski Qst access 60w white Salomon')
            ->setPrix(mt_rand(11000, 46800)/100)
            ->setVisuel('images/chaussures/chaussure_ski_qst_access_60w_white_salomon.jpeg')
            ->setTexte(null)
            ->setCategory($categorie_chaussure);
        $manager->persist($p9);

        $manager->flush();
    }
}
