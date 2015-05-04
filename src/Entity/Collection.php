<?php

namespace Nexmo\Entity;

use ArrayAccess;
use ArrayIterator;
use Countable;
use IteratorAggregate;

class Collection implements ArrayAccess, Countable, IteratorAggregate
{
    protected $data = [];

    public function __construct($data)
    {
        if ($data instanceof Collection) {
            $data = $data->all();
        }
        $this->data = $data;
    }

    /**
     * @param string $key
     * @return mixed|null
     */
    public function get($key)
    {
        return isset($this->data[$key]) ? $this->data[$key] : null;
    }

    /**
     * @param string        $key
     * @param callable|null $callback
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

    public function has($key)
    {
        return array_key_exists($key, $this->data);
    }

    public function all()
    {
        return $this->data;
    }

    public function offsetExists($offset)
    {
        return $this->has($offset);
    }

    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    public function offsetSet($offset, $value)
    {
    }

    public function offsetUnset($offset)
    {
    }

    public function getIterator()
    {
        return new ArrayIterator($this->data);
    }

    public function count()
    {
        return count($this->data);
    }

    public function __call($name, $arguments)
    {
        $this->get($name);
    }
}
