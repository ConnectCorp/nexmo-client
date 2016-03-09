<?php

namespace Nexmo\Service;

use Nexmo\Exception;

abstract class ResourceCollection extends Resource
{
    /**
     * @var Resource[]
     */
    protected $resources = [];

    /**
     * Return the namespace of Service class names
     * @return string
     */
    protected function getNamespace()
    {
        return get_called_class();
    }

    /**
     * @param $class
     *
     * @return \Nexmo\Service\Resource
     */
    protected function initializeClass($class)
    {
        return new $class();
    }

    public function __get($name)
    {
        if (!isset($this->resources[$name])) {
            $clsName = $this->getNamespace() . '\\' . ucfirst($name);
            if (!is_subclass_of($clsName, '\Nexmo\Service\Resource')) {
                throw new Exception("Class $clsName is not a Nexmo Resource");
            }
            $cls = $this->initializeClass($clsName);
            $cls->setClient($this->client);
            $cls->setDefaultQuery($this->getDefaultQuery());

            $this->resources[$name] = $cls;
        }
        return $this->resources[$name];
    }
}
