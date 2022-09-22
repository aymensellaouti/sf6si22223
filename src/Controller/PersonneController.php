<?php

namespace App\Controller;

use App\Entity\Personne;
use App\Form\PersonneType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class PersonneController extends AbstractController
{
    public function __construct(private ManagerRegistry $doctrine)
    {}

    #[Route('/personne/edit/{id?0}', name: 'edit_personne')]
    public function addPersonne(Request $request, Personne $personne = null, SluggerInterface $slugger): Response
    {
        if (!$personne)
            $personne = new Personne();
        $form = $this->createForm(PersonneType::class, $personne);
        $form->handleRequest($request);
        if($form->isSubmitted()) {
            /* @Var UploadedFile $file */
            $file = $form->get('file')->getData();
            if ($file) {
                $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $file->guessExtension();
                // Move the file to the directory where brochures are stored
                try {
                    $file->move($this->getParameter('upload_directory'),$newFilename);
                    $personne->setFilePath($this->getParameter('upload_path').'/'.$newFilename);
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload    }
                }
            }
            $manager = $this->doctrine->getManager();
            $manager->persist($personne);
            $manager->flush();
            return $this->redirectToRoute('list_personne');
        }
        return $this->render('personne/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/personne/{id}', name: 'detail_personne')]
    public function detailsPersonne(Personne $personne = null): Response {
        if (!$personne) {
            $this->addFlash('error', 'Personne innexistante');
            return $this->redirectToRoute('list_personne');
        }
        return $this->render('personne/show.html.twig', ['personne' => $personne]);
    }

    #[Route('/personne/interval/{min?0}/{max?0}', name: 'list_personne_by_age')]
    public function listePersonneByAge($min, $max): Response {
        $repository = $this->doctrine->getRepository(Personne::class);
        $personnes = $repository->findPersonnesInAgeInterval($min, $max);

        return $this->render('personne/list.html.twig', ['personnes' => $personnes]);
    }

    #[Route('/personne/{page?1}/{nbre?10}', name: 'list_personne')]
    public function listePersonne($page, $nbre): Response {
        $repository = $this->doctrine->getRepository(Personne::class);
        $personnes = $repository->findBy([], ['id'=> 'desc'], $nbre, ($page - 1) * $nbre );

        return $this->render('personne/list.html.twig', ['personnes' => $personnes]);
    }


    #[Route('/personne/delete/{id}', name: 'delete_personne')]
    public function deletePersonne($id): Response {
        $repository = $this->doctrine->getRepository(Personne::class);
        $personne = $repository->find($id);
        if (!$personne) {
            $this->addFlash('error', 'Personne innexistante');
        } else {
            $manager = $this->doctrine->getManager();
            $manager->remove($personne);

            $manager->flush();
        }
        return $this->redirectToRoute('list_personne');
    }


}
