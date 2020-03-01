<?php


namespace WilderAmorim\StructuredData;

/**
 * Class WebPage
 * @package WilderAmorim\StructuredData
 */
class WebPage extends Schema
{
    /**
     * @var \stdClass
     */
    protected $data;

    /**
     * @see https://schema.org/WebPage
     */
    const TYPE = 'WebPage';

    /**
     * WebPage constructor.
     */
    public function __construct()
    {
        $this->data = new \stdClass();
        parent::__construct();
    }

    /**
     * @return object
     */
    public function header(): object
    {
        return $this->data->header;
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return $this->data->name;
    }

    /**
     * @return string
     */
    public function url(): string
    {
        return $this->data->url;
    }

    /**
     * @return string
     */
    public function description(): string
    {
        return $this->data->description;
    }

    /**
     * @return array|null
     */
    public function sameAs(): ?array
    {
        return $this->webPageSameAs;
    }

    /**
     * @param string $name
     * @param string $description
     * @param string $image
     * @param string $url
     * @param string $inLanguage
     * @return WebPage
     */
    public function start(
        string $name,
        string $description,
        string $image,
        string $url,
        string $inLanguage = 'en-US'
    ): WebPage {
        $this->data->name = $name;
        $this->data->url = $url;
        $this->data->description = $description;
        $this->data->image = $image;
        $this->data->inLanguage = $inLanguage;

        $this->webPageName = $this->data->name;
        $this->webPageUrl = $this->data->url;

        $this->data->header = (object)[
            '@context' => Schema::CONTEXT,
            '@type' => self::TYPE,
            'name' => $this->data->name,
            'description' => $this->data->description,
            'image' => $this->data->image,
            'url' => $this->data->url,
            'inLanguage' => $this->data->inLanguage
        ];
        return $this;
    }

    /**
     * @see https://schema.org/isPartOf
     *
     * @param string $logo
     * @param string $image
     * @param string $type
     * @param array|null $sameAs
     * @return WebPage
     */
    public function isPartOf(string $logo, string $image, string $type = 'WebSite', ?array $sameAs = null): WebPage
    {
        $this->webPageSameAs = $sameAs;

        $this->data->isPartOf = (object)[
            '@type' => $type,
            'name' => $this->data->name,
            'url' => $this->data->url,
            'publisher' => $this->organization($logo, $image)
        ];
        return $this;
    }

    /**
     * @see https://schema.org/about
     *
     * @param string $image
     * @return WebPage
     */
    public function about(string $image): WebPage
    {
        $this->data->about = $this->organization($image, $image);
        return $this;
    }

    /**
     * @see https://schema.org/creator
     *
     * @param string $organizationImage
     * @param string $addressLocality
     * @param string $addressRegion
     * @param string $postalCode
     * @param string $streetAddress
     * @param string $personName
     * @param string $personImage
     * @param array|null $sameAs
     * @return WebPage
     */
    public function creator(
        string $organizationImage,
        string $addressLocality,
        string $addressRegion,
        string $postalCode,
        string $streetAddress,
        string $personName,
        string $personImage,
        ?array $sameAs = null
    ): WebPage {
        $address = [
            'addressLocality' => $addressLocality,
            'addressRegion' => $addressRegion,
            'postalCode' => $postalCode,
            'streetAddress' => $streetAddress
        ];

        $this->data->organization = $this->organization($organizationImage, $organizationImage, $address);
        $this->data->person = $this->person($personName, $personImage, $sameAs);

        $this->data->creator = [
            'organization' => $this->data->organization,
            'person' => $this->data->person
        ];
        return $this;
    }

    /**
     * @return object
     */
    public function data(): object
    {
        $this->data = (object)[
            'header' => $this->header(),
            'isPartOf' => (object)$this->data->isPartOf,
            'about' => (object)$this->data->about,
            'creator' => $this->data->creator,
            'organization' => $this->organization,
            'image' => $this->imageObject
        ];
        return $this->data;
    }

    /**
     * @param bool $tag
     * @return string
     */
    public function render(bool $tag = false): string
    {
        $render = [
            '@context' => Schema::CONTEXT,
            '@type' => self::TYPE,
            'name' => $this->data->name,
            'description' => $this->data->description,
            'image' => $this->data->image,
            'url' => $this->data->url,
            'inLanguage' => $this->data->inLanguage,
            'isPartOf' => [$this->data->isPartOf],
            'about' => [$this->data->about],
            'creator' => [$this->data->organization, $this->data->person],
        ];

        if ($tag) {
            return '<script type="application/ld+json">' . $this->json($render) . '</script>';
        }

        return $this->json($render);
    }

    /**
     * Responsible method for debug all data
     */
    public function debug(): void
    {
        var_dump($this->data());
    }
}