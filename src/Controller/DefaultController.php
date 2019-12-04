<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/{_locale}", name="default_index", defaults={"_locale"="en"}, requirements={"_locale"="%app.supported_locales%"})
     */
    public function index()
    {
        return $this->render('default/index.html.twig', [
            'current_menu' => 'home',
        ]);
    }

    /**
     * Undocumented function
     * @Route("/{_locale}/contact", name="default_contact", defaults={"_locale"="fr"}, requirements={"_locale"="%app.supported_locales%"})
     */
    public function contact()
    {
        return $this->render('default/contact.html.twig', [
            'current_menu' => 'contact',
        ]);
    }
}
