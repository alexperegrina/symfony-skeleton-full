<?php
declare(strict_types=1);

namespace Core\Interfaces\Controller;

use AlexPeregrina\Response\Interfaces\DataTransformer\RestResponseDataTransformer;
use AlexPeregrina\ValueObject\Domain\Geography\Country;
use AlexPeregrina\ValueObject\Domain\Geography\CountryCode;
use AlexPeregrina\ValueObject\Domain\String\StringVO;
use AlexPeregrina\ValueObject\Interfaces\Response\Dto\CountryDtoResponse;
use Core\Interfaces\Controller\RequestValidator\ApiArgumentsRequestValidator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends ApiRestController
{
    #[Route('/test', name: 'core_api_get_test', methods: ['GET'])]
    public function test(): JsonResponse
    {
        $country = new Country(
            new StringVO('España'),
            CountryCode::byName(CountryCode::ES)
        );

        return $this->buildResponseForGetRestOk(RestResponseDataTransformer::toRestResponse(CountryDtoResponse::make($country)));
    }

    #[Route('/private', name: 'core_api_private', methods: ['GET'])]
    public function private(): JsonResponse
    {
        $country = new Country(
            new StringVO('España'),
            CountryCode::byName(CountryCode::ES)
        );

        return $this->buildResponseForGetRestOk(RestResponseDataTransformer::toRestResponse(CountryDtoResponse::make($country)));
    }

    #[Route('/arguments', name: 'core_api_arguments', methods: ['POST'])]
    public function arguments(ApiArgumentsRequestValidator $requestValidator, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);
        $data2 = json_decode($requestValidator->request()->getContent(), true, 512, JSON_THROW_ON_ERROR);

        dd($requestValidator->content(), $data2, $data);

        return $this->buildResponseForPostRestOk();
    }

    #[Route('/arguments-2', name: 'core_api_arguments-2', methods: ['POST'])]
    public function arguments2(ApiArgumentsRequestValidator $request): JsonResponse
    {
        $data = json_decode($request->request()->getContent(), true, 512, JSON_THROW_ON_ERROR);

        dd($request->content(), $data);

        return $this->buildResponseForPostRestOk();
    }
}