<?php

namespace App\Enum\Order;

enum OrderDeliveryType: string
{
    case COURIER = "Курьер";
    case SELFDELIVERY = "Самовывоз";

    public static function values(): array
    {
        $cases = self::cases();
        return array_map(fn(self $case) => $case->value, $cases);
    }
}
