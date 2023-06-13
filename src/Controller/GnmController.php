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
   
    #[Route('/all', name: 'all_gnm', methods: ['GET'])]
    public function allGNM(GnmRepository $gnmRepository): Response
    {
        return $this->render('gnm/all.html.twig', [
            'gnms' => $gnmRepository->findAll(),
        ]);
    }
   

    #[Route('/{id}', name: 'app_gnm_show', methods: ['GET'])]
    public function show(Gnm $gnm): Response
    {
        return $this->render('gnm/show.html.twig', [
            'gnm' => $gnm,
        ]);
    }

   

    #[Route('/{id}', name: 'app_gnm_delete', methods: ['POST'])]
    public function delete(Request $request, Gnm $gnm, GnmRepository $gnmRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$gnm->getId(), $request->request->get('_token'))) {
            $gnmRepository->remove($gnm, true);
        }

        return $this->redirectToRoute('all_gnm', [], Response::HTTP_SEE_OTHER);
    }
}
