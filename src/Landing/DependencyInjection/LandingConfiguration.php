<?php
declare(strict_types=1);

namespace Landing\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class LandingConfiguration implements ConfigurationInterface
{
    const ALIAS = 'landing';

    public function getConfigTreeBuilder(): TreeBuilder
    {
        return new TreeBuilder(self::ALIAS);
    }
}