<?php

namespace App\Controller;

use DateTime;
use DateInterval;
use App\Entity\Rdv;
use DateTimeInterface;
use App\Entity\Creneau;
use App\Entity\Horaire;
use App\Service\Calendrier;
use App\Repository\RdvRepository;
use App\Service\SendContactCommand;
use App\Entity\JourFermetureGuichet;
use App\Repository\CreneauRepository;
use App\Repository\GuichetRepository;
use App\Repository\HoraireRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\JourFermetureGuichetRepository;
use App\Repository\HoraireFermetureGuichetRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PlanningController extends AbstractController
{
    /**
     * @Route("/planning", name="planning")
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

    /**
     * @Route("/planning/jour", name="planning_jour")
     */
    public function jour(): Response
    {
        return $this->render('planning/jour.html.twig', [
            'controller_name' => 'PlanningController',
        ]);
    }

    /**
     * @Route("/planning/rdv/{horaireIdSelected}/{jourSelected}/{creneauIdSelected}/", name="fiche_rdv")
     */
    public function rdv(
        Request $request,
        RdvRepository $rdvRepo,
        HoraireRepository $horaireRepo,
        CreneauRepository $creneauRepo,
        GuichetRepository $guichetRepo,
        HoraireFermetureGuichetRepository $HFGuichetRepo,
        JourFermetureGuichetRepository $JFGuichetRepo,
        Calendrier  $cal,
        SendContactCommand $sendContact,
        $horaireIdSelected , 
        $jourSelected ,
        $creneauIdSelected

    ): Response
  
    {
        $nom = "";
        $prenom = "";
        $email = "";
        $prenom = $request->request->get('prenom');
        $nom = $request->request->get('nom');
        $email = $request->request->get('email');
       // dd( $horaireIdSelected, $jourSelected , $creneauIdSelected, $prenom, $nom , $email );
 
        $creneau = [];
   

        $jour = date_create_from_format('Y-m-d', $jourSelected);
        $jour->setTime(0, 0, 0, 0);

        $user = $this->getUser();

        // et voilà! 
        //dd($horaireNomSelected, $horaireIdSelected, $jour, $creneauNomSelected, $creneauIdSelected, $user);
        // je suis sur que tu vas finir par t'en sortir :-)
                                                          
        $returnUpdate = $cal->getRdv($horaireIdSelected, $creneauIdSelected, $jour); //, $user);

        if ($returnUpdate > 0) {
            //    the RDV is created


            $entityManager = $this->getDoctrine()->getManager();
            $rdvNew = new Rdv();
            // Suma rempalcer les 3 instructions
            //  $rdvNew->setEmail($user);
             $rdvNew->setEmail($email);
             $rdvNew->setPrenom($prenom);
             $rdvNew->setNom($nom);
            $rdvNew->setJour($jour);
            $horaireNew = $horaireRepo->find($horaireIdSelected);
            $rdvNew->setHoraire($horaireNew);
            $creneauNew = $creneauRepo->find($creneauIdSelected);
            //dd( $returnUpdate );
            $guichetNew = $guichetRepo->find($returnUpdate);
            $rdvNew->setGuichet($guichetNew);
            $rdvNew->setCreneau($creneauNew);
            $entityManager->persist($rdvNew);
            $entityManager->flush();

            $tmpDay = date_format($jour , 'l');
            $en = array("Monday", "Tuesday", "Wednesday", "Thursday","Friday" , "Saturday","Sunday");
            $fr   = array("Lundi", "Mardi", "Mercredi" , "Jeudi","Vendredi" , "Samedi","Dimanche" );
            $tmpDay = str_replace($en, $fr, $tmpDay);
                
            $message = 'Votre Rendez-vous du ' . $tmpDay . ' ' . $jourSelected . ' à ' . 
                       $horaireNew->getNom() . $creneauNew->getDescription() . ' a été pris en compte  ';
            
            $this->addFlash('message', $message);
            $sendContact->execute2($prenom, $nom, $email, $message );
            // $sendContact->execute2($prenom , $nom ,  $email , $message);
            return $this->redirectToRoute(
                'planning',
                [],
                Response::HTTP_SEE_OTHER
            );
        } else { // the RDV is not Created


            $message = 'Anomalie prise de Rendez-vous, Veuillez ressaisir le RDV';
            $this->addFlash('message', $message);

            // dd( $jour) ;
            return $this->redirectToRoute(
                'planning',
                [],
                Response::HTTP_SEE_OTHER
            );
        }
    }
    /**
     * @Route("/planning/rdvemail/{idH}/{jour}/rdv", name="get_email")
     */
    public function getemail(
        Request $request,

        $idH , 
        $jour 
        ): Response

        {
            $tempPost = $request->request->get('creneau');
            // on transforme en tableau
            $creneauBrut = explode('~', $tempPost);
            // puis en tableau associatif
            $creneau = [];
       
            foreach ($creneauBrut as $index => $element) {
                $temp = explode('-->', $element);
                
                if ($index == 0) {
                    $horaireNomSelected = $temp[1]; //$element;
                }
                if ($index == 1) {
                    $horaireIdSelected = $temp[1]; //$element;
                }
                if ($index == 2) {
                    $jourSelected = $temp[1]; //$element;
                    // $jour = date_create_from_format('Y-m-d', $jourSelected  );
                    //dd(  $element ,  $jourSelected , $jour , $horaireNomSelected , $horaireIdSelected);
                }
                if ($index == 3) {
                    $creneauNomSelected = $temp[1]; //$element;
                }
                if ($index == 4) {
                    $creneauIdSelected = $temp[1]; // $element;
                }
            }

         

        return $this->render('planning/email.html.twig', [

            'horaireNomSelected' => $horaireNomSelected,
            'horaireIdSelected'  => $horaireIdSelected,
            'jourSelected'       => $jourSelected,
            'creneauNomSelected' => $creneauNomSelected,
            'creneauIdSelected' => $creneauIdSelected,


        ]);
    
        }
}

