<?php
/**
 * Created by PhpStorm.
 * User: mbrzuchalski
 * Date: 08.04.16
 * Time: 21:00
 */
namespace Envoyr\NginxConfigurator\Config;

use Envoyr\NginxConfigurator\Node\Context;

/**
 * Class Server
 * @package Envoyr\NginxConfigurator\Config
 * @author Michał Brzuchalski <m.brzuchalski@madkom.pl>
 */
class Server extends Context
{
    /**
     * Server constructor.
     * @param array $directives
     */
    public function __construct(array $directives = [])
    {
        parent::__construct('server', $directives);
    }
}
