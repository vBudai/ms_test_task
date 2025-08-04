<?php

namespace App\Bus\Notification;

use Symfony\Component\Uid\UuidV7;

class ReportResultNotificationMessage
{
    public function __construct(
        public UuidV7 $reportId,
        public string  $result,
        public ?array  $details = null
    ){}
}
