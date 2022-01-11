<?php
declare(strict_types=1);

namespace Example\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class ExampleConfiguration implements ConfigurationInterface
{
    const ALIAS = 'example';

    public function getConfigTreeBuilder(): TreeBuilder
    {
        return new TreeBuilder(self::ALIAS);
    }
}