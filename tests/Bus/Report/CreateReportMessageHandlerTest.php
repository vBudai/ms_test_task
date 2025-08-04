<?php

namespace App\Tests\Bus\Report;

use App\Bus\Notification\ReportResultNotificationMessage;
use App\Bus\Report\CreateReportMessage;
use App\Tests\Story\AppStory;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Messenger\Exception\ExceptionInterface;
use Symfony\Component\Uid\UuidV7;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;
use Zenstruck\Messenger\Test\InteractsWithMessenger;

class CreateReportMessageHandlerTest extends KernelTestCase
{
    use InteractsWithMessenger;
    use ResetDatabase;
    use Factories;

    private string $tempDir;

    protected function setUp(): void
    {
        self::bootKernel();

        $appStory = new AppStory();
        $appStory->build();

        $this->tempDir = self::getContainer()->getParameter('app.reports.dir');
        if (!is_dir($this->tempDir)) {
            mkdir($this->tempDir, 0777, true);
        }
    }

//    protected function tearDown(): void
//    {
//        if (is_dir($this->tempDir)) {
//            array_map('unlink', glob("$this->tempDir/*"));
//            rmdir($this->tempDir);
//        }
//    }

    /**
     * @throws ExceptionInterface
     */
    public function testSuccessFlowWithFileCreation(): void
    {
        /* ARRANGE */
        $reportId = new UuidV7();
        $this->bus()->dispatch(new CreateReportMessage($reportId));


        /* ACT */
        $result = $this->transport('reports')->process();


        /* ASSERT */

        // Transport notifications
        $this->transport('notifications')->queue()->assertCount(1);

        /** @var ReportResultNotificationMessage $messageOrders */
        $message = $this->transport('notifications')->queue()->first(ReportResultNotificationMessage::class)->getMessage();
        $this->assertTrue(UuidV7::isValid($message->reportId));
        $this->assertEquals($reportId, $message->reportId);
        $this->assertEquals('Success', $message->result);
        $this->assertEquals(null, $message->details);

        // File exists
        $expectedPath = "$this->tempDir/$reportId.json";
        $this->assertFileExists($expectedPath);
    }

    /**
     * @throws ExceptionInterface
     */
    public function testReportFileContentIsCorrect(): void
    {
        /* ARRANGE */
        $reportId = new UuidV7();

        $expectedUserId = AppStory::$user->getId()->toString();
        $expectedPath = "$this->tempDir/$reportId.json";
        $expectedProducts = [
            [
                'product_name' => AppStory::$products[0]->getName(),
                'price'        => AppStory::$orderItems[0]->getCost(),
                'amount'       => AppStory::$orderItems[0]->getAmount(),
                'user'         => [ 'id' => $expectedUserId ],
            ],
            [
                'product_name' => AppStory::$products[1]->getName(),
                'price'        => AppStory::$orderItems[1]->getCost(),
                'amount'       => AppStory::$orderItems[1]->getAmount(),
                'user'         => [ 'id' => $expectedUserId ],
            ],
        ];

        /* ACT */
        $this->bus()->dispatch(new CreateReportMessage($reportId));
        $this->transport('reports')->process();


        /* ASSERT */
        $this->assertFileExists($expectedPath);
        $data = json_decode(file_get_contents($expectedPath), true);

        foreach ($expectedProducts as $expectedItem) {
            $found = false;
            foreach ($data as $item) {
                if (
                    $item['product_name'] === $expectedItem['product_name'] &&
                    $item['price']        === $expectedItem['price'] &&
                    $item['amount']       === $expectedItem['amount'] &&
                    $item['user']['id']   === $expectedItem['user']['id']
                ) {
                    $found = true;
                    break;
                }
            }
            $this->assertTrue($found, "Product_name: '{$expectedItem['product_name']}'. Report: $reportId");
        }
    }
}
