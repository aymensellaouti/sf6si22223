<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FirstController extends AbstractController
{
    #[Route('/first', name: 'app_first')]
    public function index(): Response
    {
        $x = 'Bonjour SI2';
        dump($x);
        return $this->render('first/index.html.twig', [
            'name' => 'FirstController',
            'firstname' => 'aymen'
        ]);
    }

    #[Route('/hello/{name}', name: 'hello')]
    public function sayHello(Request $request, $name): Response
    {
        dump($request);
        return $this->render('first/hello.html.twig', [
            'name' => $name,
        ]);
    }
}
