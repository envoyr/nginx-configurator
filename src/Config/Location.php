<?php
/**
 * Created by PhpStorm.
 * User: mbrzuchalski
 * Date: 08.04.16
 * Time: 21:01
 */
namespace Envoyr\NginxConfigurator\Config;

use Envoyr\NginxConfigurator\Node\Context;
use Envoyr\NginxConfigurator\Node\Literal;
use Envoyr\NginxConfigurator\Node\Param;

/**
 * Class Location
 * @package Envoyr\NginxConfigurator\Config
 * @author Michał Brzuchalski <m.brzuchalski@madkom.pl>
 */
class Location extends Context
{
    /**
     * Holds location match
     * @var Param
     */
    private $location;

    /**
     * Holds location match modifier
     * @var Param
     */
    private $match;

    /**
     * Location constructor.
     * @param Param $location
     * @param Param $match
     * @param array $directives
     */
    public function __construct(Param $location, Param $match = null, array $directives = [])
    {
        $this->location = $location;
        $this->match = $match;
        parent::__construct('location', $directives);
    }

    public function __toString() : string
    {
        return sprintf(
            "{$this->name} %s %s {\n\t%s\n}\n",
            $this->match,
            $this->location,
            implode("\n\t", (array)$this->childNodes->getIterator())
        );
    }

    /**
     * @return Param
     */
    public function getLocation() : string
    {
        return (string)$this->location;
    }

    /**
     * @return Param
     */
    public function getMatch() : string
    {
        return (string)$this->match;
    }
}
