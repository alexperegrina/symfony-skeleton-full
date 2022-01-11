<?php
declare(strict_types=1);

namespace Landing;

use Landing\DependencyInjection\LandingExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class LandingBundle extends Bundle
{
    protected function getContainerExtensionClass(): string
    {
        return LandingExtension::class;
    }
}