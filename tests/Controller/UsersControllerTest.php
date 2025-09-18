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
        /* ARRANGE */
        $client = static::createClient();
        $user = [
            'name' => 'Test',
            'email' => 'testuser@gmail.com',
            'phone' => '+7(999)123-45-67',
            'password' => '12345678',
        ];

        /* ACT */
        $client->request(
            method: 'POST',
            uri: self::REGISTER_URI,
            server: ['CONTENT_TYPE' => 'application/json'],
            content: json_encode($user)
        );
        $response = json_decode($client->getResponse()->getContent(), true);

        /* ASSERT */
        $this->assertResponseIsSuccessful();
        $this->assertResponseFormatSame('json');

        $this->arrayHasKey('id');
        $this->assertEquals($user['name'], $response['name']);
        $this->assertEquals($user['email'], $response['email']);
        $this->assertEquals($user['phone'], $response['phone']);
    }

    public function testRegisterUserValidationError(): void
    {
        /* ARRANGE */
        $client = static::createClient();
        $user = [
            'name' => 'Test',
            'email' => 'testuserexample.com',
            'phone' => '79991234567',
            'password' => '12345678',
        ];

        /* ACT */
        $client->request(
            method: 'POST',
            uri: self::REGISTER_URI,
            server: ['CONTENT_TYPE' => 'application/json'],
            content: json_encode($user)
        );

        /* ASSERT */
        $this->assertResponseIsUnprocessable();
    }
}
