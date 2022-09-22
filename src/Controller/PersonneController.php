<?php

namespace App\Controller;

use App\Entity\Personne;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PersonneController extends AbstractController
{
    public function __construct(private ManagerRegistry $doctrine)
    {}

    #[Route('/personne/add/{name}/{age<\d{1,2}>}', name: 'app_personne')]
    public function addPersonne($name, $age): Response
    {
        $manager = $this->doctrine->getManager();
        $personne = new Personne();
        $personne->setName($name);
        $personne->setAge($age);
        $manager->persist($personne);
        $manager->flush();
        return $this->render('personne/show.html.twig', [
            'personne' => $personne,
        ]);
    }
}
