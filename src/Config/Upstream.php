<?php
/**
 * Created by PhpStorm.
 * User: mbrzuchalski
 * Date: 08.04.16
 * Time: 21:07
 */
namespace Envoyr\NginxConfigurator\Config;

use Envoyr\NginxConfigurator\Node\Context;
use Envoyr\NginxConfigurator\Node\Directive;
use Envoyr\NginxConfigurator\Node\Param;

/**
 * Class Upstream
 * @package Envoyr\NginxConfigurator\Config
 * @author Michał Brzuchalski <m.brzuchalski@madkom.pl>
 */
class Upstream extends Context
{
    /**
     * Holds upstream name
     * @var Param
     */
    private $upstream;

    /**
     * Upstream constructor.
     * @param Param $upstream
     * @param Directive[] $directives
     */
    public function __construct(Param $upstream, array $directives = [])
    {
        $this->upstream = $upstream;
        parent::__construct('upstream', $directives);
    }

    public function getName() : string
    {
        return (string)$this->upstream->getValue();
    }

    public function __toString() : string
    {
        return sprintf(
            "{$this->name} %s {\n\t%s\n}\n",
            $this->upstream,
            implode("\n\t", (array)$this->childNodes->getIterator())
        );
    }
}
