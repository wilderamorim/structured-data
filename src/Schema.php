<?php


namespace Source\Support\StructuredData;

abstract class Schema
{
    protected $person;

    protected $organization;

    protected $imageObject;

    const CONTEXT = 'http://schema.org';

    const TYPE = 'WebPage';

    const COMPANY_NAME = '';

    public function __construct()
    {
        //
    }

    public function person(string $name, string $image, int $imageWidth = 600, int $imageHeight = 600)
    {
        return $this->person = [
            '@type' => 'Person',
            'name' => $name,
            'image' => $image,
            'width' => $imageWidth,
            'height' => $imageHeight
        ];
    }

    public function organization(string $name, string $url, string $logo, array $sameAs = null)
    {
        return $this->organization = [
            '@type' => 'Organization',
            'name' => $name,
            'url' => $url,
            'logo' => [
                '@type' => 'ImageObject',
                'url' => $logo,
                'caption' => self::COMPANY_NAME,
            ],
            'image' => [
                '@type' => 'ImageObject',
                'url' => $logo,
                'caption' => self::COMPANY_NAME,
            ],
            'sameAs' => $sameAs
        ];
    }

    public function imageObject(string $logo, int $width = 1280, int $height = 720)
    {
        return $this->imageObject = [
            'image' => [
                '@type' => 'ImageObject',
                'url' => $logo,
                'width' => $width,
                'height' => $height,
                'caption' => self::COMPANY_NAME
            ]
        ];
    }

    public function json(array $schema)
    {
        return json_encode($schema);
    }
}