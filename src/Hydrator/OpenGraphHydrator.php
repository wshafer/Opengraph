<?php

namespace WShafer\OpenGraph\Hydrator;

use WShafer\OpenGraph\Entity\OpenGraph;
use WShafer\OpenGraph\Entity\OpenGraphArticle;
use WShafer\OpenGraph\Entity\OpenGraphWebsite;
use Zend\Hydrator\HydrationInterface;

class OpenGraphHydrator implements HydrationInterface
{
    public function hydrate(array $data, $object)
    {
        if (!$object instanceof OpenGraph) {
            return $object;
        }
        
        if (empty($data['general']['ogType'])) {
            return $object;
        }
        
        $object->setType($data['general']['ogType']);
        
        return $this->hydrateType($data, $object);
    }
    
    protected function hydrateType(array $data, OpenGraph $object) {
        if (empty($data['general']['ogType'])) {
            return $object;
        }
        
        $type = $data['general']['ogType'];
        
        switch ($type) {
            case 'website':
                return $this->hydrateWebSite($data, $object);
            case 'article':
                return $this->hydrateArticle($data, $object);
        }

        return $object;
    }

    protected function hydrateWebSite(array $data, OpenGraph $object)
    {
        $website = $object->getWebsite();

        if (!$website) {
            $website = new OpenGraphWebsite();
            $object->setWebsite($website);
        }

        $websiteHydrator = new OpenGraphWebsiteHydrator();
        $websiteHydrator->hydrate($data['website'], $website);
        return $object;
    }

    protected function hydrateArticle(array $data, OpenGraph $object)
    {
        $article = $object->getArticle();

        if (!$article) {
            $article = new OpenGraphArticle();
            $object->setArticle($article);
        }

        $articleHydrator = new OpenGraphArticleHydrator();
        $articleHydrator->hydrate($data['article'], $article);
        return $object;
    }
}
