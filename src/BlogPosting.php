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
     * @see https://schema.org/BlogPosting
     */
    const TYPE = 'BlogPosting';

    /**
     * BlogPosting constructor.
     * @param Company $initialSchema
     */
    public function __construct(Company $initialSchema)
    {
        $this->data = new \stdClass();

        $this->companyName = $initialSchema->company;
        $this->companyUrl = $initialSchema->url;
        $this->companySameAs = $initialSchema->sameAs;
        parent::__construct();
    }

    /**
     * @see https://schema.org/mainEntityOfPage
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
     * @see https://schema.org/author
     *
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
     * @see https://schema.org/publisher
     *
     * @param string $image
     * @return Schema
     */
    public function publisher(string $image): Schema
    {
        return $this->organization($image, $image);
    }

    /**
     * @see https://schema.org/image
     *
     * @param string $url
     * @return array
     */
    public function image(string $url): array
    {
        return $this->imageObject($url);
    }

    /**
     * @param string $headline
     * @param string $description
     * @param string $articleBody
     * @param string $datePublished
     * @param string|null $dateModified
     * @return BlogPosting
     */
    public function start(
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
     * @return object
     */
    public function header(): object
    {
        return $this->data->header;
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
    public function render(): string
    {
        $render = [
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