<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

#[Route('/security')]
class SecurityController extends AbstractController
{

    #[Route('/security', name: 'app_login')]
    public function index(AuthenticationUtils $auth): Response
    {
        $error = $auth->getLastAuthenticationError();
        $last_user = $auth->getLastUsername();

        return $this->render('security/index.html.twig', [
            'last_user' => $last_user,
            'error' => $error
        ]);
    }

    

    #[Route('/logout', name: 'app_logout')]
    public function logout(AuthenticationUtils $auth): void
    {
        
    }

}
