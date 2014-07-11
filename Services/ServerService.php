<?php

namespace Screeper\ServerBundle\Services;

/**
 * @author Graille
 * @version 1.0.0
 * @link http://github.com/Graille
 * @package SERVERBUNDLE
 * @since 1.0.0
 */

use Screeper\ServerBundle\Entity\Server;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ServerService
{
    protected $container;

    // Constantes
    const SERVERS_PARAMETER_NAME = 'screeper.server.parameters.servers';
    const DEFAULT_SERVER_NAME = 'default';

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    // Récupération des serveurs
    protected function getServers()
    {
        return $this->container->getParameter(JsonApiService::SERVERS_PARAMETER_NAME);
    }

    protected function checkConfig($server, $servers_list)
    {
        if (!isset($servers_list[$server]))
            throw new \InvalidArgumentException('Screeper - ServerBundle - le serveur "'.$server.'" ne possède aucune configuration dans app/config/config.yml');
    }

    protected function getConfig($server_name) // Récupération de la configuration d'un serveur
    {
        $servers_list = $this->getServers();

        $this->checkConfig($server_name, $servers_list);

        $server_config = $servers_list[$server_name];

        if (!isset($server_config['login']) or !isset($server_config['password']) or !isset($server_config['ip']))
            if (isset($server_config['pattern'])) { // Si c'est un pattern
                $this->checkConfig($server_config['pattern'], $servers_list);
                $config = $this->getConfig($server_config['pattern']);

                foreach($server_config as $key => $sub_config) // On écrase les configurations copié par celles de l'utilisateur
                    $config[$key] = $server_config;

                $server_config = $config; // Enfin on renvoi la nouvelle config
            }
            else
                throw new \InvalidArgumentException('Screeper - ServerBundle - JsonAPIBundle - le serveur "'.$server_name.'" est mal configuré');
        else {
            if(!isset($server_config['port']))
                $server_config['port'] = 20059;
            if(!isset($server_config['salt']))
                $server_config['salt'] = "";
        }

        // Création de l'objet serveur
        $server = new Server();
        $server->setConfigIp($server_config['ip'])
            ->setConfigLogin($server_config['login'])
            ->setConfigPassword($server_config['password'])
            ->setConfigPort($server_config['port'])
            ->setConfigSalt($server_config['salt']);

        return $server;
    }

    public function getServer($server_name)
    {
        return $this->getConfig($server_name);
    }
}