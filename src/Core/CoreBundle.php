<?php
declare(strict_types=1);

namespace Core;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use App\Core\DependencyInjection\CoreExtension;

class CoreBundle extends Bundle
{
    protected function getContainerExtensionClass(): string
    {
        return CoreExtension::class;
    }
}