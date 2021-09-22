<?php

namespace App\Controller;

use DateTime;
use DateInterval;
use App\Entity\Rdv;
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
     * @Route("/planning/rdv/", name="fiche_rdv")
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
        SendContactCommand $sendContact
    ): Response
    //public function rdv( string $jourSelected , Horaire $horaireSelected , Creneau $creneauSelected ): Response

    {
        // on récupère les données de $_POST
        $tempPost = $request->request->get('creneau');
        // on transforme en tableau
        $creneauBrut = explode('~', $tempPost);
        // puis en tableau associatif
        $creneau = [];
        //dd($creneauBrut);
        foreach ($creneauBrut as $index => $element) {
            $temp = explode('-->', $element);
            // $creneau[$temp[0]] = $temp[1];
            // "horaire-->{{ calendrier.horaire }}~horaireId-->{{ calendrier.horaireId }}~jour-->{{ calendrier.jour|date('Y-m-d') }}
            //~creneau-->{{ calendrier.creneau }}~creneauId-->{{ calendrier.creneauId }}">{{ calendrier.creneau }}</option>

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

        // si tu es pointilleuse tu voudra récupérer un objet date et l'utilisateur
        // $jour = date_create_from_format('Y-m-d', $jourSelected  ); //$creneau['jour']);
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
            $rdvNew->setEmail($user);
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


            $message = 'The RDV is created';
            $this->addFlash('message', $message);
            $sendContact->execute('prenom', 'toto', 'sumanabrite@gmail.com', 'testRdv');

            return $this->redirectToRoute(
                'mesrdvs',
                [
                    // 'rdvs' => $rdvs,
                    // 'today' => $today,
                ],
                Response::HTTP_SEE_OTHER
            );
        } else { // the RDV is not Created


            $message = 'Anomalie prise de Rendez-vous, Veuillez ressaisir le RDV';
            $this->addFlash('message', $message);

            // dd( $jour) ;
            return $this->redirectToRoute(
                'planning',
                [
                    // 'controller_name' => 'PlanningController',
                    // 'calendriers'     => $calendriers,
                    // 'horaires'          => $horaires,
                    // 'jour1'           => $jour,
                    // 'jours'           => $jours,
                ],
                Response::HTTP_SEE_OTHER
            );
        }
    }


    /**
     * @Route("/planning/rdv/email", name="get_email")
     */
    public function getemail(
        
    ): Response
    //public function rdv( string $jourSelected , Horaire $horaireSelected , Creneau $creneauSelected ): Response

    {

    }
}
