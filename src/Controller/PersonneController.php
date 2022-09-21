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

    #[Route('/personne', name: 'app_personne')]
    public function index(): Response
    {
        $manager = $this->doctrine->getManager();
        $personne = new Personne();
        $personne->setName('aymen');
        $personne->setAge(40);
        $personne2 = new Personne();
        $personne2->setName('aymen');
        $personne2->setAge(40);
        $manager->persist($personne);
        $manager->persist($personne2);
        $manager->flush();
        return $this->render('personne/index.html.twig', [
            'controller_name' => 'PersonneController',
        ]);
    }
}
