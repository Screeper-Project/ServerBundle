<?php
namespace Screeper\ServerBundle\Entity;

class Server
{
    protected $name = '';

    protected $configLogin = '';

    protected $configPassword = '';

    protected $configIp = '';

    protected $configSalt = '';

    protected $configPort = '';

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
        return $this->configLogin;
    }

    public function setConfigLogin($configLogin)
    {
        $this->configLogin = $configLogin;

        return $this;
    }

    public function getConfigPassword(){
        return $this->configPassword;
    }

    public function setConfigPassword($configPassword)
    {
        $this->configPassword = $configPassword;

        return $this;
    }

    public function getConfigIp()
    {
        return $this->configIp;
    }

    public function setConfigIp($configIp)
    {
        $this->configIp = $configIp;

        return $this;
    }

    public function getConfigSalt()
    {
        return $this->configSalt;
    }

    public function setConfigSalt($configSalt)
    {
        $this->configSalt = $configSalt;

        return $this;
    }

    public function getConfigPort()
    {
        return $this->configPort;
    }

    public function setConfigPort($configPort)
    {
        $this->configPort = $configPort;

        return $this;
    }
}
