<?php
namespace Nexmo\Entity;

class NumberCollection extends Collection
{
    /**
     * The total numbers associated with the account.
     * Not the numbers in this collection.
     *
     * @return int
     */
    public function count()
    {
        return $this->get('count');
    }

    /**
     * A list of numbers
     *
     * @return Number[]
     */
    public function numbers()
    {
        return $this->getArray('numbers', function ($number) {
            return new Number($number);
        });
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->numbers());
    }
}
