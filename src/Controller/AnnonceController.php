<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Twig\Environment;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Annonce;
use App\Repository\AnnonceRepository;

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
    public function new(ManagerRegistry $doctrine) // depuis Symfony 6, nous sommes obligé d'utiliser l'autowiring
    {
        $annonce = new Annonce();
        $annonce
            ->setTitle('Canard Tichaud')
            ->setDescription('Pokémon')
            ->setPrice(100)
            ->setStatus(Annonce::STATUS_BAD)
            ->setSold(false)
        ;

        // On récupère l'EntityManager
        $em = $doctrine->getManager();
        // On « persiste » l'entité
        $em->persist($annonce);
        // On envoie tout ce qui a été persisté avant en base de données
        $em->flush();

        die ( $annonce->getTitle() . ' annonce bien créée');
    }

}