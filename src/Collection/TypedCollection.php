<?php
namespace Envoyr\NginxConfigurator\Collection;

/**
 * Class DistinctCollection
 * @package Envoyr\NginxConfigurator
 * @author Michał Brzuchalski <m.brzuchalski@madkom.pl>
 */
class TypedCollection extends CustomTypedCollection
{
    /**
     * @var string Collection generic type
     */
    protected $type;

    /**
     * GenericCollection constructor.
     * @param string $type
     * @param array $elements
     */
    public function __construct(string $type, array $elements = [])
    {
        $this->type = $type;
        parent::__construct($elements);
    }

    /**
     * @return string
     */
    protected function getType() : string
    {
        return $this->type;
    }
}
