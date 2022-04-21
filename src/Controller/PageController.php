<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PageController extends AbstractController
{
    /**
     * @Route("/page1", name="page1")
     */
    public function page1(): Response
    {
        if ($this->isGranted('ROLE_USER') == false) {
            return $this->redirectToRoute('home');
        }
        return $this->render('page/page1.html.twig', [
            'controller_name' => 'PageController',
        ]);
    }

    /**
     * @Route("/page2", name="page2")
     */
    public function page2(): Response
    {
        return $this->render('page/page2.html.twig', [
            'controller_name' => 'PageController',
        ]);
    }

    /**
     * @Route("/page3", name="page3")
     */
    public function page3(): Response
    {
        return $this->render('page/page3.html.twig', [
            'controller_name' => 'PageController',
        ]);
    }

    /**
     * @Route("/page4", name="page4")
     */
    public function page4(): Response
    {
        return $this->render('page/page4.html.twig', [
            'controller_name' => 'PageController',
        ]);
    }
}
