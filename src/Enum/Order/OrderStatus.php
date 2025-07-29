<?php

namespace App\Enum\Order;

enum OrderStatus: string
{
    case PAID = 'Оплачен';
    case WAITING_ASSEMBLY = 'Ждёт сборки';
    case IN_ASSEMBLY = 'В сборке';
    case READY_FOR_PICKUP = 'Готов к выдаче';
    case IN_DELIVERY = 'Доставляется';
    case RECEIVED = 'Получен';
    case CANCELLED = 'Отменён';

    public static function values(): array
    {
        $cases = self::cases();
        return array_map(fn(self $case) => $case->value, $cases);
    }
}
