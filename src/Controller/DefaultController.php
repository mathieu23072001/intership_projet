<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils; 
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

 

class DefaultController extends AbstractController
{

 /**
 * @Route("/users/login", name="app_logins",methods="POST|GET")
  */
    public function index(){

        return $this->render('page/electeur/login.html.twig');
    }
    
   



}
