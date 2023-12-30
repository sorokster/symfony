<?php declare(strict_types=1);

namespace App\Controller;

use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/profile')]
class UserController extends AbstractController
{
    /**
     * @param UserService $service
     * @return Response
     */
    #[Route('/', name: 'profile', methods: ['GET'])]
    public function profile(UserService $service): Response
    {
        $user = $service->getUserByEmail($this->getUser()->getUserIdentifier());

        return $this->render('user/profile.html.twig', [
            'user' => $user,
        ]);
    }
}
