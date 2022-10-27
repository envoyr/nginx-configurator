<?php
namespace Envoyr\NginxConfigurator\Collection;

use RuntimeException;
use UnexpectedValueException;

/**
 * Class ComparableTypedCollection
 * @package Envoyr\NginxConfigurator
 * @author Michał Brzuchalski <m.brzuchalski@madkom.pl>
 */
abstract class ComparableDistinctTypedCollection extends CustomTypedCollection
{
    /**
     * Checks two elements are equal
     * @param $left
     * @param $right
     * @return bool
     */
    abstract public function compareTo($left, $right) : bool;

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
        foreach ($this->elements as $current) {
            if ($this->compareTo($current, $element)) {
                return true;
            }
        }

        return false;
    }
}
