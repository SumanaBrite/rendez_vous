<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FooterController extends AbstractController
{
    /**
     * @Route("/footer/cgv", name="cgv")
     */
    public function cgv(): Response
    {
        return $this->render('footer/cgv.html.twig', [
            'controller_name' => 'FooterController',
        ]);
    }

    /**
     * @Route("/footer/cookies", name="cookies")
     */
    public function cookies(): Response
    {
        return $this->render('footer/cookies.html.twig', [
            'controller_name' => 'FooterController',
        ]);
    }

    

    /**
     * @Route("/footer/mention_legale", name="mention_legale")
     */
    public function mention_legal(): Response
    {
        return $this->render('footer/mention_legale.html.twig', [
            'controller_name' => 'FooterController',
        ]);
    }

    /**
     * @Route("/footer/condition", name="condition")
     */
    public function condition(): Response
    {
        return $this->render('footer/condition.html.twig', [
            'controller_name' => 'FooterController',
        ]);
    }

    /**
     * @Route("/footer/protection", name="protection")
     */
    public function protection(): Response
    {
        return $this->render('footer/protection.html.twig', [
            'controller_name' => 'FooterController',
        ]);
    }


    /**
     * @Route("/footer/reduction", name="reduction")
     */
    public function reduction(): Response
    {
        return $this->render('footer/reduction.html.twig', [
            'controller_name' => 'FooterController',
        ]);
    }
}
