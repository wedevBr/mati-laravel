<?php

namespace WeDevBr\Mati\Support\Contracts;

use Illuminate\Contracts\Support\Arrayable;

interface IdentityInputInterface extends Arrayable
{
    public function __construct(string $input_type);
    public function setGroup(int $group): self;
    public function setType(string $type): self;
    public function setCountry(string $country): self;
    public function setRegion(string $region): self;
    public function setPage(string $page): self;
    public function setFilePath(string $path): self;
    public function getFileName(): string;
    public function getFileContents();
}
