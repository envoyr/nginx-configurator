NGINX Configurator
==================

PHP Library for NGINX configuration parser/generator

![PHP 8.1](https://img.shields.io/badge/PHP-8.1-8C9CB6.svg?style=flat)

---

## Features

This library can parse and generate NGINX configuration files.
In near future will provide CLI commands for NGINX configuration.


## Installation

Install with Composer

```
composer require envoyr/nginx-configurator
```

## Requirements

This library requires *PHP* in `>=8.1` version.

## Usage

Parsing configuration string:

```php
use Envoyr\NginxConfigurator\Builder;
use Envoyr\NginxConfigurator\Config\Server;
use Envoyr\NginxConfigurator\Parser;

require 'vendor/autoload.php';

$config = <<<CONFIG
server {
    listen 8080;
    root /data/www/web;
    index index.php index.html index.htm;

    location / {
        try_files $uri $uri/ /index.php;
    }

    error_page 404 /404.html;

    error_page 500 502 503 504 /50x.html;
    location = /50x.html {
        root /usr/share/nginx/www;
    }

    # pass the PHP scripts to FastCGI server listening on the php-fpm socket
    location ~ \.php$ {
        try_files $uri =404;
        fastcgi_pass unix:/var/run/php5-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
CONFIG;

$parser = new Parser();
$defaultConfig = $parser->parse($config);
/** @var Server $defaultServers[] */
$defaultServers = $defaultConfig->search(function (Node $node) {
    return $node instanceof Server;
});


$builder = new Builder();
if (count($defaultServers) > 0) {
    /** @var Server $defaultServer */
    foreach ($defaultServers as $defaultServer) {
        $builder->append($defaultServer);
    }
}
```

Generating configuration string:

```php
use Envoyr\NginxConfigurator\Factory;
use Envoyr\NginxConfigurator\Builder;
use Envoyr\NginxConfigurator\Config\Location;
use Envoyr\NginxConfigurator\Node\Directive;
use Envoyr\NginxConfigurator\Node\Literal;
use Envoyr\NginxConfigurator\Node\Param;

require __DIR__ . '/../vendor/autoload.php';

$factory = new Factory()
$builder = new Builder();

$server = $builder->append($factory->createServer(80));
$server->append(new Directive('error_log', [
    new Param('/var/log/nginx/error.log'), 
    new Param('debug'),
]));
$server->append(new Location(new Param('/test'), null, [
    new Directive('error_page', [new Param('401'), new Param('@unauthorized')]),
    new Directive('set', [new Param('$auth_user'), new Literal('none')]),
    new Directive('auth_request', [new Param('/auth')]),
    new Directive('proxy_pass', [new Param('http://test-service')]),
]));
$server->append(new Location(new Param('/auth'), null, [
    new Directive('proxy_pass', [new Param('http://auth-service:9999')]),
    new Directive('proxy_bind', [new Param('$server_addr')]),
    new Directive('proxy_redirect', [new Param('http://$host'), new Param('https://$host')]),
    new Directive('proxy_set_header', [new Param('Content-Length'), new Literal("")]),
    new Directive('proxy_pass_request_body', [new Param('off')]),
]));
$server->append(new Location(new Param('@unauthorized'), null, [
    new Directive('return', [new Param('302'), new Param('/login?backurl=$request_uri')]),
]));
$server->append(new Location(new Param('/login'), null, [
    new Directive('expires', [new Param('-1')]),
    new Directive('proxy_pass', [new Param('http://identity-provider-service')]),
    new Directive('proxy_bind', [new Param('$server_addr')]),
    new Directive('proxy_redirect', [new Param('http://$host'), new Param('https://$host')]),
    new Directive('proxy_set_header', [new Param('Content-Length'), new Literal("")]),
    new Directive('proxy_pass_request_body', [new Param('off')]),
]));

print($builder->dump());
```

Generated configuration output:

```
server {
        listen 80;
        listen [::]:80 default ipv6only=on;
        error_log /var/log/nginx/error.log debug;
        location  /test {
                error_page 401 @unauthorized;
                set $auth_user "none";
                auth_request /auth;
                proxy_pass http://test-service;
        }
        
        location  /auth {
                proxy_pass http://auth-service:9999;
                proxy_bind $server_addr;
                proxy_redirect http://$host https://$host;
                proxy_set_header Content-Length "";
                proxy_pass_request_body off;
        }
        
        location  @unauthorized {
                return 302 /login?backurl=$request_uri;
        }
        
        location  /login {
                expires -1;
                proxy_pass http://identity-provider-service;
                proxy_bind $server_addr;
                proxy_redirect http://$host https://$host;
                proxy_set_header Content-Length "";
                proxy_pass_request_body off;
        }
        
}
```

There are also methods to read and dump file:

```php
use Envoyr\NginxConfigurator\Builder;
use Envoyr\NginxConfigurator\Config\Location;
use Envoyr\NginxConfigurator\Config\Server;
use Envoyr\NginxConfigurator\Node\Directive;
use Envoyr\NginxConfigurator\Node\Literal;
use Envoyr\NginxConfigurator\Parser;

require __DIR__ . '/../vendor/autoload.php';

$parser = new Parser();
$builder = new Builder();

$configuration = $parser->parseFile('default.conf');

/** @var Server $servers[] */
$servers = $configuration->search(function (Node $node) {
    return $node instanceof Server;
});
if (count($servers) > 0) {
    /** @var Server $server */
    foreach ($servers as $server) {
        $builder->append($server);
    }
}

$builder->dumpFile('generated.conf');
```

## TODO

* [ ] Implement comments parsing
* [ ] Implement commands for config manipulation from CLI

## License

The MIT License (MIT)

Copyright (c) 2016 Madkom S.A.
Copyright (c) 2022 envoyr <hello@envoyr.com>

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.