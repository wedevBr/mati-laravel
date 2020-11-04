<?php

namespace WeDevBr\Mati\Inputs;

use WeDevBr\Mati\Support\Contracts\IdentityInputInterface;

/**
 * Wrapper for identity input
 *
 * @author Gabriel Mineiro <gabrielpfgmineiro@gmail.com>
 */
abstract class BaseInput implements IdentityInputInterface
{
    protected $file_path;

    public function setFilePath(string $path)
    {
        $this->file_path = $path;
        return $this;
    }

    public function getFileName(): string
    {
        return basename($this->file_path);
    }

    public function getFileContents()
    {
        return file_get_contents($this->file_path);
    }

    abstract public function toArray();
}
