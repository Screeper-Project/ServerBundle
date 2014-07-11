<?php

namespace Screeper\JsonApiBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

class GrailleLabsServerExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        // Préparations des configs
        $config = array();
        foreach ($configs as $subConfig)
            $config = array_merge($config, $subConfig);

        // Importation des services
        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        // Gestion de la configuration sémantique
        if (!isset($config['servers']))
            throw new \InvalidArgumentException('Screeper - ServerBundle - Vous devez spécifier des serveurs de jeu dans app/config/config.yml');

        if (!isset($config['servers']['default']))
            throw new \InvalidArgumentException('Screeper - ServerBundle - Vous devez spécifier un serveur par defaut dans app/config/config.yml');

        $container->setParameter('screeper.server.parameters.servers', $config['servers']);
    }
}
