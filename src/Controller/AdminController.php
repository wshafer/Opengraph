<?php

namespace WShafer\OpenGraph\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Rcm\Http\Response;
use Rcm\View\Model\ApiJsonModel;
use RcmAdmin\Controller\ApiAdminBaseController;
use WShafer\OpenGraph\Entity\OpenGraph;
use Zend\Cache\Storage\StorageInterface;
use Zend\Filter\FilterInterface;
use Zend\Hydrator\HydrationInterface;
use Zend\Validator\ValidatorInterface;
use Zend\View\Helper\ServerUrl;
use Zend\View\Model\ViewModel;

/**
 * OpenGraph Admin Controller
 *
 * This is Admin OpenGraph Controller for the CMS.
 * 
 * @author    Westin Shafer <wshafer@relivinc.com>
 * @license   License.txt New BSD License
 * @version   Release: 1.0
 * @link      http://github.com/reliv
 */
class AdminController extends ApiAdminBaseController
{
    protected $filter;

    protected $validator;

    protected $hydrator;

    protected $entityManager;

    protected $cache;
    
    /** @var ServerUrl */
    protected $serverUrl;

    public function __construct(
        FilterInterface $filter,
        ValidatorInterface $validator,
        HydrationInterface $hydrator,
        EntityManagerInterface $entityManager,
        StorageInterface $cache,
        ServerUrl $serverUrl
    ) {
        $this->filter = $filter;
        $this->validator = $validator;
        $this->entityManager = $entityManager;
        $this->hydrator = $hydrator;
        $this->cache = $cache;
        $this->serverUrl;
    }

    /**
     * isAllowed
     *
     * @param $resourceId
     * @param $privilege
     *
     * @return mixed
     */
    protected function isAllowed($resourceId, $privilege)
    {
        $rcmUserService = $this->getServiceLocator()->get(
            'RcmUser\Service\RcmUserService'
        );

        return $rcmUserService->isAllowed(
            $resourceId,
            $privilege
        );
    }

    /**
     * getRequestSiteId
     *
     * @return mixed
     */
    protected function getRequestSiteId()
    {
        $siteId = $this->getEvent()
            ->getRouteMatch()
            ->getParam(
                'siteId',
                'current'
            );

        if ($siteId == 'current') {
            $siteId = $this->getCurrentSite()->getSiteId();
        }

        return (int)$siteId;
    }
    
    public function saveAction()
    {
        $siteId = $this->getRequestSiteId();

        $pageId = $this->getEvent()
            ->getRouteMatch()
            ->getParam('pageId');

        if (!$pageId) {
            throw new \Exception('No Page Id Provided');
        }

        $key = 'openGraph_'.md5($this->serverUrl->__invoke(true));

        $pageRepo = $this->entityManager->getRepository('Rcm\Entity\Page');

        $page = $pageRepo->find($pageId);

        if (!$page) {
            throw new \Exception('Unable to fetch page #: '.$pageId);
        }

        //ACCESS CHECK
        $sitePagesResource = 'sites.' . $siteId . '.pages';
        
        if (!$this->isAllowed('pages', 'edit')
            && !$this->isAllowed($sitePagesResource, 'edit')
        ) {
            $this->getResponse()->setStatusCode(Response::STATUS_CODE_401);
            return $this->getResponse();
        }

        /** @var \Zend\Http\Request $request */
        $request = $this->getRequest();

        if ($request->isPut()) {
            /** @var \Zend\Stdlib\Parameters $data */
            $data = json_decode($request->getContent(), true);

            $data = $data['openGraph'];

            $filtered = $this->filter->filter($data);

            if (!$this->validator->isValid($filtered)) {
                return new ApiJsonModel(null, 406, $this->validator->getMessages()[0]);
            }

            $repo = $this->entityManager->getRepository('WShafer\OpenGraph\Entity\OpenGraph');

            $entity = $repo->findOneBy(array('page' => $page));

            if (!$entity) {
                $entity = new OpenGraph();
                $this->entityManager->persist($entity);
            }

            $this->hydrator->hydrate($filtered, $entity);

            $entity->setPage($page);

            $this->entityManager->flush();

            $this->cache->removeItem($key);

            return new ApiJsonModel(null, 0, 'Success');
        }

        return new ApiJsonModel(null, 503, 'Method not allowed');
    }
}
