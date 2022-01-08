<?php
declare(strict_types=1);

namespace Core\Infrastructure\Transformer;

use Psr\Http\Message\ResponseInterface;

class ResponseInterfaceTransformer
{
    public static function transformToArray(ResponseInterface $response): array
    {
        $contentString = $response->getBody()->getContents();

        if ($contentString === '') {
            return [];
        }

        libxml_use_internal_errors(true);

        $responseXml = simplexml_load_string($contentString);

        if($responseXml === false) {
            $responseArray = json_decode($contentString, true);
        } else {
            $responseArray = json_decode(json_encode($responseXml), true);
        }

        return $responseArray;
    }
}