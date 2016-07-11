<?php

namespace WShafer\OpenGraph\Filter;

class ArticleFilter extends OpenGraphFilterAbstract
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

        if (!empty($value['author'])) {
            $value['author'] = $this->filterTagsAndEntities($value['author']);
        }

        if (!empty($value['section'])) {
            $value['section'] = $this->filterTagsAndEntities($value['section']);
        }

        foreach ($value['tags'] as $index => &$tag) {
            if (empty($tag)) {
                unset($value[$index]);
                continue;
            }

            $value['tags'][$index] = $this->filterTagsAndEntities($tag);
        }
        
        return $value;
    }
}
