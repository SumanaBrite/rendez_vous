<?php

namespace App\Controller;

use App\Entity\ArticleBoucherie;
use App\Repository\ArticleBoucherieRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    
    /**
     * @Route("/coiffeur", name="coiffeur")
     */
    public function coiffeur(): Response
    {
        return $this->render('home/coiffeur.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    


    
}
