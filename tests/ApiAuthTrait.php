<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Component\HttpFoundation\Response;

trait ApiAuthTrait
{
    private const TEST_USER = [
        'name' => 'Test',
        'email' => 'testuser@gmail.com',
        'phone' => '+7(999)123-45-67',
        'password' => '12345678',
    ];

    private function authApi(KernelBrowser $client): void
    {
        $this->registerUser($client);
        $client->setServerParameter(
            'HTTP_Authorization',
            sprintf('Bearer %s', $this->getJWT($client))
        );
    }

    private function getJWT(KernelBrowser $client): string
    {
        $client->request(
            method: 'POST',
            uri: '/api/login',
            server: ['CONTENT_TYPE' => 'application/json'],
            content: json_encode([
                'username' => self::TEST_USER['email'],
                'password' => self::TEST_USER['password'],
            ])
        );

        $response = json_decode($client->getResponse()->getContent(), true);

        return $response['token'];
    }

    private function registerUser(KernelBrowser $client): Response
    {
        $client->request(
            method: 'POST',
            uri: '/api/users/register',
            server: ['CONTENT_TYPE' => 'application/json'],
            content: json_encode(self::TEST_USER)
        );

        return $client->getResponse();
    }
}
