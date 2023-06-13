<?php

namespace App\Controller;

use App\Entity\Bateaux;
use App\Form\BateauxType;
use App\Form\BateauxSearchType;
use App\Repository\BateauxRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/bateaux')]
class BateauxController extends AbstractController
{

    #[Route('/search', name: 'ajax_search', methods: ['GET'])]
    public function searchAction(Request $request, BateauxRepository $charityDemandRepository): Response
    {
        $em = $this->getDoctrine()->getManager();

        $requestString = $request->get('q');

        $charitydemands = $em->getRepository('App\Entity\Bateaux')->findEntitiesByString($requestString);

        if (!$charitydemands) {
            $result['charity_demands']['error'] = "NOT FOUND";
        } else {
            $result['charity_demands'] = $this->getRealEntities($charitydemands);
        }

        return new Response(json_encode($result));
    }
    public function getRealEntities($charitydemands)
    {

        foreach ($charitydemands as $charitydemand) {
            $realEntities[$charitydemand->getId()] = $charitydemand->getMat();
        }
        return $realEntities;
    }
    #[Route('/view', name: 'app_charity_demand_View', methods: ['GET', 'POST'])]
    public function View(BateauxRepository $charityDemandRepository,  Request $request): Response
    {
        $charitydemands = $charityDemandRepository->findAll();
        $form = $this->createForm(BateauxSearchType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $searchquery = $form->getData()['Mat'];   
            $searchquery = $form->getData()['type'];         
            $charitydemands = $charityDemandRepository->search($searchquery);
        }
        return $this->render('bateaux/search.html.twig', [
            'charity_demands' => $charitydemands,
            'form' => $form->createView()
        ]);
    }



    #[Route('/', name: 'app_bateaux_index', methods: ['GET'])]
    public function index(BateauxRepository $bateauxRepository): Response
    {
        return $this->render('bateaux/index.html.twig', [
            'bateauxes' => $bateauxRepository->findAll(),
        ]);
    }
    #[Route('/listBateauxGNM', name: 'app_listBateauxGNM', methods: ['GET'])]
    public function listBateauxGNM(BateauxRepository $bateauxRepository): Response
    {
        return $this->render('bateaux/listBateauxGNM.html.twig', [
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

    #[Route('/GNM/{id}', name: 'app_BateauxGNM_show', methods: ['GET'])]
    public function showBateauxGNM(Bateaux $bateaux): Response
    {
        return $this->render('bateaux/showBateauxGNM.html.twig', [
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


    // #[Route('/details/{id}', name: 'compte_details', methods: ['GET'])]
    // public function show(Compte $compte): Response
    // {
    //     return $this->render('compte/details.html.twig', [
    //         'compte' => $compte,
    //     ]);
    // }
    

}
