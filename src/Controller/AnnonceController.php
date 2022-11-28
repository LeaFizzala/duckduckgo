<?php

namespace App\Controller;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Twig\Environment;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Annonce;
use App\Repository\AnnonceRepository;
use App\Form\AnnonceType;
use Doctrine\ORM\EntityManagerInterface;

class AnnonceController extends AbstractController
{
    /**
     * @var Twig\Environment
     */
    private $twig;
    /**
     * @var AnnonceRepository
     */
    private $annonceRepository;


    public function __construct(Environment $twig, AnnonceRepository $annonceRepository)
    {
        $this->twig = $twig;
        $this->annonceRepository = $annonceRepository;
    }

    /**
     * @Route("/annonces")
     */

    public function index(AnnonceRepository $annonceRepository) : Response
    {

        $annonces = $annonceRepository->findAllNotSold();


        return new Response($this->twig->render('annonce/index.html.twig', [
            'title' => 'Meilleures annonces de Duck Duck Go',
            'annonces' => $annonces,
        ]));

    }

    /**
     * @Route(
     *     "/annonces/{id}",
     *     requirements={"id": "\d+"}
     * )
     * @return Response
     */
    // fonction pour retourner une seule instance d'Annonce
    public function show(AnnonceRepository $annonceRepository, int $id) : Response{
        $annonce = $annonceRepository->find($id);

        if(!$annonce){
           throw $this->createNotFoundException();
        }
        return new Response($this->twig->render('annonce/show.html.twig', [
            'title' => 'Meilleures annonces de Duck Duck Go',
            'annonce' => $annonce,
        ]));
    }
    //fonction pour créer une nouvelle annonce à la main
    /**
     * @Route("/annonces/new")
     */
    public function new(Request $request, EntityManagerInterface $em) // depuis Symfony 6, nous sommes obligé d'utiliser l'autowiring
    {
        $annonce = new Annonce();
       // utilisation du formulaire pour créer une nouvelle Annonce
        $form = $this->createForm(AnnonceType::class, $annonce);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($annonce);
            $em->flush();
            return $this->redirectToRoute('app_annonce_index');
        }

        return $this->render('annonce/new.html.twig', [
            'annonce' => $annonce,
            'form' => $form->createView()
        ]);


    }

    /**
     * @Route("/annonce/{id}/edit", methods={"POST", "GET"})
     */
    public function edit(Annonce $annonce, Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(AnnonceType::class, $annonce);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            return $this->redirectToRoute('app_annonce_index');
        }

        return $this->render('annonce/edit.html.twig', [
            'annonce' => $annonce,
            'form' => $form->createView()
        ]);
    }
    /**
     * @Route("/annonce/{id}", methods="DELETE")
     */
    public function delete(Annonce $annonce, EntityManagerInterface $em)
    {
        // on supprime l'annonce de l'ObjetManager
        $em->remove($annonce);
        // en envoie la requête en base de données
        $em->flush();
        return $this->redirectToRoute('app_annonce_index');
    }




}