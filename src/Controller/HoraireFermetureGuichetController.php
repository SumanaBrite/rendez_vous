<?php

namespace App\Controller;

use App\Entity\HoraireFermetureGuichet;
use App\Form\HoraireFermetureGuichetType;
use App\Repository\HoraireFermetureGuichetRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/horaire/fermerguichet")
 */
class HoraireFermetureGuichetController extends AbstractController
{
    /**
     * @Route("/index", name="horaire_fermerguichet_index", methods={"GET"})
     */
    public function index(HoraireFermetureGuichetRepository $horaireFermetureGuichetRepository): Response
    {
        return $this->render('horaire_fermeture_guichet/index.html.twig', [
            'horaire_fermeture_guichets' => $horaireFermetureGuichetRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="horaire_fermerguichet_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $horaireFermetureGuichet = new HoraireFermetureGuichet();
        $form = $this->createForm(HoraireFermetureGuichetType::class, $horaireFermetureGuichet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($horaireFermetureGuichet);
            $entityManager->flush();

            return $this->redirectToRoute('horaire_fermeture_guichet_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('horaire_fermeture_guichet/new.html.twig', [
            'horaire_fermeture_guichet' => $horaireFermetureGuichet,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}/show/", name="horaire_fermerguichet_show", methods={"GET"})
     */
    public function show(HoraireFermetureGuichet $horaireFermetureGuichet): Response
    {
        return $this->render('horaire_fermeture_guichet/show.html.twig', [
            'horaire_fermeture_guichet' => $horaireFermetureGuichet,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="horaire_fermerguichet_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, HoraireFermetureGuichet $horaireFermetureGuichet): Response
    {
        $form = $this->createForm(HoraireFermetureGuichetType::class, $horaireFermetureGuichet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('horaire_fermerguichet_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('horaire_fermeture_guichet/edit.html.twig', [
            'horaire_fermeture_guichet' => $horaireFermetureGuichet,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}/delete/", name="horaire_fermerguichet_delete", methods={"POST"})
     */
    public function delete(Request $request, HoraireFermetureGuichet $horaireFermetureGuichet): Response
    {
        if ($this->isCsrfTokenValid('delete' . $horaireFermetureGuichet->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($horaireFermetureGuichet);
            $entityManager->flush();
        }

        return $this->redirectToRoute('horaire_fermeture_guichet_index', [], Response::HTTP_SEE_OTHER);
    }
}
