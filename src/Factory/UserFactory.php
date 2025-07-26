<?php

namespace App\Factory;

use App\DTO\Request\User\RegisterUserRequest;
use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<User>
 */
final class UserFactory extends PersistentProxyObjectFactory
{
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher,
    ){
        parent::__construct();
    }

    public static function class(): string
    {
        return User::class;
    }

    protected function defaults(): array|callable
    {
        return [
            'email' => self::faker()->text(64),
            'name' => self::faker()->text(64),
            'password' => self::faker()->text(),
            'phone' => self::faker()->text(16),
        ];
    }

    public function fromRegisterRequest(RegisterUserRequest $request): User
    {
        $user = new User();
        $user
            ->setName($request->name)
            ->setEmail($request->email)
            ->setPhone($request->phone)
            ->setPassword($this->passwordHasher->hashPassword($user, $request->password));

        return $user;
    }
}
