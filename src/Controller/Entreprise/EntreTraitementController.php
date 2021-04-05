<?php

namespace App\Controller\Entreprise;

use App\Entity\Offre;
use App\Entity\Candidature;
use App\Entity\Etudiant;
use App\Entity\Upload;
use App\Entity\ChangePassword;
use App\Form\OffreType;
use App\Form\RefusEntreType;
use App\services\swiftmailer;
use App\service;
use Doctrine\ORM\EntityManagerInterface;

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
 * @Route("/entreprise")
 * 
 */

class EntreTraitementController extends AbstractController
{ 


    

    /**
     * @Route("/publication", name="app_entreprise_publication",methods={"GET","POST"})
     */
    public function publication(Request $request,UserPasswordEncoderInterface $encoder, \Swift_Mailer $mailer): Response
    {
        $offre = new Offre();
        
        $form = $this->createForm(OffreType::class, $offre);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();


        $user= $this->getUser();
        $events = $user->getEntreprises();
        
    

        foreach ($events as $e) {
            $entreprise= $e;
            
        }
        if ($form->isSubmitted() && $form->isValid()) {
            $specialite = $offre->getSpecialite();

            $offre->setSpecialite($specialite);
            $offre->setEntreprise($entreprise);
            $offre->setActive(1);
            
            
           

            $em->persist($offre);
            $em->flush();
           
           
        

            $this->addFlash('success', 'enregistrement réussie');
            return $this->redirectToRoute("app_entreprise_publication");
        }

      

        return $this->render('entreprise/publication.html.twig', ['form' => $form->createView()]);
    }


    

    /**
     * @Route("/candidatureList", name="app_candidatureList_etudiant")
     */
    public function candidatureList()
    {
        //on appelle la liste des candidatures
        $candidature= $this->getDoctrine()->getRepository(Candidature::class)->findAll();
        
        
        return $this->render('entreprise/candidatureList.html.twig',[
            'candidature'=> $candidature
        ]);
    }




     /**
     * @Route("/candidatCv/{id}", name="app_candidat_cv")
     */
    public function candidatCv($id)
    {
        //on appelle la liste des candidatures
        $etudiant = $this->getDoctrine()->getRepository(Etudiant::class)->find($id);

        $upload = $this->getDoctrine()->getRepository(Upload::class)->findOneBy(['etudiant' => $etudiant ]);

        
        
        
        return $this->render('entreprise/cv.html.twig',[
            'upload'=>$upload
        ]);
    }
    


    /**
     * @Route("/candidatMotiv/{id}", name="app_candidat_motiv")
     */
    public function candidatMotiv($id)
    {
        //on appelle la liste des candidatures
        $candidature = $this->getDoctrine()->getRepository(Candidature::class)->find($id);

       

        
        
        
        return $this->render('entreprise/motiv.html.twig',[
            'candidature'=>$candidature
        ]);
    }



   
    /**
     * @Route("/candidatAccept/{id}", name="app_candidat_accept")
     */
    public function candidatAccept($id, \Swift_Mailer $mailer)
    {
        //on appelle la liste des candidatures
        $em = $this->getDoctrine()->getManager();
        $candidature = $this->getDoctrine()->getRepository(Candidature::class)->find($id);
        $candidature->setActive(1);
        $candidature->getOffre()->setActive(0);
        $user= $this->getUser();
        $entreprise= $candidature->getOffre()->getEntreprise()->getNom();

        $titre = $candidature->getOffre()->getTitre();

        $em->persist($candidature);

        $em->flush();
          // Envoie de mail à l'etudiant
        $message = (new \Swift_Message('Acceptation')) 
        -> setFrom($user->getEmail())
        -> setTo($candidature->getEtudiant()->getUser()->getEmail())
        -> setBody(

         $this->renderView('emails/accept.html.twig',['titre' => $titre,'entreprise'=>$entreprise]),
         'text/html'
        );
     
        // envoie de mail à l'administrateur
        $message1 = (new \Swift_Message('Acceptation')) 
        -> setFrom($candidature->getOffre()->getEntreprise()->getUser()->getEmail())
        -> setTo('admino@yopmail.com')
        -> setBody(

         $this->renderView('emails/adviceAdmin.html.twig',['titre' => $titre,'entreprise'=>$entreprise]),
         'text/html'
        );

        $mailer->send($message);
        $mailer->send($message1);

        
        $this->addFlash('success', 'message envoyé');
        return $this->redirectToRoute("app_candidatureList_etudiant");





       

        
        
        
        return $this->render('entreprise/candidatureList.html.twig',[
            'candidature'=>$candidature
        ]);
    }
   














    /**
     * @Route("/candidatKo/{id}", name="app_candidat_ko")
     */
    public function candidatKo($id, \Swift_Mailer $mailer,Request $request){

        $form = $this->createForm(RefusEntreType::class);
       $contact= $form->handleRequest($request);
        $candidature = $this->getDoctrine()->getRepository(Candidature::class)->find($id);

        if ($form->isSubmitted() && $form->isValid()){
            
            $candidature->setActive(0);
            $user= $this->getUser();
            $em = $this->getDoctrine()->getManager();
            $entreprise = $candidature->getOffre()->getEntreprise();
            $titre = $candidature->getOffre()->getTitre();
            $etudiant= $candidature->getEtudiant();

            $em->persist($candidature);

            $em->flush();






              // Envoie de mail de refus à l'etudiant et l'entreprise
        $email1 = (new \Swift_Message('Refus de thème')) 
        -> setFrom($user->getEmail())
        -> setTo($candidature->getEtudiant()->getUser()->getEmail())
        -> setBody(

         $this->renderView('emails/refusEntre.html.twig',['titre' => $titre,'entreprise'=>$entreprise->getNom(),'message'=>$contact->get('message')->getData()]),
         'text/html'
        );
     



       
        $mailer->send($email1);
        
        

        
        $this->addFlash('success', 'message de refus envoyé');
        return $this->redirectToRoute("app_candidatureList_etudiant");

           


        }











        return $this->render('entreprise/refusEntre.html.twig', ['form' => $form->createView(),'candidature'=>$candidature]);


    }



     /**
     * @Route("/publicationList/", name="app_publication_list")
     */
    public function publicationList(){

        $user= $this->getUser();
        $events = $user->getEntreprises();

        foreach($events as $e) {
            $entre= $e;
           
        }
     
        $offres = $this->getDoctrine()->getRepository(Offre::class)->findBy(['entreprise'=>$entre]);



        
        return $this->render('entreprise/publicationList.html.twig', ['offres'=>$offres]);


    }

     
    



    /**
     * @Route("/stagiaires/", name="app_stagiaires_list")
     */
    public function stagiaireList(){

        $user= $this->getUser();
        $events = $user->getEntreprises();

        foreach($events as $e) {
            $entre= $e;
           
        }
     
        $etudiant = $this->getDoctrine()->getRepository(Etudiant::class)->findBy(['entreprise'=>$entre]);

        $candidature = $this->getDoctrine()->getRepository(Candidature::class)->findBy(['etudiant'=>$etudiant]);



        
        return $this->render('entreprise/stagiaireList.html.twig', ['candidature'=>$candidature]);


    }

     

 
 

}

      

