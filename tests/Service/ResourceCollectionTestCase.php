<?php

namespace Nexmo\Tests\Service;

use Nexmo\Service\ResourceCollection;
use Nexmo\Tests\TestCase;

abstract class ResourceCollectionTestCase extends TestCase
{
    /**
     * @var ResourceCollection|ResourceCollectionMockTrait
     */
    private $service;

    /**
     * @return ResourceCollection|ResourceCollectionMockTrait
     */
    abstract protected function createService();

    protected function service()
    {
        if (!$this->service) {
            $this->service = $this->createService();
            $this->service->setClient($this->guzzle());
        }
        return $this->service;
    }

    protected function assertResourceInitialized($resource)
    {
        $this->assertTrue($this->service->isResourceInitialized($resource), $resource . ' has not been initialized');
    }

    public function testInvalidProperty()
    {
        $ns = $this->service()->getNamespace();
        $this->setExpectedException('\Nexmo\Exception', "Class $ns\\Foo is not a Nexmo Resource");
        $this->service()->foo;
    }
}
