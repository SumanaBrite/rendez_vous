<?php

namespace App\Service;

use DateTime;
use DateInterval;

use App\Entity\Rdv;
use App\Entity\Guichet;
use App\Repository\RdvRepository;
use App\Repository\CreneauRepository;
use App\Repository\GuichetRepository;
use App\Repository\HoraireRepository;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\Boolean;
use App\Repository\JourFermetureGuichetRepository;
use App\Repository\HoraireFermetureGuichetRepository;

// class DetailCalendrier{

//     public function __construct( public string $horaire,
//                                 public string $jour,
//                                 public string $creneau){
        

//     }
// }
class Calendrier
{

    private $em;
    private $rdvRepo;
    private $horaireRepo;
    private $creneauRepo;
    private $guichetRepo;
    private $hfGuichetRepo;
    private $jfGuichetRepo;

    public function __construct(EntityManagerInterface $em , 
                                RdvRepository $rdvRepo , 
                                HoraireRepository $horaireRepo , 
                                CreneauRepository $creneauRepo,
                                GuichetRepository $guichetRepo,
                                HoraireFermetureGuichetRepository $hfguichetRepo ,
                                JourFermetureGuichetRepository $jfguichetRepo
    )
    {
        $this->em = $em;
        $this->rdvRepo = $rdvRepo;
        $this->horaireRepo = $horaireRepo;
        $this->creneauRepo = $creneauRepo;
        $this->guichetRepo = $guichetRepo;
        $this->hfGuichetRepo = $hfguichetRepo;
        $this->jfGuichetRepo = $jfguichetRepo;
    }
    // public function getCalendrier($jour): array
    public function getCalendrier(): array
    {
        $today = new DateTime(); 
        $today->setTime(0, 0, 0 , 0);
        $jour  = new DateTime(); 
        $jour->setTime(0, 0, 0 , 0);
        $jours = [];
        array_push($jours, $jour);
        
        // $interval = new DateInterval('P1D');
         unset($jour);
        for( $i = 1 ; $i <= 6 ; $i++ ){
           
           $jour  = new DateTime(); 
           $jour->setTime(0, 0, 0 , 0);
           
            $jour->add(new DateInterval('P' . $i . 'D'));

            array_push($jours, $jour);
            unset($jour);
        }
        

        $tab = [];
        $rdvs = [];
        
        $rdv2s = $this->rdvRepo->findAll();
        // effacer les jours antérieur à aujourd'hui
        foreach (  $rdv2s as $rdv ){
             if ( $rdv->getJour() >= $today ){
                array_push($rdvs, $rdv);
            }

        }

        
        // effacer les jours antérieur à aujourd'hui
        $jfguichets = [];
        $jfguichet2s = $this->jfGuichetRepo->findAll();
        foreach (  $jfguichet2s as $jfguichet ){
             if ( $jfguichet->getJour() >= $today ){

                array_push($jfguichets, $jfguichet);
            }

        }

        // effacer les jours antérieur à aujourd'hui
        $hfguichets = [];
        $hfguichet2s = $this->hfGuichetRepo->findAll();
        foreach (  $hfguichet2s as $hfguichet ){
             if ( $hfguichet->getJour() >= $today ){

                array_push($hfguichets, $hfguichet);
            }

        }


        // Lecture de la table de paramétrage Horaire et créneaux
        $horaires = $this->horaireRepo->findAll();
        $creneaus = $this->creneauRepo->findAll();
        $guichets = $this->guichetRepo->findAll();
        $nbGuichetTotal = count( $guichets);
      
      
        foreach ( $horaires as $horaire ){
         
           $horaireNom = $horaire->getNom();
           
            foreach ( $jours as $jour ){
                

                
                $tmpCreneauTab = [];
                $nbCreneau = 0;
                $nbGuichet = 0;
                $nbGuichetFJour = 0;
                
                $tmpGuichettab = [];
                // Count the number of desk closed
                // $tmpGuichettab = array_diff( $tmpGuichettab, $tmpGuichettab);
                foreach ($guichets as $guichet) {
                    $guichetFermeture = '';
                    
                    foreach ($jfguichets as $jfguichet) {
                        if ($jfguichet->getJour() == $jour && $jfguichet->getGuichet()->GetId() ==  $guichet->getId()) {
                            $guichetFermeture = 'X';
                            $nbGuichetFJour = $nbGuichetFJour + 1;
                            
                        }
                    }
                   if ($guichetFermeture == '') {
                        foreach ($hfguichets as $hfguichet) {
                            $tmpGuichet = $hfguichet->getGuichet();
                            $tmpHoraire = $hfguichet->getHoraire();

                            if ($hfguichet->getJour() == $jour && $tmpGuichet->getId() ==  $guichet->getId() &&
                                $tmpHoraire->getId() == $horaire->getId() )
                            {
                                $guichetFermeture = 'X';
                              
                                $nbGuichetFJour = $nbGuichetFJour + 1;
                                
                            }
                        }
                    }
                }
                
              
                
                if ( $nbGuichetFJour < $nbGuichetTotal ) {
                    foreach ($creneaus as $crenau) {
                       
                        $flagCrenau = '';
                          
                        if ($nbGuichetFJour < $nbGuichetTotal) {

                            // foreach ($creneaus as $crenau) {
                            $flagCrenau = '';
                            $nbGuichetParCreneau = 0;
                            foreach ($guichets as $guichet) {  
                                
                                    foreach ($rdvs as $rdv) {
                                        $tmpHoraire = $rdv->getHoraire()->getId();
                                        $tmpCreneau = $rdv->getCreneau()->getId();
                                        $tmpguichet = $rdv->getGuichet()->getId();
                                        if ($rdv->getJour() == $jour
                                            && $tmpHoraire  == $horaire->getId()
                                            &&  $tmpCreneau == $crenau->getId()
                                            &&  $tmpguichet == $guichet->getId()
                                            ) {
                                            $flagCrenau = 'X';
                                            $nbGuichetParCreneau = $nbGuichetParCreneau + 1;
                                        }
                           
                                    }
                                
                            }
                        
                            if ( $nbGuichetParCreneau + $nbGuichetFJour < $nbGuichetTotal ) {
                        //    if (($flagCrenau ==  ''  && ($nbGuichetParCreneau + $nbGuichetFJour < $nbGuichetTotal))) {
                                array_push(
                                    $tab,
                                    array( 'horaire'   => $horaire->getNom(),
                                           'horaireId' => $horaire->getId(),
                                           'jour'      => $jour,
                                           'creneauId' => $crenau->getId(),
                                           'creneau' => $crenau->getDescription()
                                        )
                                );
                            }
                        }                    

                        
                    }
                }
                 unset($tmpGuichettab);
 
            }
            
        }

        return $tab;

    }
                    // 
                    // 
                    // Creation of a RDV
                    // 
                    //     

