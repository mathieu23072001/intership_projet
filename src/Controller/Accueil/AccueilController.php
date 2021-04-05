<?php

namespace App\Controller\Accueil;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Entity\Upload;
use App\Entity\Specialite;
use App\Entity\Offre;
use App\Repository\SpecialiteRepository;
use App\Repository\OffreRepository;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use MercurySeries\FlashyBundle\FlashyNotifier;
use App\Form\RechercheNumType;
use Symfony\Component\HttpFoundation\RequestStack;


/**
 * Controller used to manage blog contents in the backend.
 *
 * 
 * 
 */

  

class AccueilController extends AbstractController
{
    
  
    /**
     * @Route("/admin/stat1",name="app_admin_stat1")
     */
     public function AdminStat1(SpecialiteRepository $speciaRepo)
    {
        // On va chercher toutes les specialites
        $specialite = $speciaRepo->findAll();

        $speciaNom = [];
        $speciaColor = [];
        $speciaCount = [];

        // On "démonte" les données pour les séparer tel qu'attendu par ChartJS
        foreach($specialite as $specialite){
            $speciaNom[] = $specialite->getNom();
            $speciaColor[] = $specialite->getColor();
            $speciaCount[] = count($specialite->getOffres());
        }
            
        return $this->render('administrateur/statOne.html.twig',[
            'speciaNom'=> json_encode($speciaNom),
            'speciaColor'=> json_encode($speciaColor),
            'speciaCount'=> json_encode($speciaCount)
        ]);
            
        
       
    }







    /**
     * @Route("/admin/stat2",name="app_admin_stat2")
     */
    public function AdminStat2(SpecialiteRepository $speciaRepo,OffreRepository $offreRepo)
    {
        // On va chercher toutes les offres par date
        $offres = $offreRepo->countByDate();
        $dates = [];
        $offresCount = [];


         // On "démonte" les données pour les séparer tel qu'attendu par ChartJS
         foreach($offres as $offre){
            $dates[] = $offre['dateOffres'];
            $offresCount[] = $offre['count'];
        }

       
            
        return $this->render('administrateur/statTwo.html.twig',[
            'dates'=> json_encode($dates),
            'offresCount'=> json_encode($offresCount),
            
        ]);
            
        
       
    }




    /**
     * @Route("/admin/stat3",name="app_admin_stat3")
     */
    public function AdminStat3(SpecialiteRepository $speciaRepo,RequestStack $requestStack)
    {
        // On va chercher toutes les specialites
        $specialite = $speciaRepo->findAll();

        $speciaNom = [];
        $speciaColor = [];
        $speciaCount = [];
       // $ip = $this->request->server->get('REMOTE_ADDR');
      // $ip = $this->$requestStack->getMasterRequest()->getClientIp();

        // On "démonte" les données pour les séparer tel qu'attendu par ChartJS
        foreach($specialite as $specialite){
            $speciaNom[] = $specialite->getNom();
            $speciaColor[] = $specialite->getColor();
            $speciaCount[] = count($specialite->getEtudiants());
        }
            
        return $this->render('administrateur/statThree.html.twig',[
            'speciaNom'=> json_encode($speciaNom),
            'speciaColor'=> json_encode($speciaColor),
            'speciaCount'=> json_encode($speciaCount)
            
            
        ]);
            
        
       
    }












    /**
     * @Route("/etudiant",name="app_etudiant")
     */

    public function Etudiant()
    {



        $user = $this->getUser();
       


        
        


            return $this->render('etudiant/accueil.html.twig', [
            'user'=> $user
        ]);
        
    }




    /**
     * @Route("/entreprise",name="app_entreprise")
     */

    public function Entreprise()
    {
        $user= $this->getUser();
        $events = $user->getEntreprises();

        foreach($events as $e) {
            $entre= $e;
           
        }



        
        return $this->render('entreprise/accueil.html.twig', [
            'entre'=> $entre
        ]);
        
    }



    /**
     * @Route("/admin",name="app_admin")
     */

    public function Admin()
    {

        return $this->render('administrateur/accueil.html.twig');
    }



     
     
    
}
