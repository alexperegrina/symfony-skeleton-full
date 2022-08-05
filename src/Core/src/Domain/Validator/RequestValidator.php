<?php
declare(strict_types=1);

namespace Core\Domain\Validator;

use Symfony\Component\HttpFoundation\Request;

abstract class RequestValidator
{
    private array $content = [];
    private ?Request $request = null;

    public function content(): array
    {
        return $this->content;
    }

    public function request(): ?Request
    {
        return $this->request;
    }

    protected function setContent(Request $request, array $content): void
    {
        $this->content = $content;

        $this->request = new Request(
            $request->query->all(),
            $request->request->all(),
            $request->attributes->all(),
            $request->cookies->all(),
            $request->files->all(),
            $request->server->all(),
            json_encode($content)
        );
    }

    abstract public function validate(Request $request): void;
}