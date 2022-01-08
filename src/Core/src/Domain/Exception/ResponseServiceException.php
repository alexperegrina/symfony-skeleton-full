<?php
declare(strict_types=1);

namespace Core\Domain\Exception;

use Exception;

class ResponseServiceException extends Exception
{
    public function __construct(private string $codeError, private string $messageError)
    {
        parent::__construct($this->errorMessage());
    }

    public function codeError(): string
    {
        return $this->codeError;
    }

    public function messageError(): string
    {
        return $this->messageError;
    }

    protected function errorMessage(): string
    {
        $values = ['code' => $this->codeError, 'message' => $this->messageError];
        return json_encode($values);
    }
}