<?php
namespace Envoyr\NginxConfigurator;

use Envoyr\NginxConfigurator\Config\Location;
use Envoyr\NginxConfigurator\Config\Server;
use Envoyr\NginxConfigurator\Node\Directive;
use Envoyr\NginxConfigurator\Node\Param;

/**
 * Class Factory
 * @package Envoyr\NginxConfigurator
 * @author Michał Brzuchalski <m.brzuchalski@madkom.pl>
 */
class Factory
{
    /**
     * Creates Server node
     * @param int $port
     * @return Server
     */
    public function createServer(int $port = 80) : Server
    {
        $listenIPv4 = new Directive('listen', [new Param($port)]);
        $listenIPv6 = new Directive('listen', [new Param("[::]:{$port}")]);

        return new Server([$listenIPv4, $listenIPv6]);
    }

    /**
     * Creates Location node
     * @param string $location
     * @param string|null $match
     * @return Location
     */
    public function createLocation(string $location, string $match = null) : Location
    {
        return new Location(new Param($location), is_null($match) ? null : new Param($match));
    }
}
