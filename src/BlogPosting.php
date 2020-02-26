<?php


namespace Source\Support\StructuredData;

class BlogPosting extends Schema
{
    # HEADER
    private $headline;
    private $description;
    private $datePublished;
    private $dateModified;
    private $articleBody;

    # METHODS
    protected $mainEntityOfPage;
    protected $author;
    protected $publisher;
    protected $image;
    private $data;

    public function __construct()
    {
        $this->data->header = [
            '@context' => self::CONTEXT,
            '@type' => 'BlogPosting',
            'headline' => $this->headline,
            'description' => $this->description,
            'datePublished' => $this->datePublished,
            'dateModified' => $this->dateModified,
            'articleBody' => strip_tags($this->articleBody)
        ];
    }

    public function header()
    {
        return $this->data->header;
    }

    public function mainEntityOfPage(string $url, string $type = self::TYPE)
    {
        return $this->mainEntityOfPage = [
            '@type' => $type,
            '@id' => $url
        ];
    }

    public function author(string $name, string $image)
    {
        return $this->person($name, $image);
    }

    public function publisher(string $name, string $url, string $logo)
    {
        return $this->organization($name, $url, $logo);
    }

    public function image(string $cover)
    {
        return $this->imageObject($cover);
    }

    public function data()
    {
        return $this->data;
    }
}