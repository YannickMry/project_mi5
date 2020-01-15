<?php

namespace App\Service;

use App\Entity\Usager;
use Twig\Environment;

class EmailService {

    const EMETTEUR = 'emetteur@test.com';
    private $mailer;
    private $environment;

    public function __construct(\Swift_Mailer $mailer, Environment $environment)
    {
        $this->mailer = $mailer;
        $this->environment = $environment;
    }

    /**
     * Envoi d'un email à l'utilisateur passé en paramettre
     *
     * @param string $subject
     * @param Usager $usager
     * @param array $variableArray
     * @return integer
     */
    public function sendEmail(string $subject, Usager $usager, array $variableArray)
    {
        
        $email = (new \Swift_Message($subject))
            ->setFrom(EmailService::EMETTEUR)
            ->setTo($usager->getEmail())
            ->setBody($this->environment->render('emails/commande.html.twig', $variableArray), 'text/html');
        
        $this->mailer->send($email);
    }
}