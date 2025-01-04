<?php
/**
 * Created by PhpStorm.
 * User: envoyr
 * Date: 04.01.25
 * Time: 16:29
 */
namespace Envoyr\NginxConfigurator\Config;

use Envoyr\NginxConfigurator\Node\Context;
use Envoyr\NginxConfigurator\Node\Literal;
use Envoyr\NginxConfigurator\Node\Node;
use Envoyr\NginxConfigurator\Node\Param;

/**
 * Class Raw
 * @package Envoyr\NginxConfigurator\Config
 * @author Maurice Preuß <hello@envoyr.com>
 */
class Raw extends Node
{
    /**
     * Holds raw string
     * @var string
     */
    private $raw;

    /**
     * Raw constructor.
     * @param string $raw
     */
    public function __construct(string $raw)
    {
        $this->raw = $raw;
    }

    public function __toString() : string
    {
        return $this->raw;
    }

    /**
     * @return string
     */
    public function getRaw() : string
    {
        return (string)$this->raw;
    }
}
