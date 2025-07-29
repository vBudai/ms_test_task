<?php

namespace App\Controller;

use App\DTO\Request\User\RegisterUserRequest;
use App\Exception\User\UserAlreadyExistsException;
use App\Service\Cart\CartService;
use App\Service\User\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;

final class UsersController extends AbstractController
{
    public function __construct(
        private readonly UserService $userService,
        private readonly CartService $cartService,
    ){}

    /**
     * @throws UserAlreadyExistsException
     */
    #[Route('/api/users/register', name: 'api_users_register', methods: ['POST'], format: 'json')]
    public function register(
        #[MapRequestPayload]
        RegisterUserRequest $request,
    ): JsonResponse
    {
        $user = $this->userService->register($request);
        $cart = $this->cartService->createCartForUser($user);

        return $this->json(
            data: [
                'status' => 'success',
                'data'   => [
                    'user' => $user,
                    'cart' => $cart,
                ]
            ],
            context: [
                'groups' => ['public' ]
            ]
        );
    }
}
