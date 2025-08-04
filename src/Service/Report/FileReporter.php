<?php

namespace App\Service\Report;

use App\Factory\ReportFactory;
use App\Repository\OrderItemRepository;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Uid\UuidV7;

readonly class FileReporter implements ReporterInterface
{
    private string $filePath;

    public function __construct(
        private OrderItemRepository $repo,
        private ReportFactory       $factory,
        ParameterBagInterface       $parameters,
    ){
        $this->filePath = $parameters->get('app.reports.dir');
        if (!is_dir($this->filePath)) {
            mkdir($this->filePath, 0775, true);
        }
    }

    public function report(UuidV7 $reportId): string
    {
        $rows    = $this->repo->getOrderItemsWithUserInfo();
        $reports = $this->factory->createDtosFromDbRows($rows);

        $path =  "$this->filePath/$reportId.json";
        file_put_contents($path, json_encode($reports, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        return $path;
    }
}
