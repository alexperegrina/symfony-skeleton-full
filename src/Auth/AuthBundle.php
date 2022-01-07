<?php
declare(strict_types=1);

namespace Auth;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Security\DependencyInjection\AuthExtension;

class AuthBundle extends Bundle
{
    protected function getContainerExtensionClass(): string
    {
        return AuthExtension::class;
    }
}