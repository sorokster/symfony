<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WelcomeController extends AbstractController
{
    #[Route('/welcome')]
    public function index(): Response
    {
        return $this->render('welcome/index.html.twig');
    }

    #[Route('/welcome/{name}')]
    public function welcomeUser(string $name): Response
    {
        return $this->render('welcome/user.html.twig', [
            'name' => $name,
        ]);
    }
}
