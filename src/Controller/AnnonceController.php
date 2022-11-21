<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Twig\Environment;
use Symfony\Component\Routing\Annotation\Route;

class AnnonceController extends AbstractController
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
     * @Route("/annonces")
     */

    public function index() : Response
    {
        return new Response($this->twig->render('annonce/index.html.twig', [
            'title' => 'Les annonces',
            'content' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed sodales semper tortor at tincidunt. Vestibulum viverra elit facilisis neque commodo, quis elementum dolor ultricies. Mauris risus nisl, hendrerit pharetra aliquet et, venenatis sit amet sapien. Duis nulla tellus, ornare a lorem et, aliquam tristique diam. Class aptent taciti sociosqu ad litora torquent per conubia nostra, 
            per inceptos himenaeos. Aliquam at iaculis enim, vitae feugiat enim. Sed volutpat dui malesuada, consectetur arcu nec, rhoncus ex. Curabitur sed congue nisi. Proin luctus sapien nec nisi tempor commodo. Integer dictum pretium justo, sed dictum sem mollis in. Curabitur iaculis iaculis dignissim.
Aliquam erat volutpat. Sed auctor, velit vel suscipit tristique, erat metus fringilla sem, vitae finibus sem mauris sagittis nibh. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse potenti. Curabitur mattis dignissim pellentesque. 
Donec sed lacus dui. Nam pharetra elit feugiat metus molestie mollis. Aenean non tristique orci. Quisque justo eros, bibendum eget justo nec, pellentesque egestas urna.",
        'date' => new \DateTime()
        ]));
    }
}