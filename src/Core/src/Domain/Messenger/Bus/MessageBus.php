<?php
declare(strict_types=1);

namespace Core\Domain\Messenger\Bus;

interface MessageBus
{
    public function messages(): array;
}