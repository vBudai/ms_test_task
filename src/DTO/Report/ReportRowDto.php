<?php

namespace App\DTO\Report;

class ReportRowDto implements \JsonSerializable
{
    public function __construct(
        public string $productName,
        public int $price,
        public int $amount,
        public ReportUserDataDto $user,
    ){}

    public function jsonSerialize(): array
    {
        return [
            'product_name' => $this->productName,
            'price' => $this->price,
            'amount' => $this->amount,
            'user' => [
                'id' => $this->user->id,
            ]
        ];
    }
}
