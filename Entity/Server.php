<?php
namespace Screeper\ServerBundle\Entity;

class Server
{
    protected $name = '';

    protected $config_login = '';

    protected $config_password = '';

    protected $config_ip = '';

    protected $config_salt = '';

    protected $config_port = '';

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function getConfigLogin()
    {
        return $this->config_login;
    }

    public function setConfigLogin($config_login)
    {
        $this->config_login = $config_login;

        return $this;
    }

    public function getConfigPassword()
    {
        return $this->config_password;
    }

    public function setConfigPassword($config_password)
    {
        $this->config_password = $config_password;

        return $this;
    }

    public function getConfigIp()
    {
        return $this->config_ip;
    }

    public function setConfigIp($config_ip)
    {
        $this->config_ip = $config_ip;

        return $this;
    }

    public function getConfigSalt()
    {
        return $this->config_salt;
    }

    public function setConfigSalt($config_salt)
    {
        $this->config_salt = $config_salt;

        return $this;
    }

    public function getConfigPort()
    {
        return $this->config_port;
    }

    public function setConfigPort($config_port)
    {
        $this->config_port = $config_port;

        return $this;
    }
}
