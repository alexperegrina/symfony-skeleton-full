<?php
declare(strict_types=1);

namespace Core\Interfaces\Controller\RequestValidator;

use Core\Domain\Validator\RequestValidator;
use Core\Domain\Validator\SchemaValidator;
use Symfony\Component\HttpFoundation\Request;

class ApiArgumentsRequestValidator extends RequestValidator
{
    public function __construct(private SchemaValidator $validator)
    {}

    public function validate(Request $request): void
    {
        $data = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);

        // validate and add default value
        $data = $this->validator->validate(
            $data,
            '@CoreBundle/Resources/schema/Interfaces/Controller/ApiController/arguments.json'
        );

        // add force value
        $data = array_merge($data, ["test" => "aaa"]);

        $this->setContent($request, $data);
    }
}