<?php

namespace App\Controller;

use App\Bus\Report\ReportCreatedMessage;
use App\Service\Report\ReporterInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

final class ReportsController extends AbstractController
{
    public function __construct(
        private readonly MessageBusInterface $messageBus,
    ){}

    #[Route('/api/reports/file', name: 'api_reports_file', methods: ['POST'], format: 'json')]
    public function reportToFile(
        #[Autowire(service: 'App\Service\Report\FileReporter')]
        ReporterInterface $reporter
    ): JsonResponse
    {
        try{
            $fileId = $reporter->report();
            $message = new ReportCreatedMessage($fileId, 'success');
            $response = ['status' => 'success', 'data' => $fileId];
        } catch (\Exception $e) {
            $message = new ReportCreatedMessage(null, 'fail', ['error' => $e->getMessage()]);
            $response = ['status' => 'fail', 'details' => ['error' => $e->getMessage()]];
        }

        $this->messageBus->dispatch($message);
        return $this->json($response);
    }
}
