<?php

use Envoyr\NginxConfigurator\Builder;
use Envoyr\NginxConfigurator\Config\Location;
use Envoyr\NginxConfigurator\Factory;
use Envoyr\NginxConfigurator\Node\Directive;
use Envoyr\NginxConfigurator\Node\Literal;
use Envoyr\NginxConfigurator\Node\Param;

require __DIR__ . '/../vendor/autoload.php';

$uuid = 'uuid';

$factory = new Factory();
$builder = new Builder();
$builder->append(new Directive('proxy_cache_path', [new Param("/data/nginx/cache/{$uuid}"), new Param("keys_zone={$uuid}:10m")]));

$server = $builder->append($factory->createServer(80));
$server->append(new Directive('error_log', [new Param("/data/nginx/log/{$uuid}.log"), new Param('debug')]));
$server->append(new Directive('proxy_cache', [new Param($uuid)]));
$server->append(new Location(new Param('/'), null, [
    new Directive('error_page', [new Param('401')]),
    new Directive('host', [new Param('example.com')]),
    new Directive('proxy_pass', [new Param('https://example.com')]),
]));
$server->append(new Location(new Param('/.well-known/acme-challenge'), new Param('^~'), [
    new Directive('proxy_pass', [new Param('https://le.cdn.gd')])
]));

print($builder->dump());