<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

final class PhoneValidator extends ConstraintValidator
{
    private const REGEX = '/^\+7\(\d{3}\)\d{3}-\d{2}-\d{2}$/';

    /**
     * @param Phone $constraint
     */
    public function validate(mixed $value, Constraint $constraint): void
    {
        if (null === $value || '' === $value) {
            return;
        }

        if (!preg_match(self::REGEX, $value)) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}
