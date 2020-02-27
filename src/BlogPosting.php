<?php


namespace WilderAmorim\StructuredData;

/**
 * Class BlogPosting
 * @package WilderAmorim\StructuredData
 */
class BlogPosting extends Schema
{
    /**
     * @var \stdClass
     */
    private $data;

    /**
     *
     */
    const TYPE = 'BlogPosting';

    /**
     * BlogPosting constructor.
     * @param string $company
     */
    public function __construct(string $company)
    {
        $this->data = new \stdClass();

        parent::__construct($company);
    }

    /**
     * @param string $headline
     * @param string $description
     * @param string $articleBody
     * @param string $datePublished
     * @param string|null $dateModified
     * @return BlogPosting
     */
    public function insertHeader(
        string $headline,
        string $description,
        string $articleBody,
        string $datePublished,
        ?string $dateModified = null
    ): BlogPosting {
        $this->data->header = (object)[
            'headline' => $headline,
            'description' => $description,
            'articleBody' => strip_tags($articleBody),
            'datePublished' => $this->setDate($datePublished),
            'dateModified' => (!is_null($dateModified) ? $this->setDate($dateModified) : $this->setDate($datePublished))
        ];
        return $this;
    }

    /**
     * @param string $url
     * @param string $type
     * @return BlogPosting
     */
    public function mainEntityOfPage(string $url, string $type = Schema::TYPE): BlogPosting
    {
        $this->data->mainEntityOfPage = [
            '@type' => $type,
            '@id' => $url
        ];
        return $this;
    }

    /**
     * @return object
     */
    public function header(): object
    {
        return $this->data->header;
    }

    /**
     * @param string $name
     * @param string $image
     * @param array|null $sameAs
     * @return Schema
     */
    public function author(string $name, string $image, array $sameAs = null): Schema
    {
        return $this->person($name, $image, $sameAs);
    }

    /**
     * @param string $name
     * @param string $url
     * @param array|null $sameAs
     * @return Schema
     */
    public function publisher(string $name, string $url, array $sameAs = null): Schema
    {
        return $this->organization($name, $url, $sameAs);
    }

    /**
     * @param string $cover
     * @return Schema
     */
    public function image(string $cover): Schema
    {
        return $this->imageObject($cover);
    }

    /**
     * @return object
     */
    public function data(): object
    {
        $this->data = (object)[
            'header' => $this->header(),
            'mainEntityOfPage' => (object)$this->data->mainEntityOfPage,
            'author' => (object)$this->person,
            'image' => (object)$this->imageObject,
            'publisher' => (object)$this->organization
        ];
        return $this->data;
    }

    /**
     * @return string
     */
    public function structuredData(): string
    {
        $structuredData = [
            '@context' => self::CONTEXT,
            '@type' => self::TYPE,
            'headline' => $this->data->header->headline,
            'description' => $this->data->header->description,
            'datePublished' => $this->data->header->datePublished,
            'dateModified' => $this->data->header->dateModified,
            'articleBody' => $this->data->header->articleBody,
            'author' => $this->person,
            'mainEntityOfPage' => $this->data->mainEntityOfPage,
            'publisher' => [$this->organization],
            'image' => $this->imageObject
        ];
        return $this->json($structuredData);
    }

    /**
     * Responsible method for debug all data
     */
    public function debug(): void
    {
        var_dump($this->data());
    }
}