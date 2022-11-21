<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Twig\Environment;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\AnnonceRepository;



class HomeController extends AbstractController
{
    /**
     * @var Twig\Environment
     */
    private $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @Route("/")
     */
    public function index(AnnonceRepository $annonceRepository) : Response // on prend le repo en param
    {
        $annonces = $annonceRepository->findLatestNotSold(); // on fait appel à ma méthode souhaitée
        return new Response($this->twig->render('home/index.html.twig', [
            'title' => 'Bienvenue sur DuckDuckGo',
            'subtitle' => 'Où les canards foutent le camp !',
            'annonces'=> $annonces // on nomme la variable pour twig
        ]));

    }
}
