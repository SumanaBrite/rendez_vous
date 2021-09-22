<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Service\ContactService;
use App\Service\SendContactCommand;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function index(Request $request, ContactService $contactService, SendContactCommand $sendContact): Response
    {
        $contact = new Contact();
        $form = $this->CreateForm(ContactType::class, $contact);
        $form->handleRequest($request);
        // dd($form);


        if($form->isSubmitted() && $form->isValid() ){
            $contact = $form->getData();
            // dd($contact->getEmail());
              // dd($contact);
            // $contact->setCreatedAt(); c'est possible aussi
            $contactService->persistContact($contact);
            $sendContact->execute($contact->getPrenom(), $contact->getNom(), $contact->getEmail(), $contact->getMessage());
           return $this->redirectToRoute('contact');
        }
        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }


}
