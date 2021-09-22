<?php

namespace App\Controller;

use App\Entity\Guichet;
use App\Form\GuichetType;
use App\Repository\GuichetRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/guichet")
 */
class GuichetController extends AbstractController
{
    /**
     * @Route("/", name="guichet_index", methods={"GET"})
     */
    public function index(GuichetRepository $guichetRepository): Response
    {
        return $this->render('guichet/index.html.twig', [
            'guichets' => $guichetRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="guichet_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $guichet = new Guichet();
        $form = $this->createForm(GuichetType::class, $guichet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($guichet);
            $entityManager->flush();

            return $this->redirectToRoute('guichet_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('guichet/new.html.twig', [
            'guichet' => $guichet,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}/show", name="guichet_show", methods={"GET"})
     */
    public function show(Guichet $guichet): Response
    {
        return $this->render('guichet/show.html.twig', [
            'guichet' => $guichet,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="guichet_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Guichet $guichet): Response
    {
        $form = $this->createForm(GuichetType::class, $guichet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('guichet_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('guichet/edit.html.twig', [
            'guichet' => $guichet,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}/delete", name="guichet_delete", methods={"POST"})
     */
    public function delete(Request $request, Guichet $guichet): Response
    {
        if ($this->isCsrfTokenValid('delete' . $guichet->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($guichet);
            $entityManager->flush();
        }

        return $this->redirectToRoute('guichet_index', [], Response::HTTP_SEE_OTHER);
    }
}
