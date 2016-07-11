<?php

namespace WShafer\OpenGraph\Filter;

class WebSiteFilter extends OpenGraphFilterAbstract
{
    public function filter($value)
    {
        if (!empty($value['title'])) {
            $value['title'] = $this->filterTagsAndEntities($value['title']);
        }

        if (!empty($value['image'])) {
            $value['image'] = $this->stripTags->filter($value['image']);
        }

        if (!empty($value['description'])) {
            $value['description'] = $this->filterTagsAndEntities($value['description']);
        }

        if (!empty($value['siteName'])) {
            $value['siteName'] = $this->filterTagsAndEntities($value['siteName']);
        }
        
        return $value;
    }
}
