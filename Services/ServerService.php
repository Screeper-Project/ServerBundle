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
    const DEFAULT_SERVER_KEY = 'default';

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * Récupération des serveurs
     * @return mixed
     */
    protected function getServersAsArray()
    {
        return $this->container->getParameter(self::SERVERS_PARAMETER_NAME);
    }

    /**
     * @return array
     */
    public function getServersKey()
    {
        return array_keys($this->getServersAsArray());
    }

    /**
     * Retourne les attributs d'un serveur
     * @param $key
     * @return array
     */
    public function getServerAttributes($key)
    {
        return $this->getServer($key)->getAttributes();
    }

    /**
     * @return array
     */
    public function getServersName()
    {
        $keys = array_keys($this->getServersAsArray());
        $servers = array();

        foreach($keys as $key)
            $servers[$key] = $this->getServer($key)->getName();

        return $servers;
    }

    /**
     * @return array
     */
    public function getServers()
    {
        $keys = array_keys($this->getServersAsArray());
        $servers = array();

        foreach($keys as $key)
            $servers[$key] = $this->getServer($key);

        return $servers;
    }

    /**
     * @param $server_key
     * @param array $servers_list
     * @throws \InvalidArgumentException
     */
    protected function checkKey($server_key, $servers_list = array())
    {
        if($servers_list == array())
            $servers_list = $this->getServersAsArray();

        if (!isset($servers_list[$server_key]))
            throw new \InvalidArgumentException('Screeper - ServerBundle - le serveur "'.$server_key.'" ne possède aucune configuration dans app/config/config.yml');
    }

    /**
     * @param string $server_key
     * @return mixed
     * @throws \InvalidArgumentException
     */
    protected function getConfig($server_key = self::DEFAULT_SERVER_KEY) // Récupération de la configuration d'un serveur
    {
        $servers_list = $this->getServersAsArray();

        $this->checkKey($server_key, $servers_list);
        $server_config = $servers_list[$server_key];
        $server_pattern = array();

        if (isset($servers_list[$server_key]['pattern'])) { // Si l'utilisateur à spécifié un pattern
            $pattern = $servers_list[$server_key]['pattern'];

            $this->checkKey($pattern, $servers_list); // On vérifie que la key du pattern existe
            $server_pattern = $this->getConfig($pattern);
        }

        foreach($server_pattern as $key => $value)
            if(!isset($server_config[$key]) && $key != 'attributes') // Les attributs ne se passent pas d'un serveur à un autre
                $server_config[$key] = $server_pattern[$key];

        if (!isset($server_config['login']) || !isset($server_config['password']) || !isset($server_config['ip']))
            throw new \InvalidArgumentException('Screeper - ServerBundle - JsonAPIBundle - le serveur "'.$server_key.'" est mal configuré');

        if(!isset($server_config['port'])) $server_config['port'] = 20059;
        if(!isset($server_config['salt'])) $server_config['salt'] = "";
        if(!isset($server_config['name'])) $server_config['name'] = 'Serveur Minecraft';
        if(!isset($server_config['key'])) $server_config['key'] = $server_key;
        if(!isset($server_config['attributes'])) $server_config['attributes'] = array();

        return $server_config;
    }

    /**
     * @param $server_config
     * @return Server
     */
    protected function convertToServer($server_config)
    {
        // Création de l'objet serveur
        $server = new Server();
        $server->setKey($server_config['key'])
            ->setName($server_config['name'])
            ->setIp($server_config['ip'])
            ->setLogin($server_config['login'])
            ->setPwd($server_config['password'])
            ->setPort($server_config['port'])
            ->setSalt($server_config['salt'])
            ->setAttributes($server_config['attributes']);

        return $server;
    }

    /**
     * @param string $server_key
     * @return Server
     */
    public function getServer($server_key = self::DEFAULT_SERVER_KEY)
    {
        return $this->convertToServer($this->getConfig($server_key));
    }
}