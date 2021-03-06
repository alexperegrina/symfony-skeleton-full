<?php
declare(strict_types=1);

namespace Core;

use Core\DependencyInjection\CoreExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class CoreBundle extends Bundle
{
    protected function getContainerExtensionClass(): string
    {
        return CoreExtension::class;
    }
}