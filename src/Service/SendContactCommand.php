<?php
namespace App\Service;

use App\Entity\User;
use App\Service\ContactService;
use App\Repository\UserRepository;
use Symfony\Component\Mime\Address;
use App\Repository\ContactRepository;
use Symfony\Bridge\PhpUnit\TextUI\Command;
use PHPUnit\TextUI\Command as TextUICommand;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Mailer\MailerInterface as MailerMailerInterface;

class SendContactCommand
{
  private $contactRepository;  
  private $mailer;  
  private $contactService;  
  private $userRepository;  
  protected static $defaultName = 'app:send-contact';  

  public function __construct(
    ContactRepository $contactRepository,
    MailerInterface $mailer,
    ContactService $contactService,
    UserRepository $userRepository
  ){
    $this->contactRepository = $contactRepository;
    $this->mailer = $mailer;
    $this->contactService = $contactService;
    $this->userRepository = $userRepository;
    // parent::__construct();

  }
  public function execute(string $prenom, string $nom, string $email, string $message ):bool
  {
    $user = new User();
    // $toSend = $this->contactRepository->findBy(['isSend' => false]);
    // $adress = 'sumanabrite@gmail.com';
    $adress = strval($email);

    // dd($prenom, $nom, $email, $message);
    // $adress = $this->contactRepository->findBy(['email']); 

    // foreach ($toSend as $mail) {
       $email = new TemplatedEmail(); 
                $email
              
             ->from($adress)
             ->to('contact@ganapathy.fr')
             ->subject('Nouveau message de ' . $nom )
            //  ->text('ça marche');
             ->text($message);

       $this->mailer->send($email);
      //  $this->contactService->isSend($mail);      
    
    // return Command::SUCCESS;
    return true;
    // }
  }
  public function execute2(string $prenom, string $nom,  string $email, string $message ):bool
  {
    $user = new User();
    // $toSend = $this->contactRepository->findBy(['isSend' => false]);
    // $adress = 'sumanabrite@gmail.com';
    $adress = strval($email);

    // dd($prenom, $nom, $email, $message);
    // $adress = $this->contactRepository->findBy(['email']); 

    // foreach ($toSend as $mail) {
       $email = new TemplatedEmail(); 

                $email
              
             ->from($adress)
             ->to('contact@ganapathy.fr')
             ->subject('Nouveau Rdv de ' . $nom  . $prenom)
            //  ->text('ça marche');
             ->text($message);

       $this->mailer->send($email);

       
       $email2 = new TemplatedEmail(); 

                $email2
              
             ->from('contact@ganapathy.fr')
             ->to(  $adress )
             ->subject('Votre RDV auprès de Ganapathy - Transfert d\'' . 'argent ' . $nom )
            //  ->text('ça marche');
             ->text($message);

       $this->mailer->send($email2);

    return true;

  }
}