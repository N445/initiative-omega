<?php

namespace App\Validator\RRule;

use InvalidArgumentException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class RRuleValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if (!$value instanceof \App\Entity\Event\RRule) {
            return;
        }

        try {
            $value->getRRuleObject();
        } catch (InvalidArgumentException $exception) {
            $this->context->buildViolation($exception->getMessage())
                          ->addViolation()
            ;
        }
    }
}
