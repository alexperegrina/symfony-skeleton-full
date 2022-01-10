<?php
declare(strict_types=1);

namespace Core\Interfaces\Controller;

use AlexPeregrina\Response\Interfaces\DataTransformer\RestResponseDataTransformer;
use AlexPeregrina\Response\Interfaces\Rest\RestResponse;
use AlexPeregrina\ValueObject\Domain\Geography\Country;
use AlexPeregrina\ValueObject\Domain\Geography\CountryCode;
use AlexPeregrina\ValueObject\Domain\String\StringVO;
use AlexPeregrina\ValueObject\Interfaces\Response\Dto\CountryDtoResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends ApiRestController
{
    /**
     * @Route("/test", name="core_api_get_test", methods={"GET"})
     * @return JsonResponse
     */
    public function test(): JsonResponse
    {
        $country = new Country(
            new StringVO('España'),
            CountryCode::byName(CountryCode::ES)
        );

        return $this->buildResponseForGetRestOk(RestResponseDataTransformer::toRestResponse(CountryDtoResponse::make($country)));
    }
}