<?php

namespace WeDevBr\Mati\Tests;

use Orchestra\Testbench\TestCase;
use WeDevBr\Mati\Inputs\DocumentPhoto;
use WeDevBr\Mati\MatiServiceProvider;

/**
 * Tests for DocumentPhoto class
 *
 * @author Gabriel Mineiro <gabrielpfgmineiro@gmail.com>
 */
class DocumentPhotoTest extends TestCase
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
        $input = new DocumentPhoto();
        $input->setGroup(0)
            ->setType('national-id')
            ->setCountry('BR')
            ->setPage('front')
            ->setFilePath('/tmp/0001.jpg');

        $this->assertEquals(
            [
                'inputType' => 'document-photo',
                'group' => 0,
                'data' => [
                    'type' => 'national-id',
                    'country' => 'BR',
                    'region' => '',
                    'page' => 'front',
                    'filename' => '0001.jpg'
                ]
            ],
            $input->toArray()
        );
    }
}
