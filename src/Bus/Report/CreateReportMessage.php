<?php

namespace App\Bus\Report;

use Symfony\Component\Uid\UuidV7;

class CreateReportMessage
{
    public function __construct(
        public UuidV7 $id = new UuidV7(),
    ){}
}