    public function getRdv($horaireIdSelected, $creneauIdSelected, $jourSelected  ){
        // $today = new DateTime(); 
        // $today->setTime(0, 0, 0 , 0);
        
       
        //$jfGuichets = $JFGuichetRepo->findAll();
        // $jfguichet2s = $this->jfGuichetRepo->findAll();
        $jfGuichets = $this->jfGuichetRepo->findAll();
        $hfGuichets  = $this->hfGuichetRepo->findAll();    
        $guichets   = $this->guichetRepo->findAll();
        $rdvs = [];
        
        $rdv2s = $this->rdvRepo->findAll();
        // effacer les jours antérieur à aujourd'hui
        foreach (  $rdv2s as $rdv ){
             if ( $rdv->getJour() ==  $jourSelected ){

                array_push($rdvs, $rdv);
            }

        }

        
        unset( $guichetIdReturn ) ;
    
        $guichetIdReturn = '';
        unset( $guichetRdvFlag );
        $guichetRdvFlag = '';
        foreach( $guichets as $guichet){
            $guichetId = $guichet->getId();

            $flag = '';
            foreach ($jfGuichets as $jfguichet) {
                if ($jfguichet->getJour() == $jourSelected && $jfguichet->getGuichet()->GetId() ==  $guichetId ) {
                    $flag = 'X';

                }

            }
            if ($flag == ''){
                foreach ($hfGuichets as $hfguichet) {
                    $tmpGuichet = $hfguichet->getGuichet();
                    $tmpHoraire = $hfguichet->getHoraire();
                    if ($hfguichet->getJour() == $jourSelected && $tmpGuichet->getId() ==  $guichetId &&
                        $tmpHoraire->getId() == $horaireIdSelected ) {
                        $guichetFermeture = 'X';

                        $flag = 'X';
                        
                    }
                }

                
            }
            if ($flag == '') {
                

                foreach($rdvs as $rdv){
                    $tmpHoraire = $rdv->getHoraire()->getId();
                    $tmpCreneau = $rdv->getCreneau()->getId();
                    $tmpGuichet = $rdv->getGuichet()->getId();
                    if ($rdv->getJour() == $jourSelected
                        && $tmpHoraire  == $horaireIdSelected
                        &&  $tmpCreneau == $creneauIdSelected
                        &&  $tmpGuichet == $guichetId               
                        ) {
                            $flag = 'X';
                            
                        }
        
                }

            }
            if ($flag == ''){
            
                if ( $guichetRdvFlag == ''){

                    $guichetIdReturn = $guichetId;
                    $guichetRdvFlag = 'X';
                };
             }


        }
        if ( $guichetRdvFlag == 'X'){
            return $guichetIdReturn;
        }else{
            $result = 0;
            return $result;
        }
        

    }
    
}

