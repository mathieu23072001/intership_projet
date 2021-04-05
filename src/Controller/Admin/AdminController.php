<?php

namespace App\Controller\Admin;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Entity\Upload;
use App\Entity\Candidature;
use App\Entity\Specialite;
use App\Form\SpecialiteType;
use App\Form\RefusType;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use MercurySeries\FlashyBundle\FlashyNotifier;
use App\Form\RechercheNumType;


/**
 * Controller used to manage blog contents in the backend.
 *
 * 
 * 
 */

  

class AdminController extends AbstractController
{
    
  
    /**
     * @Route("/admin/etuCandidature",name="app_admin_candidature")
     */
     public function Candidature()
    {
        $candidature= $this->getDoctrine()->getRepository(Candidature::class)->findAll();  
            
        

        return $this->render('administrateur/listCandidatures.html.twig',[
            'candidature'=> $candidature
        ]);
            
        
       
    }





    /**
     * @Route("/admin/specialite",name="app_admin_specialite")
     */
     public function Specialite(Request $request):Response{

        $specialite = new Specialite();
        $form = $this->createForm(SpecialiteType::class, $specialite);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();

        if ($form->isSubmitted() && $form->isValid()){
            
            $em->persist($specialite);
            $em->flush();
            $this->addFlash('success', 'enregistrement réussie');
            return $this->redirectToRoute("app_admin_specialite");



        }
    
        return $this->render('administrateur/specialite.html.twig', ['form' => $form->createView()]);


     }






     /**
     * @Route("/candidatConfirm/{id}", name="app_candidat_confirm")
     */
    public function candidatConfirm($id, \Swift_Mailer $mailer)
    {
        //on appelle la liste des candidatures
        $dateD = new \dateTime('now');
        $em = $this->getDoctrine()->getManager();
        $candidature = $this->getDoctrine()->getRepository(Candidature::class)->find($id);
        $etudiant= $candidature->getEtudiant();
        $entreprise = $candidature->getOffre()->getEntreprise();
        $etudiant->setEntreprise($entreprise);
        $etudiant->setDateDebut($dateD);
        $user= $this->getUser();
        $titre = $candidature->getOffre()->getTitre();
        

        

        $em->persist($etudiant);

        $em->flush();
          // Envoie de mail à l'etudiant
        $message = (new \Swift_Message('Confirmation')) 
        -> setFrom($user->getEmail())
        -> setTo($candidature->getEtudiant()->getUser()->getEmail())
        -> setBody(

         $this->renderView('emails/confirmEtu.html.twig',['titre' => $titre,'entreprise'=>$entreprise->getNom()]),
         'text/html'
        );
     
        // envoie de mail à l'entreprise
        $message1 = (new \Swift_Message('Confirmation')) 
        -> setFrom($user->getEmail())
        -> setTo($candidature->getOffre()->getEntreprise()->getUser()->getEmail())
        -> setBody(

         $this->renderView('emails/confirmEntre.html.twig',['titre' => $titre,'etudiant'=>$etudiant]),
         'text/html'
        );

        $mailer->send($message);
        $mailer->send($message1);

        
        $this->addFlash('success', 'message envoyé');
        return $this->redirectToRoute("app_admin_candidature");





       

        
        
        
        return $this->render('administrateur/listCandidatures.html.twig',[
            'candidature'=>$candidature
        ]);
    }


/**
     * @Route("/candidatRefus/{id}", name="app_candidat_refus")
     */
    public function candidatRefus($id, \Swift_Mailer $mailer,Request $request){

        $form = $this->createForm(RefusType::class);
       $contact= $form->handleRequest($request);
        $candidature = $this->getDoctrine()->getRepository(Candidature::class)->find($id);

        if ($form->isSubmitted() && $form->isValid()){
            $candidature->getOffre()->setActive(1);
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

         $this->renderView('emails/refus.html.twig',['titre' => $titre,'entreprise'=>$entreprise->getNom(),'message'=>$contact->get('message')->getData()]),
         'text/html'
        );
     



        $email2 = (new \Swift_Message('Refus de thème')) 
        -> setFrom($user->getEmail())
        -> setTo($candidature->getOffre()->getEntreprise()->getUser()->getEmail())
        -> setBody(

         $this->renderView('emails/refus.html.twig',['titre' => $titre,'entreprise'=>$entreprise->getNom(),'message'=>$contact->get('message')->getData()]),
         'text/html'
        );
        
        $mailer->send($email1);
        $mailer->send($email2);
        

        
        $this->addFlash('success', 'message de refus envoyé');
        return $this->redirectToRoute("app_admin_candidature");

           


        }











        return $this->render('administrateur/refus.html.twig', ['form' => $form->createView(),'candidature'=>$candidature]);


    }



   

/**
     * @Route("/offresDetails/{id}", name="app_candidat_details")
     */
    public function offreDetails($id)
    {
        //on appelle la liste des candidatures
        $candidature = $this->getDoctrine()->getRepository(Candidature::class)->find($id);
        $offre =  $candidature->getOffre();

       

        
        
        
        return $this->render('administrateur/details.html.twig',[
            'offre'=>$offre
        ]);
    }
    




/**
     * @Route("/stagiaireEtu/", name="app_stagiaire_etu")
     */
    public function stagiaireEtu()
    {
        //on appelle la liste des candidatures
        
        $candidature = $this->getDoctrine()->getRepository(Candidature::class)->findAll();
        

       

        
        
        
        return $this->render('administrateur/stagiaireEtu.html.twig',[
            'candidature'=>$candidature
        ]);
    }
     
    
    



    /**
     * @Route("/noStagiaireEtu/", name="app_no_stagiaire_etu")
     */
    public function noStagiaireEtu()
    {
        //on appelle la liste des candidatures
        
        $candidature = $this->getDoctrine()->getRepository(Candidature::class)->findAll();
        

       

        
        
        
        return $this->render('administrateur/noStagiaireEtu.html.twig',[
            'candidature'=>$candidature
        ]);
    }
    
}
