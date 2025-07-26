<?php

namespace App\Service\User;

use App\DTO\Request\User\RegisterUserRequest;
use App\Entity\User;
use App\Exception\User\UserAlreadyExistsException;
use App\Factory\UserFactory;
use App\Repository\UserRepository;

readonly class UserService implements UserServiceInterface
{
    public function __construct(
        private UserRepository $repo,
        private UserFactory    $factory,
    ){}

    /**
     * @throws UserAlreadyExistsException
     */
    public function register(RegisterUserRequest $request): User
    {
        if($this->repo->isExistsByEmailOrPhone($request->email, $request->phone)){
            throw new UserAlreadyExistsException();
        }

        $user = $this->factory->fromRegisterRequest($request);
        $this->repo->add($user, true);

        return $user;
    }
}
