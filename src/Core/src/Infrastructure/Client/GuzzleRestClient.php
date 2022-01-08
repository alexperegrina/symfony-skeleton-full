<?php
declare(strict_types=1);

namespace Core\Infrastructure\Client;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;
use Core\Domain\Client\RestClient;

class GuzzleRestClient implements RestClient
{
    private array $configClient;
    private ?Client $client;

    private function __construct(private array $config)
    {
        $this->client = null;
        $this->initOptions();
        $this->initClient();
    }

    public static function make(array $config): self
    {
        return new self($config);
    }

    protected function initOptions(): void
    {
        $this->configClient['base_uri'] = $this->config['base_uri'];

        foreach ($this->config as $key => $value) {
            switch ($key) {
                case 'accept':
                    $this->configClient['accept'] = $value;
                    break;
                case 'cert':
                    $this->configClient['cert'] = $value;
                    break;
                case 'ssl_key':
                    $this->configClient['ssl_key'] = $value;
                    break;
                case 'verify':
                    $this->configClient['verify'] = $value;
                    break;
                case 'user':
                    $this->configClient['auth'][0] = $value;
                    break;
                case 'password':
                    $this->configClient['auth'][1] = $value;
                    break;
                case 'headers':
                    foreach ($value as $keyHeader => $valueHeader) {
                        switch ($keyHeader) {
                            case 'content_type':
                                $this->configClient['headers']['content-type'] = $valueHeader;
                                break;
                            case 'params':
                                foreach ($valueHeader as $keyParam => $valueParam) {
                                    $this->configClient['headers'][$keyParam]= $valueParam;
                                }
                                break;
                        }
                    }
                    break;
            }
        }
    }

    protected function initClient(): void
    {
        if (is_null($this->client)) {
            $this->client = new Client($this->configClient);
        }
    }

    public function get(string $uri, array $options = []): ResponseInterface
    {
        return $this->client->get($uri, $options);
    }

    public function head(string $uri, array $options = []): ResponseInterface
    {
        return $this->client->head($uri, $options);
    }

    public function put(string $uri, array $options = []): ResponseInterface
    {
        return $this->client->put($uri, $options);
    }

    public function post(string $uri, array $options = []): ResponseInterface
    {
        return $this->client->post($uri, $options);
    }

    public function patch(string $uri, array $options = []): ResponseInterface
    {
        return $this->client->patch($uri, $options);
    }

    public function delete(string $uri, array $options = []): ResponseInterface
    {
        return $this->client->delete($uri, $options);
    }

    public function config(): array
    {
        return $this->config;
    }
}