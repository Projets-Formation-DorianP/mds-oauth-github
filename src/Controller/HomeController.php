<?php

namespace App\Controller;

use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function index(Security $security): Response
    {
        $token = $security->getToken();
        $auth_type = substr($token, 0, 28) === 'PostAuthenticationGuardToken'
            ? 'Google'
            : 'Symfony'
        ;

        return $this->render('home/index.html.twig', [
            'controller_name'   => 'HomeController',
            'token'             => $token,
            'auth_type'         => $auth_type
        ]);
    }
}
