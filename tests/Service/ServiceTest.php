<?php

class ServiceTest extends PHPUnit_Framework_TestCase
{

    public function testInvoke()
    {
        $client = $this->getMockBuilder('\GuzzleHttp\Client')->disableOriginalConstructor()->getMock();

        $response = $this->getMockBuilder('\GuzzleHttp\Message\Response')->disableOriginalConstructor()->getMock();

        $body = [
            'status' => 1,
            'error_text' => 'Error'
        ];

        $response->method('getBody')->willReturn(json_encode($body));

        $params = [
            'param1' => 'value1',
            'param2' => 'value2',
            'param3' => 'value3'
        ];

        $client->expects($this->once())->method('get')->with(
            'path',
            [
                'query' => $params
            ]
        )->willReturn($response);


        $service = $this->getMockBuilder('ServiceMock')->setMethods(['validateResponse'])->setConstructorArgs([
            $client
        ])->getMock();

        $service->expects($this->once())->method('validateResponse')->with($body);

        $this->assertEquals($body, $service->testExec($params));
    }

    public function testInvokeJsonException()
    {
        $client = $this->getMockBuilder('\GuzzleHttp\Client')->disableOriginalConstructor()->getMock();

        $response = $this->getMockBuilder('\GuzzleHttp\Message\Response')->disableOriginalConstructor()->getMock();

        $body = 'nonjsonstring';

        $response->method('getBody')->willReturn($body);

        $client->method('get')->willReturn($response);

        $service = $this->getMockBuilder('ServiceMock')->setMethods(['validateResponse'])->setConstructorArgs([
            $client
        ])->getMock();

        $this->setExpectedException('\Nexmo\Exception', 'Unable to parse JSON');

        $service->testExec([]);
    }

    public function testCallable()
    {
        $client = $this->getMockBuilder('\GuzzleHttp\Client')->disableOriginalConstructor()->getMock();

        $service = $this->getMockBuilder('ServiceMock')->setMethods(['invoke'])->setConstructorArgs([
            $client
        ])->getMock();

        $params = 'a';

        $service->expects($this->once())->method('invoke')->with($params);

        $service($params);
    }


    public function testConstructor()
    {
        $client = $this->getMockBuilder('\GuzzleHttp\Client')->disableOriginalConstructor()->getMock();

        $service = $this->getMockBuilder('ServiceMock')->setMethods(['invoke'])->setConstructorArgs([
            $client
        ])->getMock();

        $this->assertEquals($service->getClient(), $client);
    }
}

class ServiceMock extends \Nexmo\Service\Service
{
    /**
     * @return string
     */
    public function getEndpoint()
    {
        return 'path';
    }

    public function getClient()
    {
        return $this->client;
    }

    public function testExec(array $params)
    {
        return $this->exec($params);
    }

    /**
     * @return mixed
     */
    public function invoke()
    {
        // TODO: Implement invoke() method.
    }

    /**
     * @param array $json
     * @return bool
     */
    protected function validateResponse(array $json)
    {
        // TODO: Implement validateResponse() method.
    }
}
 