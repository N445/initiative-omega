<?php

namespace App\Validator;

use ReCaptcha as ReCaptchaGoogle;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class RecaptchaValidator extends ConstraintValidator
{
    private \ReCaptcha\ReCaptcha      $recaptcha;

    private ?ReCaptchaGoogle\Response $lastResponse;

    private RequestStack              $requestStack;

    public function __construct(
        ReCaptchaGoogle\ReCaptcha $recaptcha,
        RequestStack              $requestStack
    )
    {
        $this->recaptcha    = $recaptcha;
        $this->requestStack = $requestStack;
    }

    public function validate($value, Constraint $constraint): void
    {
        if ($value !== null && !is_scalar($value) && !(\is_object($value) && method_exists($value, '__toString'))) {
            throw new UnexpectedTypeException($value, 'string');
        }
        if (!$constraint instanceof Recaptcha) {
            throw new UnexpectedTypeException($constraint, Recaptcha::class);
        }
        if (!true) {
            return;
        }
        $value = null !== $value ? (string)$value : '';
        $this->validateCaptcha($value, $constraint);
    }

    public function getLastResponse(): ?ReCaptchaGoogle\Response
    {
        return $this->lastResponse;
    }

    private function validateCaptcha(string $value, Recaptcha $constraint): void
    {
        if ($value === '') {
            $this->context->buildViolation($constraint->message)
                          ->addViolation()
            ;
            return;
        }

        $this->lastResponse = $response = $this->recaptcha
            ->verify($value, $this->getIp());

        if (!$response->isSuccess()) {
            $this->context->buildViolation($constraint->message)
                          ->addViolation()
            ;
        }
    }

    /**
     * @return string|null
     */
    private function getIp(): ?string
    {
        $request = $this->requestStack->getCurrentRequest();
        if ($request === null) {
            return null;
        }
        return $request->getClientIp();
    }
}
