<?php

namespace WeDevBr\Mati\Tests;

use Illuminate\Support\Facades\Config;
use LogicException;
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
        $mati = new Mati();

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
        $mati = new Mati();

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
        $mati = new Mati();

        $mati->setAccessToken('123ABC==');

        $propertyValue = $this->makeReflectionProperty('access_token')
            ->getValue($mati);

        $this->assertEquals('123ABC==', $propertyValue);
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
        $mock = $this->getMockBuilder(Mati::class)
            ->onlyMethods(['requestAccessToken'])
            ->disableOriginalConstructor()
            ->getMock();
        $mock->expects($this->once())
            ->method('requestAccessToken')
            ->willReturn(['access_token' => '123ABC==']);

        $mock->setClientId('123');
        $mock->setClientSecret('shhh');
        $mock->authorize();

        $client_id = $this->makeReflectionProperty('client_id')->getValue($mock);
        $client_secret = $this->makeReflectionProperty('client_secret')->getValue($mock);
        $access_token = $this->makeReflectionProperty('access_token')->getValue($mock);

        $this->assertEquals('123', $client_id);
        $this->assertEquals('shhh', $client_secret);
        $this->assertEquals('123ABC==', $access_token);
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
        $mati = new Mati();

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
        $mati = new Mati();
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
        $mati = new Mati();
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
        $mock = $this->getMockBuilder(Mati::class)
            ->onlyMethods(['requestAccessToken'])
            ->disableOriginalConstructor()
            ->getMock();
        $mock->expects($this->once())
            ->method('requestAccessToken')
            ->willReturn(['access_token' => '123ABC==']);

        $mock->authorize('123', 'shhh');

        $client_id = $this->makeReflectionProperty('client_id')->getValue($mock);
        $client_secret = $this->makeReflectionProperty('client_secret')->getValue($mock);
        $access_token = $this->makeReflectionProperty('access_token')->getValue($mock);

        $this->assertEquals('123', $client_id);
        $this->assertEquals('shhh', $client_secret);
        $this->assertEquals('123ABC==', $access_token);
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

        $mati = new Mati();
        $reflectedMethod->invoke($mati, null);
        $propertyValue = $this->makeReflectionProperty('client_id')->getValue($mati);
        $this->assertNull($propertyValue);

        $mati = new Mati();
        Config::set('mati.client_id', '123');
        $reflectedMethod->invoke($mati, null);
        $propertyValue = $this->makeReflectionProperty('client_id')->getValue($mati);
        $this->assertEquals('123', $propertyValue);

        $mati = new Mati();
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

        $mati = new Mati();
        $reflectedMethod->invoke($mati, null);
        $propertyValue = $this->makeReflectionProperty('client_secret')->getValue($mati);
        $this->assertNull($propertyValue);

        $mati = new Mati();
        Config::set('mati.client_secret', 'shhh');
        $reflectedMethod->invoke($mati, null);
        $propertyValue = $this->makeReflectionProperty('client_secret')->getValue($mati);
        $this->assertEquals('shhh', $propertyValue);

        $mati = new Mati();
        $reflectedMethod->invoke($mati, 'dontTell');
        $propertyValue = $this->makeReflectionProperty('client_secret')->getValue($mati);
        $this->assertEquals('dontTell', $propertyValue);
    }
}
