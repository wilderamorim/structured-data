<?php


namespace WilderAmorim\StructuredData;

use DateTime;

/**
 * Class Schema
 * @package WilderAmorim\StructuredData
 */
abstract class Schema
{
    /** @var */
    protected $person;

    /** @var */
    protected $organization;

    /** @var */
    protected $imageObject;

    /** @var string */
    protected $company;

    /**
     *
     */
    const CONTEXT = 'http://schema.org';

    /**
     *
     */
    const TYPE = 'WebPage';


    /**
     * Schema constructor.
     * @param string|null $company
     */
    public function __construct(string $company = null)
    {
        $this->company = $company;
    }

    /**
     * @param string $name
     * @param string $image
     * @param array $sameAs
     * @return Schema
     */
    protected function person(string $name, string $image, array $sameAs): Schema
    {
        $this->person = (object)[
            '@type' => 'Person',
            'name' => $name,
            'image' => $image,
            'sameAs' => (object)$sameAs
        ];
        return $this;
    }

    /**
     * @param string $name
     * @param string $url
     * @param array|null $sameAs
     * @return Schema
     */
    protected function organization(string $name, string $url, array $sameAs = null): Schema
    {
        $this->organization = (object)[
            '@type' => 'Organization',
            'name' => $name,
            'url' => $url,
            'logo' => $this->imageObject,
            'image' => $this->imageObject,
            'sameAs' => (object)$sameAs
        ];
        return $this;
    }

    /**
     * @param string $logo
     * @param int $width
     * @param int $height
     * @return Schema
     */
    protected function imageObject(string $logo, int $width = 1280, int $height = 720): Schema
    {
        $this->imageObject = (object)[
            '@type' => 'ImageObject',
            'url' => $logo,
            'width' => $width,
            'height' => $height,
            'caption' => $this->company
        ];
        return $this;
    }

    /**
     * @param array $schema
     * @return string
     */
    protected function json(array $schema): string
    {
        return json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }

    /**
     * @param string $date
     * @return string
     */
    protected function setDate(string $date): string
    {
        $needle = (strpos($date, '/') ? '/' : '-');

        if ($needle == '/') {
            list($d, $m, $y) = explode($needle, $date);
            $date = "{$y}-{$m}-{$d}";
        } else {
            list($y, $m, $d) = explode($needle, $date);
            $date = "{$y}-{$m}-{$d}";
        }
        return $date;
    }
}