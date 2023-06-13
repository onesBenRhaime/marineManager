<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ReclamationRepository;
use App\Repository\AgentMerRepository;
use App\Entity\Gnm;
use App\Form\GnmType;
use App\Repository\GnmRepository;
use App\Entity\AgentMer;
use App\Form\AgentMerType;
use Doctrine\ORM\EntityManagerInterface;

class AuthentificationController extends AbstractController
{

    



    #[Route('/dashAgent', name: 'dash_agent')]
    public function dash_agent(EntityManagerInterface $entityManager): Response
    {
          /***reclamations */
          $query = $entityManager->createQuery('SELECT t FROM App\Entity\Reclamation t');
          $reclamations = $query->getResult();
   
          /***reclamations */
            $query = $entityManager->createQuery('SELECT t FROM App\Entity\Bateaux t');
            $Bateaux = $query->getResult();
 
        return $this->renderForm('authentification/indexAgentMer.html.twig', [
            'controller_name' => 'app_authentification',
            'reclamationsCount' =>count($reclamations),
            'bateauxCount' =>count($Bateaux),
        ]);
    }
    #[Route('/dashGnm', name: 'dash_gnm')]
    public function dash_gnm(ReclamationRepository $reclamationRepository,EntityManagerInterface $entityManager): Response
    {
         /***reclamations */
         $query = $entityManager->createQuery('SELECT t FROM App\Entity\Reclamation t');
         $reclamations = $query->getResult();
  
         /***reclamations */
           $query = $entityManager->createQuery('SELECT t FROM App\Entity\Bateaux t');
           $Bateaux = $query->getResult();

         


        return $this->renderForm('authentification/indexGnm.html.twig', [
            'controller_name' => 'app_authentification',
            'reclamations' => $reclamationRepository->findAll(),
            'reclamationsCount' =>count($reclamations),
            'bateauxCount' =>count($Bateaux),
        ]);
    }
}
