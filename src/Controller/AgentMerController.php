<?php

namespace App\Controller;

use App\Entity\AgentMer;
use App\Form\AgentMerType;
use App\Repository\AgentMerRepository;
use App\Entity\Reclamation;
use App\Repository\ReclamationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/agent/mer')]
class AgentMerController extends AbstractController
{
   
    #[Route('/', name: 'app_agent_mer_index', methods: ['GET'])]
    public function index(ReclamationRepository $reclamationRepository,AgentMerRepository $agentMerRepository): Response
    {
        return $this->render('agent_mer/index.html.twig', [
            'agent_mers' => $agentMerRepository->findAll(),
            'reclamations' => $reclamationRepository->findAll(),
        ]);
    }
    //all agentMer
    #[Route('/all', name: 'all_agent_mer', methods: ['GET'])]
    public function allAgentMer(AgentMerRepository $agentMerRepository): Response
    {
        return $this->render('agent_mer/all.html.twig', [
            'agent_mers' => $agentMerRepository->findAll(),
         
        ]);
    }
    //get all reclamations
    #[Route('/', name: 'app_reclamation', methods: ['GET'])]
    public function allReclamation(ReclamationRepository $reclamationRepository): Response
    {
        return $this->render('agent_mer/index.html.twig', [
            'reclamations' => $reclamationRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_agent_mer_new', methods: ['GET', 'POST'])]
    public function new(Request $request, AgentMerRepository $agentMerRepository): Response
    {
        $agentMer = new AgentMer();
        $form = $this->createForm(AgentMerType::class, $agentMer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $agentMerRepository->save($agentMer, true);

            return $this->redirectToRoute('app_agent_mer_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('agent_mer/new.html.twig', [
            'agent_mer' => $agentMer,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_agent_mer_show', methods: ['GET'])]
    public function show(AgentMer $agentMer): Response
    {
        return $this->render('agent_mer/show.html.twig', [
            'agent_mer' => $agentMer,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_agent_mer_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, AgentMer $agentMer, AgentMerRepository $agentMerRepository): Response
    {
        $form = $this->createForm(AgentMerType::class, $agentMer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $agentMerRepository->save($agentMer, true);

            return $this->redirectToRoute('app_agent_mer_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('agent_mer/edit.html.twig', [
            'agent_mer' => $agentMer,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_agent_mer_delete', methods: ['POST'])]
    public function delete(Request $request, AgentMer $agentMer, AgentMerRepository $agentMerRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$agentMer->getId(), $request->request->get('_token'))) {
            $agentMerRepository->remove($agentMer, true);
        }

        return $this->redirectToRoute('app_agent_mer_index', [], Response::HTTP_SEE_OTHER);
    }
    
}
