<?php

namespace WShafer\OpenGraph\Repository;

use Doctrine\ORM\EntityRepository;
use WShafer\OpenGraph\Entity\OpenGraph;

/**
 * OpenGraph Repository
 *
 * OpenGraph Repository.
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   Rcm
 * @author    Westin Shafer <wshafer@relivinc.com>
 * @copyright 2016 Reliv International
 * @license   License.txt New BSD License
 * @version   Release: 1.0
 * @link      https://github.com/reliv
 */
class OpenGraphRepository extends EntityRepository
{
    public function getOpenGraphAsArrayByPage($page)
    {
        /** @var OpenGraph $entity */
        $entity = $this->findOneBy(array('page' => $page));
        $return = [];
        
        if (!$entity) {
            return $return;
        }
        
        $return['general'] = $entity->toArray();
        
        if (!empty($entity->getWebsite())) {
            $return['website'] = $entity->getWebsite()->toArray();
        }

        if (!empty($entity->getArticle())) {
            $return['article'] = $entity->getArticle()->toArray();
        }
        
        return $return;
    }
}
