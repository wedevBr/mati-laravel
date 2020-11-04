<?php

namespace WeDevBr\Mati\Tests;

use Orchestra\Testbench\TestCase;
use WeDevBr\Mati\Inputs\SelfiePhoto;
use WeDevBr\Mati\MatiServiceProvider;

/**
 * Tests for SelfiePhoto class
 *
 * @author Gabriel Mineiro <gabrielpfgmineiro@gmail.com>
 */
class SelfiePhotoTest extends TestCase
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
        $input = new SelfiePhoto();
        $input->setType('selfie-photo')
            ->setFilePath('/tmp/0001.jpg');

        $this->assertEquals(
            [
                'inputType' => 'selfie-photo',
                'data' => [
                    'type' => 'selfie-photo',
                    'filename' => '0001.jpg'
                ]
            ],
            $input->toArray()
        );
    }
}
