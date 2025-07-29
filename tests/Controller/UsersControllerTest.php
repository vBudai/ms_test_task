<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Zenstruck\Foundry\Test\ResetDatabase;

class UsersControllerTest extends WebTestCase
{
    use ResetDatabase;

    private const REGISTER_URI = '/api/users/register';

    public function testRegisterUserSuccess(): void
    {
        $client = static::createClient();

        $user = [
            'name'     => 'Test',
            'email'    => 'testuser@gmail.com',
            'phone'    => '+7(999)123-45-67',
            'password' => '12345678',
        ];

        $client->request(
            method: 'POST',
            uri: self::REGISTER_URI,
            server: ['CONTENT_TYPE' => 'application/json'],
            content: json_encode($user)
        );

        $this->assertResponseIsSuccessful();
        $this->assertResponseFormatSame('json');

        $response = json_decode($client->getResponse()->getContent(), true);

        $this->assertEquals('success', $response['status']);

        $this->assertArrayHasKey('data', $response);
        $this->assertArrayHasKey('user', $response['data']);
        $this->assertArrayHasKey('cart', $response['data']);

        $this->assertEquals($user['email'], $response['data']['user']['email']);
    }

    public function testRegisterUserValidationError(): void
    {
        $client = static::createClient();

        $user = [
            'name'     => 'Test',
            'email'    => 'testuserexample.com',
            'phone'    => '79991234567',
            'password' => '12345678',
        ];

        $client->request(
            method: 'POST',
            uri: self::REGISTER_URI,
            server: ['CONTENT_TYPE' => 'application/json'],
            content: json_encode($user)
        );

        $this->assertResponseIsUnprocessable();
    }
}
