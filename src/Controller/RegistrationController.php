<?php

namespace App\Controller;

use App\Entity\Addresses;
use App\Entity\Users;
use App\Form\AddressRegistrationFormType;
use App\Form\RegistrationFormType;
use App\Repository\UsersRepository;
use App\Security\UsersAuthenticator;
use App\Service\JWTService;
use App\Service\SendMailService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;

class RegistrationController extends AbstractController
{
    #[Route('/inscription', name: 'app_register')]
    public function register(
        Request $request,
        UserPasswordHasherInterface $userPasswordHasher,
        UserAuthenticatorInterface $userAuthenticator,
        UsersAuthenticator $authenticator, 
        EntityManagerInterface $entityManager,
        SendMailService $mailer,
        JWTService $jwt): Response
    {
        $user = new Users();
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


            // générer le jwt de l'utilisateur:
            // 1. créer le header (voir le doc su jwt.io)
            $header = [
                'alg' => 'HS256',
                'typ' => 'JWT'
            ];

            // 2. créer le payload
            $payload = [
                'user_id' => $user->getId()
            ];

            // 3. génerer le token
            $token = $jwt->generate($header, $payload, $this->getParameter('app.jwtsecret'));

            // dd($token);

            // envoie d'un emal
            $mailer->send(
                'no-reply@playducatif.fr',
                $user->getEmail(),
                'Activation de votre compte sur le site Playducatif',
                'register',
                [
                    'user'=>$user,
                    'token' => $token
                ]
                );


            return $userAuthenticator->authenticateUser(
                $user,
                $authenticator,
                $request
            );
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    #[Route('/verification/{token}', name: 'verify_user')]
    public function verifyUser($token, JWTService $jwt, UsersRepository $usersRepository, EntityManagerInterface $entityManager): Response
    {
    //    dd($jwt->isValid($token));
    // dd($jwt->getPayload($token));
    // dd($jwt->isExpired($token));
    // dd($jwt->check($token, $this->getParameter('app.jwtsecret')));

    // verification si le token est valide, n'a pas éxpire et n'ai pas été modifié
    if ($jwt->isValid($token) && !$jwt->isExpired($token) && $jwt->check($token, $this->getParameter('app.jwtsecret'))) {
        // recuperation de payload
        $payload = $jwt->getPayload($token);

        // recuperation d'utilisateur de token
        $user = $usersRepository->find($payload['user_id']);

        // vérification que l'utilisateur existe et n'apas encore activé son commpte
        if ($user && !$user->getIsVerified()) {
            $user->setIsVerified(true);
            $entityManager->flush($user);
            $this->addFlash('success', 'Votre compte est activé');
            return $this->redirectToRoute('home');
        }
    }
    dd($jwt->check($token, $this->getParameter('app.jwtsecret')));
    // ici un probleme se pose dans le token 
    $this->addFlash('danger', 'Le token est invalide ou a expiré');
    return $this->redirectToRoute('home');
    }

    

    #[Route('/renvoiverif', name: 'resend_verif')]
    public function resendVerif(JWTService $jwt, SendMailService $mailer, UsersRepository $user): Response
    {
        // recuperer le user connecté
        $user = $this->getUser();

        if (!$user) {
            $this->addFlash('danger', 'Vous devez être connecté pour accéder à cette page');
            return $this->redirectToRoute('app_login');
        }

        if ($user->getIsVerified()) {
            $this->addFlash('warning', 'Cet utilisateur est deja activé');
            return $this->redirectToRoute('profile');
        }
            // générer le jwt de l'utilisateur:
            // 1. créer le header (voir le doc su jwt.io)
            $header = [
                'alg' => 'HS256',
                'typ' => 'JWT'
            ];

            // 2. créer le payload
            $payload = [
                'user_id' => $user->getId()
            ];

            // 3. génerer le token
            $token = $jwt->generate($header, $payload, $this->getParameter('app.jwtsecret'));

            // dd($token);

            // envoie d'un emal
            $mailer->send(
                'no-reply@playducatif.fr',
                $user->getEmail(),
                'Activation de votre compte sur le site Playducatif',
                'register',
                [
                    'user'=>$user,
                    'token' => $token
                ]
                );

                $this->addFlash('success', 'Email de verification envoyé');
                return $this->redirectToRoute('home');
    

    }

}
