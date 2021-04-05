<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use symfony\component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller; //permet d'accéder à plusieurs services de paginator avec la méthode get de la classe.


/**
 * Controller used to manage blog contents in the backend.
 *
 * @Route("/test")
 * 
 */
class testController extends AbstractController
{
    /**
     * @Route("/one/", name="app_testi",methods="POST|GET")
     */
    public function Test()
    {
    
        return $this->render('page/test.html.twig');
    }

}