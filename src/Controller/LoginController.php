<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
class LoginController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // Jeśli użytkownik jest już zalogowany, przekieruj go np. na stronę główną
        if ($this->getUser()) {
            return $this->redirectToRoute('home_index'); // Zmień 'app_home' na nazwę Twojej trasy domowej
        }

        // Pobierz błąd logowania, jeśli wystąpił
        $error = $authenticationUtils->getLastAuthenticationError();

        // Ostatnio wprowadzony login
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('login/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route('/logout', name: 'app_logout')]
    public function logout(): void
    {
        // Ta metoda może pozostać pusta - zostanie przechwycona przez mechanizm wylogowania
        throw new \Exception('Nie zapomnij aktywować wylogowania w security.yaml');
    }
}