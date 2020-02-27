<?php


namespace WilderAmorim\StructuredData;

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
     * @see http://schema.org
     */
    const CONTEXT = 'http://schema.org';

    /**
     * @see https://schema.org/WebPage
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
     * @see https://schema.org/Person
     *
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
            'sameAs' => $sameAs
        ];
        return $this;
    }

    /**
     * @see https://schema.org/Organization
     */
    protected function organization(string $url, array $sameAs = null): Schema
    {
        $this->organization = (object)[
            '@type' => 'Organization',
            'name' => $this->company,
            'url' => $url,
            'logo' => $this->imageObject,
            'image' => $this->imageObject,
            'sameAs' => $sameAs
        ];
        return $this;
    }

    /**
     * @see https://schema.org/ImageObject
     *
     * @param string $url
     * @param int $width
     * @param int $height
     * @return Schema
     */
    protected function imageObject(string $url, int $width = 1280, int $height = 720): Schema
    {
        $this->imageObject = (object)[
            '@type' => 'ImageObject',
            'url' => $url,
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
        $date = (strpos($date, ' ') ? explode(' ', $date)[0] : $date);

        $date = str_replace('/', '-', $date);
        $date = explode('-', $date);

        if (strlen($date[0]) == 4) {
            $date = "{$date[0]}-{$date[1]}-$date[2]";
        }

        if (strlen($date[2]) == 4) {
            $date = "{$date[2]}-{$date[1]}-$date[0]";
        }

        return $date;
    }
}