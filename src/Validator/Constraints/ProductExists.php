<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

#[\Attribute] class ProductExists extends Constraint
{
    public string $message = 'Продукта с ID "{{ value }}" не существует';
}
