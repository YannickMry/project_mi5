<?php

namespace App\Controller;

use App\Entity\Usager;
use App\Form\UsagerType;
use App\Repository\UsagerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/usager")
 */
class UsagerController extends AbstractController
{
    /**
     * @Route("/", name="usager_index", methods={"GET"})
     */
    public function index(UsagerRepository $usagerRepository, SessionInterface $session): Response
    {
        $idUsager = $session->get('usager');
        $usager = null;
        
        if($idUsager)
            $usager = $usagerRepository->find($idUsager);

        return $this->render('usager/index.html.twig', [
            'usager' => $usager ? $usager->getFullName() : 'Aucun utilisateur connecté',
        ]);
    }

    /**
     * @Route("/new", name="usager_new", methods={"GET","POST"})
     */
    public function new(Request $request, SessionInterface $session): Response
    {
        $usager = new Usager();
        $form = $this->createForm(UsagerType::class, $usager);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($usager);
            $entityManager->flush();

            $session->set('usager', $usager->getId());

            return $this->redirectToRoute('usager_index');
        }

        return $this->render('usager/new.html.twig', [
            'usager' => $usager,
            'form' => $form->createView(),
        ]);
    }
}
