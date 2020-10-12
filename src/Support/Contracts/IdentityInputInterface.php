<?php

namespace WeDevBr\Mati\Support\Contracts;

use Illuminate\Contracts\Support\Arrayable;

interface IdentityInputInterface extends Arrayable
{
    public function __construct(string $input_type);
    public function setGroup(int $group): IdentityInputInterface;
    public function setType(string $type): IdentityInputInterface;
    public function setCountry(string $country): IdentityInputInterface;
    public function setRegion(string $region): IdentityInputInterface;
    public function setPage(string $page): IdentityInputInterface;
    public function setFilePath(string $path): IdentityInputInterface;
    public function getFileName(): string;
    public function getFileContents();
}
