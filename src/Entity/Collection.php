<?php

namespace Nexmo\Entity;

use ArrayAccess;
use ArrayIterator;
use Countable;
use IteratorAggregate;

/**
 * An Immutable key value pair collection
 */
class Collection implements ArrayAccess, Countable, IteratorAggregate
{
    /**
     * @var array
     */
    protected $data;

    /**
     * @param array|Collection $data
     */
    public function __construct($data)
    {
        if ($data instanceof Collection) {
            $data = $data->all();
        }
        $this->data = $data;
    }

    /**
     * Get an item from collection with the given key.
     *
     * @param string $key
     *
     * @return mixed|null
     */
    public function get($key)
    {
        return isset($this->data[$key]) ? $this->data[$key] : null;
    }

    /**
     * Get a list item from collection with given key.
     * If item does not exist an empty array is returned.
     *
     * @param string        $key
     * @param callable|null $callback Optional callable to map items in list
     *
     * @return array
     */
    public function getArray($key, callable $callback = null)
    {
        $list = $this->get($key);
        if (!is_array($list)) {
            return [];
        }
        if (is_callable($callback)) {
            return array_map($callback, $list);
        }
        return $list;
    }

    /**
     * Return whether collection has an item with the given key.
     *
     * @param string $key
     *
     * @return bool
     */
    public function has($key)
    {
        return array_key_exists($key, $this->data);
    }

    /**
     * Return all the items in collection.
     *
     * @return array
     */
    public function all()
    {
        return $this->data;
    }

    /**
     * @inheritdoc
     */
    public function offsetExists($offset)
    {
        return $this->has($offset);
    }

    /**
     * @inheritdoc
     */
    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    /**
     * @inheritdoc
     */
    public function offsetSet($offset, $value)
    {
    }

    /**
     * @inheritdoc
     */
    public function offsetUnset($offset)
    {
    }

    /**
     * @inheritdoc
     */
    public function getIterator()
    {
        return new ArrayIterator($this->data);
    }

    /**
     * @inheritdoc
     */
    public function count()
    {
        return count($this->data);
    }
}
