<?php

namespace App\Controller;

use App\Entity\Gnm;
use App\Form\GnmType;
use App\Repository\GnmRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/gnm')]
class GnmController extends AbstractController
{
    #[Route('/', name: 'app_gnm_index', methods: ['GET'])]
    public function index(GnmRepository $gnmRepository): Response
    {
        return $this->render('gnm/index.html.twig', [
            'gnms' => $gnmRepository->findAll(),
        ]);
    }
    #[Route('/all', name: 'all_gnm', methods: ['GET'])]
    public function allGNM(GnmRepository $gnmRepository): Response
    {
        return $this->render('gnm/all.html.twig', [
            'gnms' => $gnmRepository->findAll(),
        ]);
    }
    #[Route('/new', name: 'app_gnm_new', methods: ['GET', 'POST'])]
    public function new(Request $request, GnmRepository $gnmRepository): Response
    {
        $gnm = new Gnm();
        $form = $this->createForm(GnmType::class, $gnm);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $gnmRepository->save($gnm, true);

            return $this->redirectToRoute('app_gnm_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('gnm/new.html.twig', [
            'gnm' => $gnm,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_gnm_show', methods: ['GET'])]
    public function show(Gnm $gnm): Response
    {
        return $this->render('gnm/show.html.twig', [
            'gnm' => $gnm,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_gnm_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Gnm $gnm, GnmRepository $gnmRepository): Response
    {
        $form = $this->createForm(GnmType::class, $gnm);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $gnmRepository->save($gnm, true);

            return $this->redirectToRoute('app_gnm_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('gnm/edit.html.twig', [
            'gnm' => $gnm,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_gnm_delete', methods: ['POST'])]
    public function delete(Request $request, Gnm $gnm, GnmRepository $gnmRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$gnm->getId(), $request->request->get('_token'))) {
            $gnmRepository->remove($gnm, true);
        }

        return $this->redirectToRoute('app_gnm_index', [], Response::HTTP_SEE_OTHER);
    }
}
