<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ClassroomValidationService
{
    /** @var ValidatorInterface $validator */
    private $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public function onCreate(Request $request): ?ConstraintViolationListInterface
    {
        $name = $request->get('name');
        $violations = $this->validator->validate($name, [
            new Length(['max' => 100]),
            new NotBlank(),
        ]);

        if ($violations->count()) {
            return $violations;
        }

        return null;
    }

    public function onUpdate(Request $request): ?ConstraintViolationListInterface
    {
        return $this->onCreate($request);
    }

    public function onActivate(Request $request): ?ConstraintViolationListInterface
    {
        $violations = $this->validator->validate($request->get('active'), [
            new NotNull(),
        ]);

        if ($violations->count()) {
            return $violations;
        }

        return null;
    }
}
