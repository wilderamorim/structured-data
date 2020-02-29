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

    //PUBLIC METHODS

    /**
     * @return object
     */
    public function header(): object
    {
        return $this->data->header;
    }

    public function name(): string
    {
        return $this->data->name;
    }

    public function url(): string
    {
        return $this->data->url;
    }

    public function sameAs(): ?array
    {
        return $this->webPageSameAs;
    }

    public function description(): string
    {
        return $this->data->description;
    }

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

    public function isPartOf(string $logo, string $image, string $type = 'WebSite', ?array $sameAs = null): WebPage
    {
        $this->webPageSameAs = $sameAs;
        //$publisher = $this->organization($logo, $image);
        $this->data->isPartOf = (object)[
            '@type' => $type,
            'name' => $this->data->name,
            'url' => $this->data->url,
            'publisher' => $this->organization($logo, $image)
        ];
        return $this;
    }

    public function about(string $image): WebPage
    {
        $this->data->about = $this->organization($image, $image);
        return $this;
    }

    public function creator(
        string $imageOrganization,
        string $addressLocality,
        string $addressRegion,
        string $postalCode,
        string $streetAddress,
        string $namePerson,
        string $photoPerson,
        ?array $sameAs = null
    ): WebPage {
        $dataAddress = [
            "addressLocality" => $addressLocality,
            "addressRegion" => $addressRegion,
            "postalCode" => $postalCode,
            "streetAddress" => $streetAddress
        ];

        $this->data->organization = $this->organization($imageOrganization, $imageOrganization, $dataAddress);
        $this->data->person = $this->person($namePerson, $photoPerson, $sameAs);

        $this->data->creator = [
            "organization" => $this->data->organization,
            "person" => $this->data->person
        ];
        return $this;
    }

    public function render(): string
    {

        $render = [
            "@context" => Schema::CONTEXT,
            "@type" => self::TYPE,
            "name" => $this->data->name,
            "description" => $this->data->description,
            "image" => $this->data->image,
            "url" => $this->data->url,
            "inLanguage" => $this->data->inLanguage,
            "isPartOf" => [$this->data->isPartOf],
            "about" => [$this->data->about],
            "creator" => [$this->data->organization, $this->data->person],
        ];

        return $this->json($render);

    }


    public function data()
    {
        $this->data = (object)[
            "header" => $this->header(),
            "isPartOf" => (object)$this->data->isPartOf,
            "about" => (object)$this->data->about,
            "creator" => $this->data->creator,
            "organization" => $this->organization,
            "image" => $this->imageObject
        ];
        return $this->data;
    }

    /**
     * Responsible method for debug all data
     */
    public function debug(): void
    {
        var_dump($this->data());
    }

    //PROTECTED METHODS


    //PRIVATE METHODS


}