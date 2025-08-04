<?php

namespace App\Bus\Report;

use App\Bus\Notification\ReportResultNotificationMessage;
use App\Service\Report\FileReporter;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\Exception\ExceptionInterface;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsMessageHandler]
readonly class CreateReportMessageHandler
{
    public function __construct(
        private FileReporter        $fileReporter,
        private MessageBusInterface $messageBus,
    ){}

    /**
     * @throws ExceptionInterface
     */
    public function __invoke(CreateReportMessage $message): void
    {
        try{
            $this->fileReporter->report($message->id);
            $result = new ReportResultNotificationMessage($message->id, 'Success');
        } catch (\Throwable $e) {
            $result = new ReportResultNotificationMessage($message->id, 'fail', ['error' => (string)$e]);
        }

        $this->messageBus->dispatch($result);
    }
}
