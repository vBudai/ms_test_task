<?php

namespace App\Service\Report;

use Symfony\Component\Uid\UuidV7;

interface ReporterInterface
{
    public function report(UuidV7 $reportId): string;
}
