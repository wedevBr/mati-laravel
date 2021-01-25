<?php

namespace WeDevBr\Mati\Inputs;

/**
 * Wrapper for identity input
 *
 * @author Gabriel Mineiro <gabrielpfgmineiro@gmail.com>
 */
class SelfiePhoto extends BaseInput
{
    use HasType;

    public function toArray()
    {
        return [
            'inputType' => 'selfie-photo',
            'data' => [
                'type' => $this->type,
                'filename' => $this->getFileName()
            ]
        ];
    }
}
