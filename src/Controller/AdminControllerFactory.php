<?php

namespace WShafer\OpenGraph\Controller;

use Interop\Container\ContainerInterface;
use WShafer\OpenGraph\Filter\OpenGraphFilter;
use WShafer\OpenGraph\Hydrator\OpenGraphHydrator;
use WShafer\OpenGraph\Validator\OpenGraphValidator;
use Zend\View\Helper\ServerUrl;

class AdminControllerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $filter = new OpenGraphFilter();
        $validator = new OpenGraphValidator();
        $hydrator = new OpenGraphHydrator();

        /** @var \Doctrine\ORM\EntityManagerInterface $entityManager */
        $entityManager = $container->getServiceLocator()->get('Doctrine\ORM\EntityManager');

        /** @var \Zend\Cache\Storage\StorageInterface $cache */
        $cache = $container->getServiceLocator()->get('Rcm\Service\Cache');

        /** @var ServerUrl $serverUrl */
        $serverUrl = $container->getServiceLocator()->get('ViewHelperManager')->get('serverUrl');

        return new AdminController(
            $filter,
            $validator,
            $hydrator,
            $entityManager,
            $cache,
            $serverUrl
        );
    }
}
