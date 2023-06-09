<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use ZxcvbnPhp\Zxcvbn;

class PasswordValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        /* @var Password $constraint */

        if (null === $value || '' === $value) {
            return;
        }

        $weak = (new Zxcvbn())->passwordStrength($value);

        if($weak['score'] > 1){
            return;
        }

        // TODO: implement the validation here
        $this->context->buildViolation($constraint->message)
            ->setParameter('{{ value }}', $value)
            ->addViolation();
    }
}
