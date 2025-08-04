<?php

namespace App\Validator\Constraints;

use App\Repository\ProductRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class ProductExistsValidator extends ConstraintValidator
{
    public function __construct(
        private readonly ProductRepository $repo,
    ) {
    }

    /**
     * @param ProductExists $constraint
     */
    public function validate(mixed $value, Constraint $constraint): void
    {
        if (null === $value || '' === $value) {
            return;
        }

        if (!$this->repo->find($value)) {
            $this->context
                ->buildViolation($constraint->message)
                ->setParameter('{{ value }}', (string) $value)
                ->addViolation();
        }
    }
}
