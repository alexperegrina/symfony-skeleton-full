<?php
declare(strict_types=1);

namespace Core\Domain\Client;

use Psr\Http\Message\ResponseInterface;

interface RestClient
{
    public function get(string $uri, array $options = []): ResponseInterface;
    public function head(string $uri, array $options = []): ResponseInterface;
    public function put(string $uri, array $options = []): ResponseInterface;
    public function post(string $uri, array $options = []): ResponseInterface;
    public function patch(string $uri, array $options = []): ResponseInterface;
    public function delete(string $uri, array $options = []): ResponseInterface;
    public function config(): array;
}