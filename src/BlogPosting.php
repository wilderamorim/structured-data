<?php


namespace ElePHPant\StructuredData;

/**
 * Class BlogPosting
 * @package ElePHPant\StructuredData
 */
class BlogPosting extends Schema
{
    /**
     * @var \stdClass
     */
    private $data;

    /**
     * @link https://schema.org/BlogPosting
     */
    const TYPE = 'BlogPosting';

    /**
     * BlogPosting constructor.
     * @param WebPage $webPage
     */
    public function __construct(WebPage $webPage)
    {
        $this->webPageName = $webPage->name();
        $this->webPageUrl = $webPage->url();
        $this->webPageSameAs = $webPage->sameAs();
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
     * @link https://schema.org/mainEntityOfPage
     *
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
     * @link https://schema.org/image
     *
     * @param string $url
     * @return array
     */
    public function image(string $url): array
    {
        return $this->imageObject($url);
    }

    /**
     * @link https://schema.org/author
     *
     * @param string $name
     * @param string $image
     * @param array|null $sameAs
     * @return object
     */
    public function author(string $name, string $image, array $sameAs = null): object
    {
        return $this->person($name, $image, $sameAs);
    }

    /**
     * @link https://schema.org/publisher
     *
     * @param string $image
     * @return object
     */
    public function publisher(string $image): object
    {
        return $this->organization($image, $image);
    }

    /**
     * @return object
     */
    public function data(): object
    {
        $this->data = (object)[
            'header' => $this->header(),
            'mainEntityOfPage' => (object)$this->data->mainEntityOfPage,
            'image' => (object)$this->imageObject,
            'author' => (object)$this->person,
            'publisher' => (object)$this->organization
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
            '@context' => self::CONTEXT,
            '@type' => self::TYPE,
            'headline' => $this->data->header->headline,
            'description' => $this->data->header->description,
            'datePublished' => $this->data->header->datePublished,
            'dateModified' => $this->data->header->dateModified,
            'articleBody' => $this->data->header->articleBody,
            'mainEntityOfPage' => $this->data->mainEntityOfPage,
            'image' => $this->imageObject,
            'author' => $this->person,
            'publisher' => [$this->organization]
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