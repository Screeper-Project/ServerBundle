Graille-Labs - Screeper Project - Server bundle
=====================
**DEVELOPMENT IN PROGRESS**

![Screeper logo](http://img4.hostingpics.net/pics/743708Sanstitre7.png)

The Server bundle add support of Minecraft Server in symfony 2.

Installation
------------
Add :

```
"graille-labs/screeper-server-bundle": "dev-master"
```

in your composer.json

Configuration
------------
In the app/config/config.yml :

```
screeper_server:
    servers:
		## Your servers
```

You can add many servers :

```
screeper_server:
    servers:
        default: ## The "default" server is required
            login: #username
            password: #password
            port: #port
            ip: #ip
        serv1:
            login: #username
            password: #password
            port: #port
            ip: #ip
```

N.B : Port and Salt are optionnal, the port by default is 20059

If you need to copy a server, you can create a pattern :

```
screeper_server:
    servers:
        default: ## The "default" server is required
            pattern: serv1 ## Default server is "serv1"
        serv1:
            login: #username
            password: #password
            port: #port
            ip: #ip
```

You can erase the configuration of a pattern :
```
screeper_server:
    servers:
        default: ## The "default" server is required
            pattern: serv1 ## Default server is "serv1"
        serv1:
            login: #username
            password: #password
            port: #port
            ip: #ip
            salt: ~ ## If a salt is necessary
        serv2:
            pattern: serv1
            ip: #new_ip
```
(In this example, the informations are the same, but the ip isn't.)

Usage
------------

For use, you must call the service :

```
$api = $this->container->get('screeper.server.services.servers')->getServer("servername");
```

This command return a "Server" object.
If "servername" is empty, the default server will be used.