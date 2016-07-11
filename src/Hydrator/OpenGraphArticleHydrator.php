<?php

namespace WShafer\OpenGraph\Hydrator;

use WShafer\OpenGraph\Entity\OpenGraphArticle;
use Zend\Hydrator\HydrationInterface;

class OpenGraphArticleHydrator implements HydrationInterface
{
    public function hydrate(array $data, $object)
    {
        if (!$object instanceof OpenGraphArticle) {
            return $object;
        }

        if (isset($data['title'])) {
            $object->setTitle($data['title']);
        }

        if (isset($data['image'])) {
            $object->setImage($data['image']);
        }

        if (isset($data['description'])) {
            $object->setDescription($data['description']);
        }

        if (isset($data['siteName'])) {
            $object->setSiteName($data['siteName']);
        }

        if (isset($data['author'])) {
            $object->setAuthor($data['author']);
        }

        if (isset($data['section'])) {
            $object->setSection($data['section']);
        }

        if (isset($data['tags'])) {
            $object->setTags($data['tags']);
        }
        
        return $object;
    }
}
