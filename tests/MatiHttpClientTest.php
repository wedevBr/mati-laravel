<?php

namespace WeDevBr\Mati\Tests;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Orchestra\Testbench\TestCase;
use WeDevBr\Mati\IdentityInput;
use WeDevBr\Mati\MatiHttpClient;
use WeDevBr\Mati\MatiServiceProvider;

/**
 * Tests for MatiHttpClient class
 *
 * @author Gabriel Mineiro <gabrielpfgmineiro@gmail.com>
 */
class MatiHttpClientTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [MatiServiceProvider::class];
    }

    /**
     * Test sendInput method
     *
     * Should send inputs for a verification process as multipart and have correct
     * data on the fields
     *
     * @test
     * @return void
     */
    public function testSendInput()
    {
        $client = new MatiHttpClient('123ABC==');

        // Mock input1
        $input1 = $this->getMockBuilder(IdentityInput::class)
            ->onlyMethods(['getFileContents'])
            ->setConstructorArgs(['document-photo'])
            ->getMock();

        // Mock getFileContents behaviour
        $input1->expects($this->once())
            ->method('getFileContents')
            ->willReturn('EXIF1');

        // Set input data
        $input1->setGroup(0)
            ->setType('identity')
            ->setCountry('BR')
            ->setPage('front')
            ->setFilePath('/tmp/0001.jpg');

        // Do the same for input2
        $input2 = $this->getMockBuilder(IdentityInput::class)
            ->onlyMethods(['getFileContents'])
            ->setConstructorArgs(['document-photo'])
            ->getMock();
        $input2->expects($this->once())
            ->method('getFileContents')
            ->willReturn('EXIF2');
        $input2->setGroup(0)
            ->setType('identity')
            ->setCountry('BR')
            ->setPage('back')
            ->setFilePath('/tmp/0002.jpg');

        $payload = collect([
            $input1,
            $input2
        ]);

        Http::fake();

        $client->sendInput('1230', $payload);

        Http::assertSent(function ($request) {
            $data = collect($request->data());

            $inputs = $data->where('name', 'inputs')->first();

            return $request->hasHeader('Authorization', "Bearer 123ABC==") &&
            $request->isMultipart() &&
            $inputs['contents'] === '[{"inputType":"document-photo","group":0,"data":{"type":"identity","country":"BR","region":"","page":"front","filename":"0001.jpg"}},{"inputType":"document-photo","group":0,"data":{"type":"identity","country":"BR","region":"","page":"back","filename":"0002.jpg"}}]' &&
            $request->hasFile('document', 'EXIF1', '0001.jpg') &&
            $request->hasFile('document', 'EXIF2', '0002.jpg');
        });
    }
}
