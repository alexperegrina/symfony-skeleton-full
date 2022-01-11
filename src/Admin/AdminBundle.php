<?php
declare(strict_types=1);

namespace Admin;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Admin\DependencyInjection\AdminExtension;

class AdminBundle extends Bundle
{
    protected function getContainerExtensionClass(): string
    {
        return AdminExtension::class;
    }
}