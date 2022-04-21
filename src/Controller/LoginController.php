<?php

namespace App\Controller;

use DateTime;
use App\Entity\User;
use App\Entity\UserLog;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class LoginController extends AbstractController
{
    /**
     * @Route("/login", name="login")
     */
    public function login(Request $request, AuthenticationUtils $authenticationUtils, EntityManagerInterface $entityManager): Response
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

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $last_username = $authenticationUtils->getLastUsername();

        return $this->render('login/login.html.twig', [
            'last_username' => $last_username,
            'error'         => $error,
        ]);
    }

    /**
     * @Route("/logout", name="logout", methods={"GET"})
     */
    public function logout(): void
    {
        // controller can be blank: it will never be called!
        throw new \Exception('Don\'t forget to activate logout in security.yaml');
    }

    /**
     * @Route("/register", name="register")
     */
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = new User();

        if ($this->isGranted('ROLE_USER') == true) {
            // User Logger
            $userLog = new UserLog();
            $userLog->setAction($request->attributes->get('_route'));
            $userLog->setDate(new DateTime());
            $userLog->setUser($this->getUser());
            $entityManager->persist($userLog);
            $entityManager->flush();
        }

        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
            $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $this->redirectToRoute('home');
        }

        return $this->render('login/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
