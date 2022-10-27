<?php
namespace Envoyr\NginxConfigurator\Collection;

use RuntimeException;
use UnexpectedValueException;

/**
 * Class CustomDistinctCollection
 * @package Envoyr\NginxConfigurator
 * @author Michał Brzuchalski <m.brzuchalski@madkom.pl>
 */
abstract class CustomDistinctCollection extends CustomTypedCollection
{
    /**
     * @return string
     */
    abstract protected function getMethod() : string;

    /**
     * @inheritDoc
     */
    public function add($element) : bool
    {
        if ($this->contains($element)) {
            throw new RuntimeException("Given element already exists in collection");
        }

        return parent::add($element);
    }


    /**
     * @inheritDoc
     */
    public function contains($element) : bool
    {
        if (!$this->isElementValid($element)) {
            throw new UnexpectedValueException(
                "Unexpected element type, expecting: {$this->getType()}, given: " . get_class($element)
            );
        }
        $distinct = $element->{$this->getMethod()}();
        foreach ($this->elements as $current) {
            if ($current->{$this->getMethod()}() == $distinct) {
                return true;
            }
        }

        return false;
    }
}
