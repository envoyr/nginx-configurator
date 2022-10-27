<?php
namespace Envoyr\NginxConfigurator\Collection;

use InvalidArgumentException;
use RuntimeException;
use UnexpectedValueException;

/**
 * Class DistinctCollection
 * @package Envoyr\NginxConfigurator
 * @author Michał Brzuchalski <m.brzuchalski@madkom.pl>
 */
class DistinctCollection extends CustomDistinctCollection
{
    /**
     * @var string Collection generic type
     */
    protected $type;
    /**
     * @var string Generic type distinguish method name
     */
    private $method;

    /**
     * UniqueGenericCollection constructor.
     * @param string $type
     * @param string $method
     * @param array $elements
     */
    public function __construct(string $type, string $method, array $elements = [])
    {
        if (!method_exists($type, $method) && is_callable($type, $method)) {
            throw new InvalidArgumentException(
                "Non-existent distinct method name in class {$type}, given: {$method}"
            );
        }
        $this->type = $type;
        $this->method = $method;
        parent::__construct($elements);
    }

    /**
     * @return string
     */
    protected function getType() : string
    {
        return $this->type;
    }

    /**
     * @inheritDoc
     */
    protected function getMethod() : string
    {
        return $this->method;
    }
}
