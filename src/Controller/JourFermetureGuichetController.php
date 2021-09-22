<?php

namespace App\Controller;

use App\Entity\JourFermetureGuichet;
use App\Form\JourFermetureGuichetType;
use App\Repository\JourFermetureGuichetRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/jour/fermerguichet")
 */
class JourFermetureGuichetController extends AbstractController
{
    /**
     * @Route("/", name="jour_fermerguichet_index", methods={"GET"})
     */
    public function index(JourFermetureGuichetRepository $jourFermetureGuichetRepository): Response
    {
        return $this->render('jour_fermeture_guichet/index.html.twig', [
            'jour_fermeture_guichets' => $jourFermetureGuichetRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="jour_fermerguichet_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $jourFermetureGuichet = new JourFermetureGuichet();
        $form = $this->createForm(JourFermetureGuichetType::class, $jourFermetureGuichet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($jourFermetureGuichet);
            $entityManager->flush();

            return $this->redirectToRoute('jour_fermerguichet_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('jour_fermeture_guichet/new.html.twig', [
            'jour_fermeture_guichet' => $jourFermetureGuichet,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}/show", name="jour_fermerguichet_show", methods={"GET"})
     */
    public function show(JourFermetureGuichet $jourFermetureGuichet): Response
    {
        return $this->render('jour_fermeture_guichet/show.html.twig', [
            'jour_fermeture_guichet' => $jourFermetureGuichet,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="jour_fermerguichet_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, JourFermetureGuichet $jourFermetureGuichet): Response
    {
        $form = $this->createForm(JourFermetureGuichetType::class, $jourFermetureGuichet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('jour_fermerguichet_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('jour_fermeture_guichet/edit.html.twig', [
            'jour_fermeture_guichet' => $jourFermetureGuichet,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}/delete", name="jour_fermerguichet_delete", methods={"POST"})
     */
    public function delete(Request $request, JourFermetureGuichet $jourFermetureGuichet): Response
    {
        if ($this->isCsrfTokenValid('delete' . $jourFermetureGuichet->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($jourFermetureGuichet);
            $entityManager->flush();
        }

        return $this->redirectToRoute('jour_fermerguichet_index', [], Response::HTTP_SEE_OTHER);
    }
}
