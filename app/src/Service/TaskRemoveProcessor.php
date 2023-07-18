<?php

namespace App\Service;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use ApiPlatform\Doctrine\Common\State\RemoveProcessor as DoctrineRemoveProcessor;
use ApiPlatform\Validator\Exception\ValidationException;
use ApiPlatform\Validator\ValidatorInterface;
use App\Entity\Task;

class TaskRemoveProcessor implements ProcessorInterface
{
    public function __construct(
        private readonly DoctrineRemoveProcessor $doctrineProcessor,
        private readonly ValidatorInterface      $validator,
    )
    {
    }

    public function process($data, Operation $operation, array $uriVariables = [], array $context = []): void
    {
        /** @var $data Task */
        $this->validator->validate($data, ['groups' => ['deleteValidation']]);
        if (!$data instanceof Task) {
            return;
        }
        if ($data->getChildren()->count()) {
            throw new ValidationException('Cannot delete Task as it has children tasks.');

        }
        $this->doctrineProcessor->process($data, $operation, $uriVariables, $context);
    }
}