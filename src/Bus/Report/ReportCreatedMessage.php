<?php

namespace App\Bus\Report;

use Symfony\Component\Uid\UuidV7;

class ReportCreatedMessage
{
    public function __construct(
        private ?UuidV7 $id,
        private string $result,
        private ?array $details = null
    ){}

    public function getId(): UuidV7
    {
        return $this->id;
    }

    public function getResult(): string
    {
        return $this->result;
    }

    public function getDetails(): ?array
    {
        return $this->details;
    }
}
