<?php

namespace App\Factory;

use App\DTO\Report\ReportRowDto;
use App\DTO\Report\ReportUserDataDto;

class ReportFactory
{
    /**
     * @return ReportRowDto[]
     */
    public function createDtosFromDbRows(array $rows): array
    {
        $result = [];
        foreach ($rows as $row) {
            $result[] = new ReportRowDto(
                $row['product_name'],
                $row['price'],
                $row['amount'],
                new ReportUserDataDto((string) $row['user_id'])
            );
        }

        return $result;
    }
}
