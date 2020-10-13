<?php

namespace WeDevBr\Mati;

use WeDevBr\Mati\Support\Contracts\IdentityInputInterface;

/**
 * Wrapper for identity input
 *
 * @author Gabriel Mineiro <gabrielpfgmineiro@gmail.com>
 */
class IdentityInput implements IdentityInputInterface
{
    protected $input_type;
    protected $group;
    protected $type;
    protected $country;
    protected $region;
    protected $page;
    protected $file_path;

    /**
     * @param string $input_type
     * @return void
     */
    public function __construct(string $input_type)
    {
        $this->input_type = $input_type;
    }

    public function setGroup(int $group): IdentityInputInterface
    {
        $this->group = $group;
        return $this;
    }

    public function setType(string $type): IdentityInputInterface
    {
        $this->type = $type;
        return $this;
    }

    public function setCountry(string $country): IdentityInputInterface
    {
        $this->country = $country;
        return $this;
    }

    public function setRegion(string $region): IdentityInputInterface
    {
        $this->region = $region;
        return $this;
    }

    public function setPage(string $page): IdentityInputInterface
    {
        $this->page = $page;
        return $this;
    }

    public function setFilePath(string $path): IdentityInputInterface
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

    public function toArray()
    {
        return [
            'inputType' => $this->input_type,
            'group' => $this->group,
            'data' => [
                'type' => $this->type,
                'country' => $this->country,
                'region' => $this->region ?? '',
                'page' => $this->page,
                'filename' => $this->getFileName()
            ]
        ];
    }
}
