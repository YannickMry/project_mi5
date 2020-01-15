<?php

namespace App\Controller;

use App\Entity\Usager;
use App\Form\UsagerType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/usager", name="usager_")
 */
class UsagerController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(): Response
    {
        $usager = $this->getUser();
        
        return $this->render('usager/index.html.twig', [
            'usager' => $usager ? $usager->getFullName() : 'Aucun utilisateur connecté',
        ]);
    }

    /**
     * @Route("/new", name="new", methods={"GET","POST"})
     */
    public function new(Request $request, SessionInterface $session): Response
    {
        $usager = new Usager();
        $form = $this->createForm(UsagerType::class, $usager);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            // TODO: Encoder le mot de passe de l'utilisateur
            $entityManager->persist($usager);
            $entityManager->flush();

            return $this->redirectToRoute('app_login');
        }

        return $this->render('usager/new.html.twig', [
            'usager' => $usager,
            'form' => $form->createView(),
        ]);
    }
}
