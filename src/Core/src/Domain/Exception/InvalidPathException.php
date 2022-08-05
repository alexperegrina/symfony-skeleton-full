<?php
declare(strict_types=1);

namespace Core\Domain\Exception;

use Exception;

class InvalidPathException extends Exception
{
    public function __construct(private string $path)
    {
        parent::__construct();
    }

    public function path(): string
    {
        return $this->path;
    }

    protected function errorMessage(): string
    {
        return json_encode($this->getMessageArray(), JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
    }

    public function getMessageArray(): array
    {
        return [
            'message' => 'Invalid path',
            'path' => $this->path,
        ];
    }
}