<?php

namespace App\Service;

use App\Enum\Status;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

//TODO add transition checker https://refactoring.guru/uk/design-patterns/state/php/example
class StateMachine
{
    public static function validateStatus(mixed $value, ExecutionContextInterface $context): void
    {
        if (!in_array($value, Status::toValues())) {
            $context->buildViolation('Invalid status. Allowed statuses: {{ allowedStatuses }}.')
                ->setParameter('{{ allowedStatuses }}', implode(', ', Status::toValues()))
                ->addViolation();
        }
    }
}