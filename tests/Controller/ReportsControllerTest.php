<?php

namespace App\Tests\Controller;

use App\Bus\Report\ReportCreatedMessage;
use App\Service\Report\ReporterInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Uid\UuidV7;
use Zenstruck\Foundry\Test\ResetDatabase;

class ReportsControllerTest extends WebTestCase
{
    protected function setUp(): void
    {
        // TODO: добавить наполнение БД
    }

    public function testReportToFileSuccess(): void
    {
        $client = static::createClient();

        $fileId = new UuidV7();

        $mockReporter = $this->createMock(ReporterInterface::class);
        $mockReporter->method('report')->willReturn($fileId);

        static::getContainer()->set('App\Service\Report\FileReporter', $mockReporter);

        $client->request('POST', '/api/reports/file');

        $this->assertResponseIsSuccessful();
        $response = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals('success', $response['status']);

        $transport = static::getContainer()->get('messenger.transport.async');
        $this->assertCount(1, $transport->getSent());

        $message = $transport->getSent()[0]->getMessage();
        $this->assertInstanceOf(ReportCreatedMessage::class, $message);
        $this->assertEquals($fileId, $message->getId());
    }
}
