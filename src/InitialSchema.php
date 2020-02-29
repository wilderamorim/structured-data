<?php


namespace WilderAmorim\StructuredData;


/**
 * Class InitialSchema
 * @package WilderAmorim\StructuredData
 */
class InitialSchema
{
    public $company;
    public $url;
    public $sameAs;

    /**
     * InitialSchema constructor.
     * @param string $companyName
     * @param string $companyUrl
     * @param array $companySameAs
     */
    public function __construct(string $companyName, string $companyUrl, ?array $companySameAs = null)
    {
        $this->company = $companyName;
        $this->url = $companyUrl;
        $this->sameAs = $companySameAs;
    }

}