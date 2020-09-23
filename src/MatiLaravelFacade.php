<?php

namespace WeDevBr\Mati;

use Illuminate\Support\Facades\Facade;

/**
 * @see \WeDevBr\Mati\Skeleton\SkeletonClass
 */
class MatiFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'mati';
    }
}
