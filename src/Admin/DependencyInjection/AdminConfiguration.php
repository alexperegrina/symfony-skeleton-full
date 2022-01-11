<?php
declare(strict_types=1);

namespace Admin\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class AdminConfiguration implements ConfigurationInterface
{
    const ALIAS = 'admin';

    public function getConfigTreeBuilder(): TreeBuilder
    {
        return new TreeBuilder(self::ALIAS);
    }
}