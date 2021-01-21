<?php

namespace WeDevBr\Mati\Support\Contracts;

use Illuminate\Contracts\Support\Arrayable;

interface IdentityInputInterface extends Arrayable
{
    public function setFilePath(string $path);
    public function getFileName(): string;
    public function getFileContents();
}
