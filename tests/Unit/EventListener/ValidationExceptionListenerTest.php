<?php

declare(strict_types=1);

namespace Unit\EventListener;

use App\EventListener\ValidationExceptionListener;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Exception\ValidationFailedException;

class ValidationExceptionListenerTest extends TestCase
{
    private HttpKernelInterface&MockObject $kernel;
    private Request $request;
    private ValidationExceptionListener $listener;

    protected function setUp(): void
    {
        $this->kernel = $this->createMock(HttpKernelInterface::class);
        $this->request = new Request();
        $this->listener = new ValidationExceptionListener();
    }

    public function testDoesNothingForNonValidationException(): void
    {
        $event = new ExceptionEvent(
            $this->kernel,
            $this->request,
            HttpKernelInterface::MAIN_REQUEST,
            new \RuntimeException('Exception')
        );

        $this->listener->onKernelException($event);

        $this->assertNull($event->getResponse(), 'Empty response');
    }

    public function testSetJsonResponseForValidationException(): void
    {
        $violation = new ConstraintViolation(
            message: 'This value should not be blank.',
            messageTemplate: '',
            parameters: [],
            root: null,
            propertyPath: 'name',
            invalidValue: null
        );

        $violations = new ConstraintViolationList([$violation]);
        $exception = new ValidationFailedException(new \stdClass(), $violations);

        $event = new ExceptionEvent(
            $this->kernel,
            $this->request,
            HttpKernelInterface::MAIN_REQUEST,
            $exception
        );

        $this->listener->onKernelException($event);

        $response = $event->getResponse();

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(Response::HTTP_UNPROCESSABLE_ENTITY, $response->getStatusCode());

        $this->assertIsString($response->getContent());

        $data = json_decode($response->getContent(), true);

        $this->assertArrayHasKey('errors', $data);
        $this->assertCount(1, $data['errors']);
        $this->assertEquals('name', $data['errors'][0]['property']);
        $this->assertEquals('This value should not be blank.', $data['errors'][0]['message']);
    }
}
