<?php

namespace App\Controller;

use DateTime;
use App\Entity\Rdv;
use App\Entity\User;
use App\Form\RdvType;
use App\Repository\GuichetRepository;
use App\Repository\RdvRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/rdv")
 */
class RdvController extends AbstractController
{
    /**
     * @Route("/", name="rdv_index", methods={"GET"})
     */
    public function index(RdvRepository $rdvRepository, GuichetRepository $guichetRepository): Response
    {
        $today = new DateTime();
        $today->setTime(0, 0, 0, 0);

        return $this->render('rdv/index.html.twig', [
            'rdvs' => $rdvRepository->findAll(),
            'guichets' => $guichetRepository->findAll(),
            'today' => $today,
        ]);
    }

    /**
     * @Route("/new", name="rdv_new", methods={"GET","POST"})
     */
    public function new(Request $request, UserRepository $userRepo): Response
    {
        $rdv = new Rdv();

        $user = new User;

        // $user = $userRepo->findOneBy([ 'id' => "1" ]);
        $user = $this->getUser();


        $form = $this->createForm(RdvType::class, $rdv);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            // $rdv->setEmail($user);
            $entityManager->persist($rdv);
            $entityManager->flush();

            return $this->redirectToRoute('rdv_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('rdv/new.html.twig', [
            'rdv' => $rdv,
            'form' => $form,
        ]);
    }
    /**
     * @Route("/mesrdvs", name="mesrdvs", methods={"GET"})
     */
    public function mesrdvs(RdvRepository $rdvRepo): Response
    {
        // récuperer de la session l'identifiant user user.id
        // rechercher les  users 

        $user = $this->getUser();
        $today = new DateTime();
        $today->setTime(0, 0, 0, 0);

        // $rdv2s = $rdvRepo->findAll();
        $rdv2s = $rdvRepo->findBy([
            'email'  => $user

        ]);
        $rdvs = [];
        // effacer les jours antérieur à aujourd'hui
        foreach ($rdv2s as $rdv) {

            if ($rdv->getJour() >= $today) {


                array_push($rdvs, $rdv);
            }
        }

        return $this->render('rdv/index2.html.twig', [
            'rdvs' => $rdvs,
            'today' => $today,
        ]);
    }

    /**
     * @Route("/{id}/show", name="rdv_show", methods={"GET"})
     */
    public function show(Rdv $rdv): Response
    {
        return $this->render('rdv/show.html.twig', [
            'rdv' => $rdv,
        ]);
    }

    /**
     * @Route("/{id}/rdvuser", name="rdv_show_user", methods={"GET"})
     */
    public function showuser(Rdv $rdv): Response
    {
        return $this->render('rdv/delete_rdv_user.html.twig', [
            'rdv' => $rdv,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="rdv_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Rdv $rdv): Response
    {
        $form = $this->createForm(RdvType::class, $rdv);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('rdv_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('rdv/edit.html.twig', [
            'rdv' => $rdv,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}/userdelete", name="rdv_user_delete", methods={"POST"})
     */
    public function rdvuserdelete(Request $request, Rdv $rdv): Response
    {
        if ($this->isCsrfTokenValid('delete' . $rdv->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($rdv);
            $entityManager->flush();
        }

        return $this->redirectToRoute('mesrdvs', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/{id}/delete", name="rdv_delete", methods={"POST"})
     */
    public function delete(Request $request, Rdv $rdv): Response
    {
        if ($this->isCsrfTokenValid('delete' . $rdv->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($rdv);
            $entityManager->flush();
        }

        return $this->redirectToRoute('rdv_index', [], Response::HTTP_SEE_OTHER);
    }
}
