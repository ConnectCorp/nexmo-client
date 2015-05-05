<?php
namespace Nexmo\Tests\Service;

trait ResourceCollectionMockTrait
{
    protected $generator;

    public function __construct()
    {
        $this->generator = new \PHPUnit_Framework_MockObject_Generator;
    }

    public function getNamespace()
    {
        return get_parent_class();
    }

    protected function initializeClass($class)
    {
        return $this->generator->getMock($class);
    }

    public function isResourceInitialized($resource)
    {
        return isset($this->resources[$resource]);
    }
}
