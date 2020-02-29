<?php


namespace WilderAmorim\StructuredData;

/**
 * Class Company
 * @package WilderAmorim\StructuredData
 */
class Company
{
    /** @var string */
    public $company;

    /** @var string */
    public $url;

    /** @var array|null */
    public $sameAs;

    /**
     * Company constructor.
     * @param string $name
     * @param string $url
     * @param array|null $sameAs
     */
    public function __construct(string $name, string $url, ?array $sameAs = null)
    {
        $this->company = $name;
        $this->url = $url;
        $this->sameAs = $sameAs;
    }
}