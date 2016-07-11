<?php

namespace WShafer\OpenGraph\Hydrator;

use WShafer\OpenGraph\Entity\OpenGraphWebsite;
use Zend\Hydrator\HydrationInterface;

class OpenGraphWebsiteHydrator implements HydrationInterface
{
    public function hydrate(array $data, $object)
    {
        if (!$object instanceof OpenGraphWebsite) {
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
        
        return $object;
    }
}
