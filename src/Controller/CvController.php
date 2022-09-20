<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CvController extends AbstractController
{
    #[Route('/cv/{name}/{firstname}/{age}/{section}', name: 'app_cv')]
    public function index($name, $firstname, $age, $section): Response
    {
        return $this->render('cv/index.html.twig', [
            'name' => $name,
            'firstname' => $firstname,
            'age' => $age,
            'section' => $section
        ]);
    }
    #[Route('/fidele', name: 'app_fidele')]
    public function fidele(SessionInterface $session) {
        // Je vérifie si c'est le premier accès à ma page
        // en vérifiant que j'ai ou pas ma variable nbVisite

        if($session->has('nbVisite')) {
            // Si oui je prépare mon message ensuite j'incrémente le nbVisite
            $nbVisite = $session->get('nbVisite');
            $nbVisite++;
            $message = "Merci pour votre confiance, vous nous avez visité $nbVisite fois";

            // Je le met ensuite dans ma session
            $session->set('nbVisite', $nbVisite);
        } else {
            $session->set('nbVisite', 1);
            $message = "Bienvenu dans notre site :)";
        }
        return $this->render('cv/fidele.html.twig', ['message' => $message]);
    }

}
