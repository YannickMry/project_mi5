<?php

namespace App\Controller;

use App\Entity\Usager;
use App\Form\UsagerType;
use App\Repository\LigneCommandeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/usager", name="usager_")
 */
class UsagerController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(LigneCommandeRepository $lr): Response
    {
        $usager = $this->getUser();
        return $this->render('usager/index.html.twig', [
            'usager' => $usager ? $usager->getFullName() : 'Aucun utilisateur connecté',
        ]);
    }

    /**
     * @Route("/new", name="new", methods={"GET","POST"})
     */
    public function new(Request $request, SessionInterface $session, UserPasswordEncoderInterface $encoder): Response
    {
        $usager = new Usager();
        $form = $this->createForm(UsagerType::class, $usager);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $encodedPassword = $encoder->encodePassword($usager, $request->request->get('usager')['password']);
            $usager->setPassword($encodedPassword);
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
