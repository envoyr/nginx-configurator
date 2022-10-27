<?php
namespace spec\Envoyr\NginxConfigurator;

use Envoyr\NginxConfigurator\Config\Location;
use Envoyr\NginxConfigurator\Config\Server;
use Envoyr\NginxConfigurator\Factory;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class FactorySpec
 * @package spec\Envoyr\NginxConfigurator
 * @author Michał Brzuchalski <m.brzuchalski@madkom.pl>
 * @mixin Factory
 */
class FactorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Factory::class);
    }

    function it_can_create_Server_node()
    {
        $this->createServer(80)->shouldReturnAnInstanceOf(Server::class);
    }

    function it_can_create_Location_node()
    {
        $this->createLocation('/test', '~')->shouldReturnAnInstanceOf(Location::class);
    }
}
