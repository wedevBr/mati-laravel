<?php

namespace WeDevBr\Mati\Tests;

use Orchestra\Testbench\TestCase;
use WeDevBr\Mati\MatiServiceProvider;

class ExampleTest extends TestCase
{

    protected function getPackageProviders($app)
    {
        return [MatiServiceProvider::class];
    }

    /** @test */
    public function true_is_true()
    {
        $this->assertTrue(true);
    }
}
