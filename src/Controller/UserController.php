<?php

namespace App\Controller;

use DateTime;
use App\Entity\UserLog;
use App\Repository\UserLogRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    /**
     * @Route("/detail", name="detail")
     */
    public function detail(Request $request, SessionInterface $session, Security $security, EntityManagerInterface $entityManager): Response
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

        $token = $security->getToken();
        $authType = substr($token, 0, 28) === 'PostAuthenticationGuardToken'
            ? 'Google'
            : 'Symfony'
        ;

        if ($this->isGranted('ROLE_USER') == false) {
            return $this->redirectToRoute('home');
        }
        return $this->render('user/detail.html.twig', [
            'controller_name'   => 'UserController',
            'token'             => $token,
            'auth_type'         => $authType
        ]);
    }

    /**
     * @Route("/activity", name="activity")
     */
    public function activity(Request $request, UserLogRepository $userLogRepo, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();

        if ($this->isGranted('ROLE_USER') == true) {
            // User Logger
            $userLog = new UserLog();
            $userLog->setAction($request->attributes->get('_route'));
            $userLog->setDate(new DateTime());
            $userLog->setUser($this->getUser());
            $entityManager->persist($userLog);
            $entityManager->flush();
        }

        $logs = $userLogRepo->findBy([
            'user' => $user
        ]);

        if ($this->isGranted('ROLE_USER') == false) {
            return $this->redirectToRoute('home');
        }
        return $this->render('user/activity.html.twig', [
            'controller_name'   => 'UserController',
            'logs'              => $logs
        ]);
    }
}
