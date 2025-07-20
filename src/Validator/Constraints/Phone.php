<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)]
final class Phone extends Constraint
{
    public string $message = 'Телефон должен быть в формате +7(XXX)XXX-XX-XX';
}
