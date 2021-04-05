<?php

namespace App\Controller\Entreprise;

use App\Entity\Entreprise;
use App\Entity\ChangePassword;
use App\Form\EntrepriseType;
use App\services\swiftmailer;
use App\service;

use App\Form\ResetPasswordType;
use App\Repository\UserRepository;
use Doctrine\DBAL\Types\StringType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Notifications\CreationCompteNotification;
use App\Notifications\ActivationCompteNotification;
use \Swift_Message;
use \Swift_Mailer;
/**
 * Controller used to manage blog contents in the backend.
 *
 * @Route("/user")
 * 
 */

class EntrepriseRController extends AbstractController
{ 


    

    /**
     * @Route("/register/entreprise", name="app_register_entreprise",methods={"GET","POST"})
     */
    public function register(Request $request,UserPasswordEncoderInterface $encoder, \Swift_Mailer $mailer): Response
    {
        $entreprise = new Entreprise();
        
        $form = $this->createForm(EntrepriseType::class, $entreprise);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        if ($form->isSubmitted() && $form->isValid()) {
            
    
        
            $hash= $encoder->encodePassword($entreprise->getUser(), $entreprise->getUser()->getPassword());
            $entreprise->getUser()->setActivationToken(md5(uniqid()));
            $entreprise->getUser()->setCount(0);
            $entreprise->getUser()->setPassword($hash);
            $entreprise->getUser()->setRoles(["ROLE_ENTREPRISE"]);
           

            $em->persist($entreprise);
            $em->flush();
            $message = (new \Swift_Message('Activation de votre compte')) 
               -> setFrom('mathieuawukud23@gmail.com')
               -> setTo($entreprise->getUser()->getEmail())
               -> setBody(

                $this->renderView('emails/ajout_entreprise.html.twig',['token' => $entreprise->getUser()->getActivationToken()]),
                'text/html'
               );

               $mailer->send($message);
           
        

            $this->addFlash('success', 'enregistrement réussie');
            return $this->redirectToRoute("app_advice_mail");
        }

      

        return $this->render('entreprise/inscription.html.twig', ['form' => $form->createView()]);
    }


    
/**
     * @Route("/activation/entreprise/{token}", name="app_entreprise_activation",methods={"GET","POST"})
     */

     public function activation($token, UserRepository $usersRepo){

         // On vérifie si un utilisateur a ce token
         $user = $usersRepo->findOneBy(['activation_token' => $token]); 


          // Si aucun utilisateur n'existe avec ce token
        if(!$user){
            // Erreur 404
            throw $this->createNotFoundException('Cet utilisateur n\'existe pas');
        } 


        // On supprime le token
        $user->setActivationToken(null);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($user);
        $entityManager->flush();


         // On envoie un message flash
         $this->addFlash('message', 'Vous avez bien activé votre compte');

         // On retoure à l'accueil
         

         return $this->redirectToRoute('app_advice_activation');
         
     }




      /**
     * @Route("/adviceMail",name="app_advice_mail")
     */
    public function Advice()
    {
        
            
        return $this->render('advice/adviceMail.html.twig');
            
        
       
    }




     /**
     * @Route("/adviceActivation",name="app_advice_activation")
     */
    public function Active()
    {
        
            
        return $this->render('advice/adviceActivation.html.twig');
            
        
       
    }
   



    
   


    

 
 

}

      

