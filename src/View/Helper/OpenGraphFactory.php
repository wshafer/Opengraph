<?php

namespace WShafer\OpenGraph\View\Helper;

use Interop\Container\ContainerInterface;

class OpenGraphFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $serviceLocator = $container->getServiceLocator();
        
        /** @var \Doctrine\ORM\EntityManagerInterface $entityManager */
        $entityManager = $serviceLocator->get('Doctrine\ORM\EntityManager');

        /** @var \Zend\Cache\Storage\StorageInterface $cache */
        $cache = $serviceLocator->get('Rcm\Service\Cache');

        $config = $serviceLocator->get('config');
        
        return new OpenGraph($entityManager, $cache, $config);
    }
}
