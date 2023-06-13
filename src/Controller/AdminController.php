<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(EntityManagerInterface $entityManager): Response
    {
    /***reclamations */
        $query = $entityManager->createQuery('SELECT t FROM App\Entity\Reclamation t');
        $reclamations = $query->getResult();

    /***Bateaux */
        $query = $entityManager->createQuery('SELECT t FROM App\Entity\Bateaux t');
        $Bateaux = $query->getResult();

    /***AgentMer  */
       $query = $entityManager->createQuery('SELECT t FROM App\Entity\AgentMer t');
       $AgentMer = $query->getResult();

    /***GNM  */
     $query = $entityManager->createQuery('SELECT t FROM App\Entity\Gnm t');
     $Gnm = $query->getResult();
  

        return $this->render('admin/dashboard.html.twig', [
            'controller_name' => 'AdminController',
            'reclamationsCount' =>count($reclamations),
            'AgentMerCount' =>count( $AgentMer ),
            'GnmCount' =>count( $Gnm ),
            'BateauxCount' =>count( $Bateaux ),
        ]);
    }
}
