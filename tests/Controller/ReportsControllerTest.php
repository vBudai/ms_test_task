<?php

namespace App\Tests\Controller;

use App\Bus\Notification\ReportResultNotificationMessage;
use App\Bus\Report\CreateReportMessage;
use App\Entity\User;
use App\Service\Report\ReporterInterface;
use App\Tests\ApiAuthTrait;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Transport\InMemory\InMemoryTransport;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Uid\UuidV7;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;
use Zenstruck\Messenger\Test\InteractsWithMessenger;

class ReportsControllerTest extends WebTestCase
{
    use ResetDatabase;
    use Factories;
    use InteractsWithMessenger;
    use ApiAuthTrait;

    private readonly KernelBrowser $client;

    protected function setUp(): void
    {
        $this->client = self::createClient();
        $this->authApi($this->client);
    }

    public function testReportToFileSuccess(): void
    {
        $this->client->request(
            'POST',
            '/api/reports/file',
            [],
            [],
            [
                'CONTENT_TYPE' => 'application/json',
                'HTTP_ACCEPT' => 'application/json',
            ]
        );


        $response = $this->client->getResponse();

        // Response asserts
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertJson($response->getContent());

        $responseData = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('reportId', $responseData);

        $reportId = $responseData['reportId'];
        $this->assertTrue(UuidV7::isValid($reportId));

        // Reports transport
        $this->transport('reports')->queue()->assertCount(1);

        /** @var CreateReportMessage $messageOrders */
        $messageOrders = $this->transport('reports')->queue()->first(CreateReportMessage::class)->getMessage();
        $this->assertTrue(UuidV7::isValid($messageOrders->id));
        $this->assertEquals($reportId, $messageOrders->id);
    }
}
