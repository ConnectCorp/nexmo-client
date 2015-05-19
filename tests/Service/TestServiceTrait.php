<?php

namespace Nexmo\Tests\Service;

trait TestServiceTrait
{
    public $executedParams;

    public function testValidateResponse($params)
    {
        return $this->validateResponse($params);
    }

    protected function exec($params)
    {
        $this->executedParams = $params;
    }
}
