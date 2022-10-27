<?php
namespace spec\Envoyr\NginxConfigurator;

use Envoyr\NginxConfigurator\Builder;
use Envoyr\NginxConfigurator\Config\Server;
use Envoyr\NginxConfigurator\Config\Upstream;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class BuilderSpec
 * @package spec\Envoyr\NginxConfigurator
 * @author Michał Brzuchalski <m.brzuchalski@madkom.pl>
 * @mixin Builder
 */
class BuilderSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Builder::class);
    }

    function it_can_build_with_Server_node(Server $server)
    {
        $server->__toString()->willReturn("server {
}");
        $this->append($server);
        $this->dump()->shouldBeString();
    }

    function it_can_build_with_Upstream_node(Upstream $upstream)
    {
        $upstream->__toString()->willReturn("upstream name {
}");
        $this->append($upstream);
        $this->dump()->shouldBeString();
    }
}
