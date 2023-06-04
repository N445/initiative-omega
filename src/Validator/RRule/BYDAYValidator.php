<?php

namespace App\Validator\RRule;

use RRule\RRule;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use function RRule\not_empty;

class BYDAYValidator extends ConstraintValidator
{
    public function validate($values, Constraint $constraint)
    {
        if (!is_array($values)) {
            $values = explode(',', $values);
        }
        $byweekday     = [];
        $byweekday_nth = [];

        foreach ($values as $value) {
            $value = trim(strtoupper($value));
            $valid = preg_match('/^([+-]?[0-9]+)?([A-Z]{2})$/', $value, $matches);
            if (!$valid || (not_empty($matches[1]) && ($matches[1] == 0 || $matches[1] > 53 || $matches[1] < -53)) || !array_key_exists($matches[2], RRule::WEEKDAYS)) {
                // TODO: implement the validation here
                $this->context->buildViolation('Invalid BYDAY value: ' . $value)
                              ->addViolation()
                ;
                return;
            }

            if ($matches[1]) {
                $byweekday_nth[] = [RRule::WEEKDAYS[$matches[2]], (int)$matches[1]];
            } else {
                $byweekday[] = RRule::WEEKDAYS[$matches[2]];
            }
        }

//        if (!empty($byweekday_nth)) {
//            if (!($this->freq === RRule::MONTHLY || $this->freq === RRule::YEARLY)) {
//                throw new \InvalidArgumentException('The BYDAY rule part MUST NOT be specified with a numeric value when the FREQ rule part is not set to MONTHLY or YEARLY.');
//            }
//            if ($this->freq === RRule::YEARLY && not_empty($parts['BYWEEKNO'])) {
//                throw new \InvalidArgumentException('The BYDAY rule part MUST NOT be specified with a numeric value with the FREQ rule part set to YEARLY when the BYWEEKNO rule part is specified.');
//            }
//        }


    }
}
