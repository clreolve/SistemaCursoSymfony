<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Security\AppCustomAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;

#[Route('/registro')]
class RegisterController extends AbstractController
{
    #[Route('/', name: 'registro')]
    public function register(
        Request $request, 
        UserPasswordHasherInterface $hasher, 
        UserAuthenticatorInterface $u_auth,
        AppCustomAuthenticator $authenticator,
        EntityManagerInterface $em ): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $user->setPassword(
                $hasher->hashPassword(
                    $user,
                    $form->get('password')->getData()
                )
            );

            $em->persist($user);
            $em->flush();

            return $u_auth->authenticateUser(
                $user,
                $authenticator,
                $request
            );
        }
        return $this->render('register/index.html.twig', [
            'registrationForm' => $form->createView()
        ]);
    }
}
