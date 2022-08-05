<?php
declare(strict_types=1);

namespace Core\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class CoreExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yaml');

        $this->passConfigToParameters($configs, $container);
    }

    private function passConfigToParameters(array $configs, ContainerBuilder $container): void
    {
        $configuration = $this->getConfiguration($configs, $container);
        $config = $this->processConfiguration($configuration, $configs);

        $alias = $this->getAlias().'.validator.schema';
        $container->setParameter($alias, $config['validator']['schema']);
    }

    public function getAlias(): string
    {
        return CoreConfiguration::ALIAS;
    }

    public function getConfiguration(array $config, ContainerBuilder $container)
    {
        return new CoreConfiguration();
    }
}