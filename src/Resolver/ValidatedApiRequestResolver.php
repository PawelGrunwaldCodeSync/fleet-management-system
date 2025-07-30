<?php

declare(strict_types=1);

namespace App\Resolver;

use App\Exception\Request\InvalidArgumentTypeException;
use App\Request\Contracts\RequestInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ValidatedApiRequestResolver implements ValueResolverInterface
{
    public function __construct(
        private SerializerInterface $serializer,
        private ValidatorInterface $validator,
    ) {
    }

    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        $type = $argument->getType();

        return null !== $type && str_starts_with($type, 'App\\Request\\');
    }

    /**
     * @return iterable<RequestInterface>
     */
    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        if (!str_starts_with($request->getPathInfo(), '/api/')) {
            return false;
        }

        if (null === $argument->getType()) {
            throw InvalidArgumentTypeException::fromNull();
        }

        $dto = $this->serializer->deserialize($request->getContent(), $argument->getType(), 'json');
        $errors = $this->validator->validate($dto);

        if (count($errors) > 0) {
            throw new ValidationFailedException($dto, $errors);
        }

        yield $dto;
    }
}
