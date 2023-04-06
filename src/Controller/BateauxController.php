<?php

namespace App\Controller;

use App\Entity\Bateaux;
use App\Form\BateauxType;
use App\Repository\BateauxRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/bateaux')]
class BateauxController extends AbstractController
{
    #[Route('/', name: 'app_bateaux_index', methods: ['GET'])]
    public function index(BateauxRepository $bateauxRepository): Response
    {
        return $this->render('bateaux/index.html.twig', [
            'bateauxes' => $bateauxRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_bateaux_new', methods: ['GET', 'POST'])]
    public function new(Request $request, BateauxRepository $bateauxRepository): Response
    {
        $bateaux = new Bateaux();
        $form = $this->createForm(BateauxType::class, $bateaux);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bateauxRepository->save($bateaux, true);

            return $this->redirectToRoute('app_bateaux_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('bateaux/new.html.twig', [
            'bateaux' => $bateaux,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_bateaux_show', methods: ['GET'])]
    public function show(Bateaux $bateaux): Response
    {
        return $this->render('bateaux/show.html.twig', [
            'bateaux' => $bateaux,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_bateaux_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Bateaux $bateaux, BateauxRepository $bateauxRepository): Response
    {
        $form = $this->createForm(BateauxType::class, $bateaux);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bateauxRepository->save($bateaux, true);

            return $this->redirectToRoute('app_bateaux_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('bateaux/edit.html.twig', [
            'bateaux' => $bateaux,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_bateaux_delete', methods: ['POST'])]
    public function delete(Request $request, Bateaux $bateaux, BateauxRepository $bateauxRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$bateaux->getId(), $request->request->get('_token'))) {
            $bateauxRepository->remove($bateaux, true);
        }

        return $this->redirectToRoute('app_bateaux_index', [], Response::HTTP_SEE_OTHER);
    }
}
