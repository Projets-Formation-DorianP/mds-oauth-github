<?php

namespace App\Controller;

use DateTime;
use App\Entity\UserLog;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        if ($this->isGranted('ROLE_USER') == true) {
            // User Logger
            $userLog = new UserLog();
            $userLog->setAction($request->attributes->get('_route'));
            $userLog->setDate(new DateTime());
            $userLog->setUser($this->getUser());
            $entityManager->persist($userLog);
            $entityManager->flush();
        }

        return $this->render('home/index.html.twig', [
            'controller_name'   => 'HomeController'
        ]);
    }
}
