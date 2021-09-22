<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PointrelaisController extends AbstractController
{
    /**
     * @Route("/pointrelais", name="pointrelais")
     */
    public function index(): Response
    {
        return $this->render('pointrelais/index.html.twig', [
            'controller_name' => 'PointrelaisController',
        ]);
    }
}
