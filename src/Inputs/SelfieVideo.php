<?php

namespace WeDevBr\Mati\Inputs;

/**
 * Wrapper for identity input
 *
 * @author Gabriel Mineiro <gabrielpfgmineiro@gmail.com>
 */
class SelfieVideo extends BaseInput
{
    public function toArray()
    {
        return [
            'inputType' => 'selfie-video',
            'data' => [
                'filename' => $this->getFileName()
            ]
        ];
    }
}
