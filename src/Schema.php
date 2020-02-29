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
    protected $companyName;

    /**  @var string */
    protected $companyUrl;

    /** @var array */
    protected $companySameAs;

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
     */
    public function __construct()
    {
        //
    }

    /**
     * @see https://schema.org/Person
     *
     * @param string $name
     * @param string $image
     * @param array|null $sameAs
     * @return Schema
     */
    protected function person(string $name, string $image, ?array $sameAs = null): Schema
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
     *
     * @param string $logo
     * @param string $image
     * @return Schema
     */
    protected function organization(string $logo, string $image): Schema
    {
        $logo = $this->imageObject($logo, null, null);
        $image = $this->imageObject($image, null, null);
        $this->organization = (object)[
            '@type' => 'Organization',
            'name' => $this->companyName,
            'url' => $this->companyUrl,
            'logo' => $logo,
            'image' => $image,
            'sameAs' => ($this->companySameAs ?? null)
        ];
        return $this;
    }

    /**
     * @see https://schema.org/ImageObject
     *
     * @param string $url
     * @param int|null $width
     * @param int|null $height
     * @return array
     */
    protected function imageObject(string $url, ?int $width = 1280, ?int $height = 720): array
    {
        $this->imageObject = [
            '@type' => 'ImageObject',
            'url' => $url,
            'width' => $width,
            'height' => $height,
            'caption' => $this->companyName
        ];
        return $this->imageObject;
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