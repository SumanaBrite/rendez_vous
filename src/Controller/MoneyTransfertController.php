<?php
  
namespace App\Controller;

use App\Entity\MoneyTransfert;
use App\Form\MoneyTransfertType;
use App\Repository\MoneyTransfertRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/money/transfert")
 */
class MoneyTransfertController extends AbstractController
{
    /**
     * @Route("/", name="money_transfert_index", methods={"GET"})
     */
    public function index(MoneyTransfertRepository $moneyTransfertRepository): Response
    {
        return $this->render('money_transfert/index.html.twig', [
            'money_transferts' => $moneyTransfertRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="money_transfert_new", methods={"GET","POST"})
     */
    public function new(Request $request, SluggerInterface $slugger): Response
    {
        $moneyTransfert = new MoneyTransfert();
        $form = $this->createForm(MoneyTransfertType::class, $moneyTransfert);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            $imagesDirectory = "images/uploads/";
            $imageFile = $form->get('path')->getData();
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                // on crée un nom unique de stockage du fichier
                $safeFileName = $slugger->slug($originalFilename);
                $finalFilename = $safeFileName . '-' . uniqid() . '.' . $imageFile->guessExtension();
                // on essaye de deplacer le fichier à sa place finale, sur le serveur
                $imageFile->move($imagesDirectory, $finalFilename);
                // Mise à jour du champ path dans l'objet image
                $moneyTransfert->setPath($finalFilename);
            }


            $entityManager->persist($moneyTransfert);
            $entityManager->flush();

            return $this->redirectToRoute('money_transfert_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('money_transfert/new.html.twig', [
            'money_transfert' => $moneyTransfert,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}/show", name="money_transfert_show", methods={"GET"})
     */
    public function show(MoneyTransfert $moneyTransfert): Response
    {
        return $this->render('money_transfert/show.html.twig', [
            'money_transfert' => $moneyTransfert,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="money_transfert_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, MoneyTransfert $moneyTransfert, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(MoneyTransfertType::class, $moneyTransfert);
        $old_path = $moneyTransfert->getPath();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imagesDirectory = "images/uploads/";
            // donc, on commence par récuperer ce qui a été uploadé
            $imageFile = $form->get('path')->getData();
            // on test, au cas ou
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                // on crée un nom unique de stockage du fichier
                $safeFileName = $slugger->slug($originalFilename);
                $finalFilename = $safeFileName . '-' . uniqid() . '.' . $imageFile->guessExtension();
                // on essaye de deplacer le fichier à sa place finale, sur le serveur
                $imageFile->move($imagesDirectory, $finalFilename);
                // Mise à jour à jour du champ path dans l'objet image
                $moneyTransfert->setPath($finalFilename);
                
                if ($old_path != "") {
                
                    $old_path = $imagesDirectory . $old_path;
                    // unlink($old_path);
                }
            }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('money_transfert_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('money_transfert/edit.html.twig', [
            'money_transfert' => $moneyTransfert,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}/delete", name="money_transfert_delete", methods={"POST"})
     */
    public function delete(Request $request, MoneyTransfert $moneyTransfert): Response
    {
        if ($this->isCsrfTokenValid('delete'.$moneyTransfert->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($moneyTransfert);
            $entityManager->flush();
        }

        return $this->redirectToRoute('money_transfert_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/voir-les-taux", name="money_transfert_taux", methods={"GET"})
     */
    public function taux(MoneyTransfertRepository $moneyTransfertRepository): Response
    {
        return $this->render('money_transfert/taux.html.twig', [
            'money_transferts' => $moneyTransfertRepository->findAll(),
        ]);
    }
    

}
