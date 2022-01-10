<?php
declare(strict_types=1);

namespace Core\Interfaces\Controller;

use AlexPeregrina\Response\Interfaces\Rest\RestResponse;
use AlexPeregrina\Response\Interfaces\Rest\RestResponseCollection;
use Core\Domain\Messenger\Bus\CommandBus;
use Core\Domain\Messenger\Bus\QueryBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

abstract class ApiRestController extends AbstractController
{
    public function __construct(
        protected CommandBus $commandBus,
        protected QueryBus $queryBus,
        protected SerializerInterface $serializer
    ) {}

    protected function buildResponseForGetRestOk(RestResponse|RestResponseCollection $restResponse): JsonResponse
    {
        return new JsonResponse(
            $this->serializer->serialize($restResponse, 'json'),
            Response::HTTP_OK,
            [],
            true
        );
    }

    protected function buildResponseForGetRestKO(): JsonResponse
    {
        return new JsonResponse(
            '{"status":"ko"}',
            Response::HTTP_NOT_FOUND,
            [],
            true
        );
    }

    protected function buildResponseForPostRestOk(int $code = Response::HTTP_CREATED): JsonResponse
    {
        return new JsonResponse(
            null,
            $code,
            [],
            false
        );
    }

    protected function buildResponseForPostRestKO(string $message): JsonResponse
    {
        $data = [
            'status' => 'ko',
            'error' => [
                'message' => $message
            ]
        ];
        return new JsonResponse(
            $this->serializer->serialize($data, 'json'),
            Response::HTTP_BAD_REQUEST,
            [],
            true
        );
    }

    protected function buildResponseForDeleteRestOk(int $code = Response::HTTP_NO_CONTENT): JsonResponse
    {
        return new JsonResponse(
            null,
            $code,
            [],
            false
        );
    }
}