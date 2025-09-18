<?php

namespace App\Validator\Constraints;

use App\Repository\CartItemRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class CartItemExistsValidator extends ConstraintValidator
{
    public function __construct(
        private readonly CartItemRepository $repo,
    ) {
    }

    /**
     * @var mixed
     * @var CartItemExists
     */
    public function validate(mixed $value, Constraint $constraint)
    {
        if (null === $value || '' === $value) {
            return;
        }

        if (!$this->repo->find($value)) {
            $this->context
                ->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}
