<?php

namespace App\Controller;

use App\Bus\Report\CreateReportMessage;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Messenger\Exception\ExceptionInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

final class ReportsController extends AbstractController
{
    public function __construct(
        private readonly MessageBusInterface $messageBus,
    ) {
    }

    /**
     * @throws ExceptionInterface
     */
    #[Route('/api/reports/file', name: 'api_reports_file', methods: ['POST'], format: 'json')]
    public function reportToFile(): JsonResponse
    {
        $message = new CreateReportMessage();
        $this->messageBus->dispatch($message);

        return $this->json(['reportId' => $message->id]);
    }
}
