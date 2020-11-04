<?php

namespace WeDevBr\Mati\Tests;

use Orchestra\Testbench\TestCase;
use WeDevBr\Mati\Inputs\SelfieVideo;
use WeDevBr\Mati\MatiServiceProvider;

/**
 * Tests for SelfieVideo class
 *
 * @author Gabriel Mineiro <gabrielpfgmineiro@gmail.com>
 */
class SelfieVideoTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [MatiServiceProvider::class];
    }

    /**
     * Test toArray method
     *
     * Expects that method returns correct array structure and data
     *
     * @test
     * @return void
     */
    public function testToArray()
    {
        $input = new SelfieVideo();
        $input->setFilePath('/tmp/0001.mp4');

        $this->assertEquals(
            [
                'inputType' => 'selfie-video',
                'data' => [
                    'filename' => '0001.mp4'
                ]
            ],
            $input->toArray()
        );
    }
}
