<?php

namespace WShafer\OpenGraph\Filter;

class OpenGraphFilter extends OpenGraphFilterAbstract
{
    protected $websiteFilter;
    
    protected $articleFilter;
    
    public function __construct()
    {
        parent::__construct();
        $this->websiteFilter = new WebSiteFilter();
        $this->articleFilter = new ArticleFilter();
    }

    public function filter($value)
    {
        if (!empty($value['general']['ogType'])) {
            $value['general']['ogType'] = $this->filterTagsAndEntities($value['general']['ogType']);
        }
        
        if (!empty($value['article'])) {
            $value['article'] = $this->articleFilter->filter($value['article']);
        }
        
        return $value;
    }
}
