<?php
/**
 * Created by PhpStorm.
 * User: mbrzuchalski
 * Date: 08.04.16
 * Time: 20:57
 */
namespace Envoyr\NginxConfigurator\Config;

use Envoyr\NginxConfigurator\Node\Context;
use Envoyr\NginxConfigurator\Node\Directive;

/**
 * Class Http
 * @package Envoyr\NginxConfigurator\Config
 * @author Michał Brzuchalski <m.brzuchalski@madkom.pl>
 */
class Http extends Context
{
    /**
     * Http constructor.
     * @param Directive[] $directives
     */
    public function __construct(array $directives = [])
    {
        parent::__construct('http', $directives);
    }
}
