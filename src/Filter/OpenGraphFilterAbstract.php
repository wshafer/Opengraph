<?php
namespace WShafer\OpenGraph\Filter;

use Zend\Filter\FilterInterface;
use Zend\Filter\HtmlEntities;
use Zend\Filter\StripTags;

abstract class OpenGraphFilterAbstract implements FilterInterface
{
    protected $stripTags;

    protected $htmlEncode;

    public function __construct()
    {
        $this->stripTags = new StripTags();
        $this->htmlEncode = new HtmlEntities();
    }

    protected function filterTagsAndEntities($value)
    {
        $value = $this->stripTags->filter($value);
        $value = $this->htmlEncode->filter($value);

        return $value;
    }
}
