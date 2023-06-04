<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/profile/connexion', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/admin6314a8e/connexion', name: 'admin_login')]
    public function adminLogin(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('@EasyAdmin/page/login.html.twig', [
            // parameters usually defined in Symfony login forms
            'error'                => $error,
            'last_username'        => $lastUsername,

            // OPTIONAL parameters to customize the login form:
            //
            //            // by default EasyAdmin displays a black square as its default favicon;
            //            // use this method to display a custom favicon: the given path is passed
            //            // "as is" to the Twig asset() function:
            //            // <link rel="shortcut icon" href="{{ asset('...') }}">
            //            'favicon_path' => '/favicon-admin.svg',
            'page_title'           => 'Espace d\'administration',
            'csrf_token_intention' => 'authenticate',
            'target_path'          => $this->generateUrl('admin'),
            'username_label'       => 'Identifiant',
            'password_label'       => 'Mot de passe',
            'sign_in_label'        => 'Connexion',
            'username_parameter'   => 'email',
            'password_parameter'   => 'password',
            //
            //            // whether to enable or not the "forgot password?" link (default: false)
            //            'forgot_password_enabled' => true,
            //
            //            // the path (i.e. a relative or absolute URL) to visit when clicking the "forgot password?" link (default: '#')
            //            'forgot_password_path' => $this->generateUrl('...', ['...' => '...']),
            //
            //            // the label displayed for the "forgot password?" link (the |trans filter is applied to it)
            //            'forgot_password_label' => 'Forgot your password?',
            //
            //            // whether to enable or not the "remember me" checkbox (default: false)
            //            'remember_me_enabled' => true,
            //
            //            // remember me name form field (default: '_remember_me')
            //            'remember_me_parameter' => 'custom_remember_me_param',
            //
            //            // whether to check by default the "remember me" checkbox (default: false)
            //            'remember_me_checked' => true,
            //
            //            // the label displayed for the remember me checkbox (the |trans filter is applied to it)
            //            'remember_me_label' => 'Remember me',
        ]);

//        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/profile/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
    #[Route(path: '/admin6314a8e/logout', name: 'admin_logout')]
    public function adminLogout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
