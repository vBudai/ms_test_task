<?php

namespace App\Controller;

use App\DTO\Request\User\RegisterUserRequest;
use App\Service\Cart\CartServiceInterface;
use App\Service\User\UserServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;

final class UsersController extends AbstractController
{
    public function __construct(
        private readonly UserServiceInterface $userService,
        private readonly CartServiceInterface $cartService,
    ){}

    #[Route('/api/users/register', name: 'api_users_register', methods: ['POST'])]
    public function register(
        #[MapRequestPayload]
        RegisterUserRequest $request
    ): Response
    {
        $user = $this->userService->register($request);
        $this->cartService->createForUser($user);

        return $this->json(['msg' => 'User registered'], Response::HTTP_CREATED);
    }
}
