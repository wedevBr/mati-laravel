<?php

namespace WeDevBr\Mati\Inputs;

/**
 * Wrapper for identity input
 *
 * @author Gabriel Mineiro <gabrielpfgmineiro@gmail.com>
 */
class DocumentPhoto extends BaseInput
{
    use HasType;

    protected $group;
    protected $country;
    protected $region;
    protected $page;

    public function setGroup(int $group): DocumentPhoto
    {
        $this->group = $group;
        return $this;
    }

    public function setCountry(string $country): DocumentPhoto
    {
        $this->country = $country;
        return $this;
    }

    public function setRegion(string $region): DocumentPhoto
    {
        $this->region = $region;
        return $this;
    }

    public function setPage(string $page): DocumentPhoto
    {
        $this->page = $page;
        return $this;
    }

    public function setFilePath(string $path): DocumentPhoto
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
            'inputType' => 'document-photo',
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
