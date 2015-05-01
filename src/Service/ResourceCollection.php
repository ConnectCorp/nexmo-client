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
     * @var string
     */
    private $namespace;

    abstract protected function getNamespaceSuffix();

    /**
     * Return the namespace of Service class names
     * @return string
     */
    protected function getNamespace()
    {
        $parts = explode('\\', get_called_class(), -1);
        $parts[] = $this->getNamespaceSuffix();
        return '\\' . implode('\\', $parts);
    }

    public function __get($name)
    {
        if (!isset($this->resources[$name])) {
            if (!$this->namespace) {
                $this->namespace = $this->getNamespace();
            }
            $clsName = $this->namespace . '\\' . ucfirst($name);
            $cls = new $clsName();
            if (!$cls instanceof Resource) {
                throw new Exception("Class $clsName is not a Nexmo Resource");
            }
            $cls->setClient($this->client);
            $this->resources[$name] = $cls;
        }
        return $this->resources[$name];
    }
}
