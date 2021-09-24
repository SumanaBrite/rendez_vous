<?php

namespace App\Controller;

use DateTime;
use DateInterval;
use App\Entity\Rdv;
use DateTimeInterface;
use App\Service\Calendrier;
use App\Entity\ArticleBoucherie;
use App\Repository\RdvRepository;
use App\Repository\CreneauRepository;
use App\Repository\GuichetRepository;
use App\Repository\HoraireRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\ArticleBoucherieRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\JourFermetureGuichetRepository;
use App\Repository\HoraireFermetureGuichetRepository;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(
        RdvRepository $rdvRepo,
        HoraireRepository $horaireRepo,
        CreneauRepository $creneauRepo,
        GuichetRepository $guichetRepo,
        HoraireFermetureGuichetRepository $HFGuichetRepo,
        JourFermetureGuichetRepository $JFGuichetRepo,
        Calendrier  $cal
    ): Response {


        $user = $this->getUser();


        $jour = new DateTime();
        $jour->setTime(0, 0, 0, 0);

        $calendriers  = $cal->getCalendrier();

        $jours = [];
        array_push($jours, $jour);

        unset($jour);
        for ($i = 1; $i <= 6; $i++) {
            $jour  = new DateTime();
            $jour->setTime(0, 0, 0, 0);

            $jour->add(new DateInterval('P' . $i . 'D'));

            array_push($jours, $jour);
            unset($jour);
        }

        $jour = new DateTime();
        $jour->setTime(0, 0, 0, 0);
        $horaires = $horaireRepo->findAll();



        return $this->render('planning/index.html.twig', [
            'controller_name' => 'PlanningController',
            'calendriers'     => $calendriers,
            'horaires'          => $horaires,
            'jour1'           => $jour,
            'jours'           => $jours,

        ]);
    }

    // public function index(): Response
    // {
    //     return $this->render('home/index.html.twig', [
    //         'controller_name' => 'HomeController',
    //     ]);
    // }

    

    
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
