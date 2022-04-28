<?php

namespace App\Controller;

use DateTime;
use App\Entity\UserLog;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PageController extends AbstractController
{
    /**
     * @Route("/page1", name="page1")
     */
    public function page1(Request $request, EntityManagerInterface $entityManager): Response
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

        if ($this->isGranted('ROLE_USER') == false) {
            return $this->redirectToRoute('home');
        }
        return $this->render('pages/page1.html.twig', [
            'controller_name' => 'PageController',
        ]);
    }

    /**
     * @Route("/page2", name="page2")
     */
    public function page2(Request $request, EntityManagerInterface $entityManager): Response
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

        return $this->render('pages/page2.html.twig', [
            'controller_name' => 'PageController',
        ]);
    }

    /**
     * @Route("/page3", name="page3")
     */
    public function page3(Request $request, EntityManagerInterface $entityManager): Response
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

        return $this->render('pages/page3.html.twig', [
            'controller_name' => 'PageController',
        ]);
    }

    /**
     * @Route("/page4", name="page4")
     */
    public function page4(Request $request, EntityManagerInterface $entityManager): Response
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

        return $this->render('pages/page4.html.twig', [
            'controller_name' => 'PageController',
        ]);
    }
}
