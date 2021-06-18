<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;

// use Symfony\Component\HttpFoundation\Session\Session;

// use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class SessionController extends AbstractController
{

    /**
     * @Route("/session", name="session")
    */
    public function showSession(SessionInterface $session): Response
    {

        // $session->set('token', 'a6c1e0b6');

        return $this->render('session.html.twig', [
            'session' => $session,
        ]);
    }

    /**
     * @Route("/session/destroy")
    */
    public function destroySession(SessionInterface $session): RedirectResponse
    {
        // $session = new Session();
        // $session->start();
        $session->clear();
        // $session->set('tesst', 'test123');

        return $this->redirectToRoute('session');
    }
}
