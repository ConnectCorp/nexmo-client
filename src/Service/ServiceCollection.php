<?php

namespace Nexmo\Service;

use GuzzleHttp\Client;

abstract class ServiceCollection
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @var Service[]
     */
    protected $services = [];

    /**
     * @var string
     */
    private $namespace;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

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
        if (!isset($this->services[$name])) {
            if (!$this->namespace) {
                $this->namespace = $this->getNamespace();
            }
            $cls = $this->namespace . '\\' . ucfirst($name);
            $this->services[$name] = new $cls($this->client);
        }
        return $this->services[$name];
    }
}
