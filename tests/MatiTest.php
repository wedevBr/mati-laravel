<?php

namespace WeDevBr\Mati\Tests;

use Illuminate\Support\Facades\Config;
use LogicException;
use WeDevBr\Mati\MatiHttpClient;
use Orchestra\Testbench\TestCase;
use ReflectionClass;
use WeDevBr\Mati\Mati;
use WeDevBr\Mati\MatiServiceProvider;

/**
 * Tests for Mati class
 *
 * @author Gabriel Mineiro <gabrielpfgmineiro@gmail.com>
 */
class MatiTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [MatiServiceProvider::class];
    }

    /**
     * Construct a ReflectionMethod for the given method name
     *
     * @param string $method Method name
     * @param boolean $accessible
     * @return \ReflectionMethod
     */
    protected function makeReflectionMethod(string $method, bool $accessible = true)
    {
        $reflectedClass = new ReflectionClass(Mati::class);
        $reflectedMethod = $reflectedClass->getMethod($method);
        $reflectedMethod->setAccessible($accessible);
        return $reflectedMethod;
    }

    /**
     * Construct a ReflectionProperty for the given property name
     *
     * @param string $property Property name
     * @param boolean $accessible
     * @return \ReflectionProperty
     */
    protected function makeReflectionProperty(string $property, bool $accessible = true)
    {
        $reflectedClass = new ReflectionClass(Mati::class);
        $reflectedProperty = $reflectedClass->getProperty($property);
        $reflectedProperty->setAccessible($accessible);
        return $reflectedProperty;
    }

    protected function makeMati($client_id = null, $client_secret = null)
    {
        return new Mati(new MatiHttpClient, $client_id, $client_secret);
    }

    /**
     * Test setClientId method
     *
     * It should store the param in $client_id
     *
     * @test
     * @return void
     */
    public function testSetClientId()
    {
        $mati = $this->makeMati();

        $mati->setClientId('123456');

        $propertyValue = $this->makeReflectionProperty('client_id')
            ->getValue($mati);

        $this->assertEquals('123456', $propertyValue);
    }

    /**
     * Test setClientSecret method
     *
     * It should store the param in $client_secret
     *
     * @test
     * @return void
     */
    public function testSetClientSecret()
    {
        $mati = $this->makeMati();

        $mati->setClientSecret('shhh');

        $propertyValue = $this->makeReflectionProperty('client_secret')
            ->getValue($mati);

        $this->assertEquals('shhh', $propertyValue);
    }

    /**
     * Test setAccessToken method
     *
     * It should store the param in $access_token
     *
     * @test
     * @return void
     */
    public function testSetAccessToken()
    {
        $clientMock = $this->getMockBuilder(MatiHttpClient::class)
            ->disableOriginalConstructor()
            ->getMock();
        $clientMock->expects($this->once())
            ->method('withToken')
            ->with('123ABC==')
            ->willReturnSelf();

        $mati = new Mati($clientMock);

        $mati->setAccessToken('123ABC==');
    }

    /**
     * Test authorize method without params
     *
     * Execute correct usage of method and expects success
     *
     * @test
     * @return void
     */
    public function testAuthorizeWithoutParamsSuccess()
    {
        $clientMock = $this->getMockBuilder(MatiHttpClient::class)
            ->disableOriginalConstructor()
            ->getMock();
        $clientMock->expects($this->once())
            ->method('getAccessToken')
            ->with('123', 'shhh')
            ->willReturn((object) ['object' => function () {
                return (object) ['access_token' => '123ABC=='];
            }]);

        $mati = new Mati($clientMock);
        $mati->setClientId('123');
        $mati->setClientSecret('shhh');
        $mati->authorize();
    }

    /**
     * Test authorize method without params
     *
     * Execute incorrect usage of method and expects exception
     *
     * @test
     * @return void
     */
    public function testAuthorizeWithoutParamsFailsWithoutClientIdAndClientSecret()
    {
        $mati = $this->makeMati();

        $this->expectException(LogicException::class);
        $mati->authorize();
    }

    /**
     * Test authorize method without params
     *
     * Execute incorrect usage of method and expects exception
     *
     * @test
     * @return void
     */
    public function testAuthorizeWithoutParamsFailsWithoutClientId()
    {
        $mati = $this->makeMati();
        $mati->setClientSecret('123ABC==');

        $this->expectException(LogicException::class);
        $mati->authorize();
    }

    /**
     * Test authorize method without params
     *
     * Execute incorrect usage of method and expects exception
     *
     * @test
     * @return void
     */
    public function testAuthorizeWithoutParamsFailsWithoutClientSecret()
    {
        $mati = $this->makeMati();
        $mati->setClientId('123');

        $this->expectException(LogicException::class);
        $mati->authorize();
    }

    /**
     * Test authorize method with params
     *
     * Execute correct usage of method and expects success
     *
     * @test
     * @return void
     */
    public function testAuthorizeWithParams()
    {
        $clientMock = $this->getMockBuilder(MatiHttpClient::class)
            ->disableOriginalConstructor()
            ->getMock();
        $clientMock->expects($this->once())
            ->method('getAccessToken')
            ->with('123', 'shhh')
            ->willReturn((object) ['object' => function () {
                return (object) ['access_token' => '123ABC=='];
            }]);

        $mati = new Mati($clientMock);
        $mati->authorize('123', 'shhh');

        $client_id = $this->makeReflectionProperty('client_id')->getValue($mati);
        $client_secret = $this->makeReflectionProperty('client_secret')->getValue($mati);

        $this->assertEquals('123', $client_id);
        $this->assertEquals('shhh', $client_secret);
    }

    /**
     * Test authorise method
     *
     * It should call authorize method
     *
     * @test
     * @return void
     */
    public function testAuthorise()
    {
        $mock = $this->getMockBuilder(Mati::class)
            ->onlyMethods(['authorize'])
            ->disableOriginalConstructor()
            ->getMock();
        $mock->expects($this->once())
            ->method('authorize')
            ->with('123', 'shhh')
            ->willReturnSelf();

        $this->assertInstanceOf(Mati::class, $mock->authorise('123', 'shhh'));
    }

    /**
     * Test resolveClientId method
     *
     * It should get a value for $client_id from the param or config
     *
     * @test
     * @return void
     */
    public function testResolveClientId()
    {
        $reflectedMethod = $this->makeReflectionMethod('resolveClientId');

        $mati = $this->makeMati();
        $reflectedMethod->invoke($mati, null);
        $propertyValue = $this->makeReflectionProperty('client_id')->getValue($mati);
        $this->assertNull($propertyValue);

        $mati = $this->makeMati();
        Config::set('mati.client_id', '123');
        $reflectedMethod->invoke($mati, null);
        $propertyValue = $this->makeReflectionProperty('client_id')->getValue($mati);
        $this->assertEquals('123', $propertyValue);

        $mati = $this->makeMati();
        $reflectedMethod->invoke($mati, '987');
        $propertyValue = $this->makeReflectionProperty('client_id')->getValue($mati);
        $this->assertEquals('987', $propertyValue);
    }

    /**
     * Test resolveClientSecret method
     *
     * It should get a value for $client_secret from the param or config
     *
     * @test
     * @return void
     */
    public function testResolveClientSecret()
    {
        $reflectedMethod = $this->makeReflectionMethod('resolveClientSecret');

        $mati = $this->makeMati();
        $reflectedMethod->invoke($mati, null);
        $propertyValue = $this->makeReflectionProperty('client_secret')->getValue($mati);
        $this->assertNull($propertyValue);

        $mati = $this->makeMati();
        Config::set('mati.client_secret', 'shhh');
        $reflectedMethod->invoke($mati, null);
        $propertyValue = $this->makeReflectionProperty('client_secret')->getValue($mati);
        $this->assertEquals('shhh', $propertyValue);

        $mati = $this->makeMati();
        $reflectedMethod->invoke($mati, 'dontTell');
        $propertyValue = $this->makeReflectionProperty('client_secret')->getValue($mati);
        $this->assertEquals('dontTell', $propertyValue);
    }

    public function testCreateIdentity() {
        $clientMock = $this->getMockBuilder(MatiHttpClient::class)
            ->disableOriginalConstructor()
            ->getMock();
        $clientMock->expects($this->exactly(2))
            ->method('createIdentity')
            ->withConsecutive(
                [null, null, null],
                [['id' => 'ebc645e'], 'abcdef12345', '200.251.85.74']
            )
            ->willReturn((object) ['object' => function () {
                return (object) [];
            }]);

        $mati = new Mati($clientMock);
        $mati->setAccessToken('123321');
        $mati->createIdentity();
        $mati->createIdentity(['id' => 'ebc645e'], 'abcdef12345', '200.251.85.74');
    }
}
