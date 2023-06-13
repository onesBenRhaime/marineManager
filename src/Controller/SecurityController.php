<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\LoginType;
use App\Form\RegistrationType;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Entity\User;
use App\Entity\AgentMer;
use App\Form\AgentMerType;
use App\Repository\AgentMerRepository;
use App\Entity\Gnm;
use App\Form\GnmType;
use App\Repository\GnmRepository;


class SecurityController extends AbstractController
{
    #[Route('/', name: 'security_login', priority: 1)]
    public function login(AuthenticationUtils $utils): Response
    {        
        $form = $this->createForm(LoginType::class, ['email' => $utils->getLastUsername()]);
        dump($utils->getLastUsername(), $utils->getLastAuthenticationError());
        return $this->render('security/login.html.twig', [
            'formView' => $form->createView(),
            'error' => $utils->getLastAuthenticationError()
        ]);
    }


    /******version 2  

    #[Route(path: '/login', name: 'security_login')]
    public function login(AuthenticationUtils $authenticationUtils,): Response
    {  
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        
        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }*/

    /**version 2***/

    #[Route('/logout', name: 'security_logout')]
    public function logout(): Response
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
/**NO */

    #[Route('/registration', name: 'security_registration')]
    public function registration(Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $passwordHasher)
    {
        $user = new User;
        $user->setRoles([]); // Initialize roles as an empty array
        $form = $this->createForm(RegistrationType::class, $user);
        if ($form->handleRequest($request)->isSubmitted() && $form->isValid()) {

            $hash = $passwordHasher->hashPassword($user, $user->getPassword());
            $user->setPassword($hash);
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('security_logout');
        }
        return $this->render('security/registration.html.twig', [
            'formView' => $form->createView()
        ]);
    }

/**NO */

#[Route('/registerAgent', name: 'agent_registration')]
public function AgentRegistration(Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $passwordHasher,AgentMerRepository $agentMerRepository)
{
    $user = new User;
    $user->setRoles(["ROLE_AGENT"]); // Initialize roles as an Agent
    $form = $this->createForm(RegistrationType::class, $user);
    if ($form->handleRequest($request)->isSubmitted() && $form->isValid()) {

        $hash = $passwordHasher->hashPassword($user, $user->getPassword());
        $user->setPassword($hash);
        $em->persist($user);
        $em->flush();
         /***ADD to AgentMer Table */
         $agentMer = new AgentMer();            
         $agentMer->setNom($user->getLastName()); 
         $agentMer->setPrenom($user->getFirstName()); 
         $agentMer->setPsw($user->getPassword()); 
         $agentMer->setEmail($user->getEmail()); 
         $agentMer->setTel($user->getTel());  
         $agentMer->setGrade("Marine Marchande"); 
         $em->persist($agentMer); // Persist the AgentMer entity
         $em->flush(); // Flush changes for both entities
 
       //  $agentMerRepository->save($agentMer, true);
         /****/
        return $this->redirectToRoute('security_logout');
    }
    return $this->render('security/registrationAgent.html.twig', [
        'formView' => $form->createView()
    ]);
} 

#[Route('/registerGnm', name: 'gnm_registration')]
public function GnmRegistration(Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $passwordHasher,GnmRepository $gnmRepository)
{
    $user = new User;
    $user->setRoles(["ROLE_GNM"]); // Initialize roles as an GNM
    $form = $this->createForm(RegistrationType::class, $user);
    if ($form->handleRequest($request)->isSubmitted() && $form->isValid()) {

        $hash = $passwordHasher->hashPassword($user, $user->getPassword());
        $user->setPassword($hash);
        $em->persist($user);
        $em->flush();

        /***ADD to GNM Table */
        $gnm = new Gnm();            
        $gnm->setNom($user->getLastName()); 
        $gnm->setPrenom($user->getFirstName()); 
        $gnm->setPsw($user->getPassword()); 
        $gnm->setEmail($user->getEmail()); 
        $gnm->setTel($user->getTel());            
        $gnmRepository->save($gnm, true);
        /****/
        return $this->redirectToRoute('security_logout');
    }
    return $this->render('security/registration.html.twig', [
        'formView' => $form->createView()
    ]);
} 

}
