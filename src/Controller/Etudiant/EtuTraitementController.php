<?php

namespace App\Controller\Etudiant;

use App\Entity\Etudiant;
use App\Entity\User;
use App\Entity\Upload;
use App\Entity\Offre;
use App\Entity\Candidature;
use App\Entity\ChangePassword;
use App\Form\EtudiantType;
use App\Form\UploadType;
use App\Form\updateEtuType;
use App\Form\ContactType;
use App\Form\SearchOffreType;
use App\Repository\OffreRepository;
use App\Form\ResetPasswordType;
use Doctrine\DBAL\Types\StringType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
/**
 * Controller used to manage blog contents in the backend.
 *
 * @Route("/etudiant")
 * 
 */

class EtuTraitementController extends AbstractController
{ 

    /**
     * @Route("/upload", name="app_upload_etudiant",methods={"GET","POST"})
     */
    public function upload(Request $request,UserPasswordEncoderInterface $encoder): Response
    {
        $upload = new Upload();
        $user= $this->getUser();
        $events = $user->getEtudiants();

        foreach($events as $e) {
            $etu= $e;
           
        }
        

       
        $form = $this->createForm(UploadType::class, $upload);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        if ($form->isSubmitted() && $form->isValid()) {
            
            $file = $upload->getName();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $file->move($this->getParameter('upload_directory'),$fileName);
            $upload->setName($fileName);
        
            $upload->setEtudiant($etu);

            $em->persist($upload);
        
            $em->flush();
            
            $this->addFlash('success', 'Enregistrement réussi.');
            return $this->redirectToRoute("app_update_etudiant");
        }


        return $this->render('etudiant/etuFile.html.twig', ['form' => $form->createView()]);
    }


    










     /**
     * @Route("/update/", name="app_update_etudiant",methods={"GET","POST"})
     */
    public function update (Request $request): Response
    {
        $etudiant = new Etudiant();
        $user= $this->getUser();
        $events = $user->getEtudiants();
        
    

        foreach ($events as $e) {
            $etu= $e;
            
        }
        

       
            $form = $this->createForm(updateEtuType::class, $etudiant);
            $form->handleRequest($request);
            $em = $this->getDoctrine()->getManager();
            if ($form->isSubmitted() && $form->isValid()) {
               $etu->setNiveau($etudiant->getNiveau());
               $etu->setSpecialite($etudiant->getSpecialite());
               
               $etu->setLangage($etudiant->getLangage());
               $etu->getUser()->setCount(1);


                $em->persist($etu);
                
                $em->flush();
            
           
        

                $this->addFlash('success', 'enregistrement réussie');
                return $this->redirectToRoute("app_etudiant");
            }
        


        return $this->render('etudiant/updateEtu.html.twig', ['form' => $form->createView()]);
    }


    
 /**
     * @Route("/offreList", name="app_offreList_etudiant")
     */
    public function offreList(Request $request,OffreRepository $offreRepo): Response
    {
        $dispo = 1;
       $offres= $this->getDoctrine()->getRepository(Offre::class)->findby(['active'=>$dispo]);
      //  $offres= $this->getDoctrine()->getRepository(Offre::class)->findAll();
        $form = $this->createForm(SearchOffreType::class);
        $search = $form->handleRequest($request);

        
        $user= $this->getUser();
        $events = $user->getEtudiants();
        
    

        foreach ($events as $e) {
            $etu= $e;
            
        }
       

        if ($form->isSubmitted() && $form->isValid()) {
            $offres= $offreRepo->search(
                $search->get('mots')->getData(),
                $search->get('specialite')->getData()
            );
        }
        

        

        
        
            return $this->render('etudiant/offresList.html.twig', [
            'offres'=> $offres, 'form'=>$form->createView(),'etu'=>$etu
        ]);
        }
    






        /**
     * @Route("/contact/{id}", name="app_contact_entreprise")
     */
    public function contact(Request $request,OffreRepository $offreRepo,$id, \Swift_Mailer $mailer): Response
    {
        $offres= $this->getDoctrine()->getRepository(Offre::class)->find($id);
        $titre = $offres->getTitre();
        
        
        $candidature = new Candidature();

        $form = $this->createForm(ContactType::class,$candidature);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();

        $user= $this->getUser();
        $events = $user->getEtudiants();
        
    

        foreach ($events as $e) {
            $etu= $e;
            
        }

        $entreprise = $offres->getEntreprise();
       
       
       
       

        if ($form->isSubmitted() && $form->isValid()) {
            $candidature->setOffre($offres);
            $candidature->setEtudiant($etu);
        
            $em->persist($candidature);
            $em->flush();

            
            $message = (new \Swift_Message('Candidature pour stage'))
               -> setFrom($user->getEmail())
               -> setTo($entreprise->getUser()->getEmail())
               -> setBody(
                   $this->renderView('emails/demande_candidature.html.twig', ['titre' => $titre]),
                   'text/html'
               );

            $mailer->send($message);

               
            $this->addFlash('success', 'message envoyé');
            return $this->redirectToRoute("app_offreList_etudiant");
        }
        
            return $this->render('etudiant/contact.html.twig', [
            'offres'=> $offres, 'form'=>$form->createView()
        ]);
        }
    













 
 

}

      

