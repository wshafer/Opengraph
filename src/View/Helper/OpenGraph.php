<?php

namespace WShafer\OpenGraph\View\Helper;

use Doctrine\ORM\EntityManagerInterface;
use Rcm\Entity\Page;
use Rcm\Entity\Site;
use Zend\Cache\Storage\StorageInterface;
use Zend\Config\Config;
use Zend\View\Helper\AbstractHelper;

/**
 * Open Graph View Helper
 * 
 * @author    Westin Shafer <westin@havenly.com>
 * @copyright 2016 Westin Shafer
 * @license   License.txt New BSD License
 */
class OpenGraph extends AbstractHelper
{
    protected $entityManager;

    protected $cache;

    protected $openGraphData;

    protected $config;

    public function __construct(
        EntityManagerInterface $entityManager,
        StorageInterface $cache,
        array $config
    ) {
        $this->entityManager = $entityManager;
        $this->cache = $cache;
        $this->config = $config;
    }

    /**
     * __invoke
     */
    public function __invoke()
    {
        $view = $this->getView();
        $tags = $this->getTags();

        $isAllowed = $view->plugin('rcmUserIsAllowed');

        if ($isAllowed('sites', 'admin', 'Rcm\Acl\ResourceProvider')) {
            $data = $this->getOpenGraphData();
            $tags[] = '<meta property="wshafer:opengraph" content="'.htmlentities(json_encode($data)).'" />';
        }

        return implode("\n", $tags);
    }

    protected function getTags()
    {
        $view = $this->getView();
        $key = 'openGraph_'.md5($view->serverUrl(true));
        
        if ($this->cache->hasItem($key)) {
            return $this->cache->getItem($key);
        }

        $data = $this->getOpenGraphData();

        $return = $this->getGeneralTags($data);
        
        switch ($data['general']['ogType']) {
            case 'website':
                $return = array_merge($return, $this->getWebsiteTags($data));
                break;
            case 'article':
                $return = array_merge($return, $this->getArticleTags($data));
                break;
        }

        $this->cache->addItem($key, $return);
        return $return;
    }

    protected function getGeneralTags($data)
    {
        $view = $this->getView();

        $return = [
            '<meta property="og:type" content="'.$data['general']['ogType'].'" />',
            '<meta property="og:url" content="'.$view->serverUrl(true).'" />',
        ];

        if (!empty($data['facebook']['appId'])) {
            $return[] = '<meta property="fb:app_id" content="'.$data['facebook']['appId'].'" />';
        }
        
        return $return;
    }

    protected function getWebsiteTags($data)
    {

        $tags = [
            '<meta property="og:title" content="'.$data['website']['title'].'" />',
            '<meta property="og:image" content="'.$data['website']['image'].'" />',
        ];

        if (!empty($data['website']['description'])) {
            $tags[] = '<meta property="og:description" content="'.$data['website']['description'].'" />';
        }

        if (!empty($data['website']['siteName'])) {
            $tags[] = '<meta property="og:site_name" content="'.$data['website']['siteName'].'" />';
        }
        
        return $tags;
    }

    protected function getArticleTags($data)
    {
        $view = $this->getView();

        $tags = [
            '<meta property="og:title" content="'.$data['article']['title'].'" />',
            '<meta property="og:image" content="'.$data['article']['image'].'" />',
        ];

        if (!empty($data['article']['description'])) {
            $tags[] = '<meta property="og:description" content="'.$data['article']['description'].'" />';
        }

        if (!empty($data['article']['siteName'])) {
            $tags[] = '<meta property="og:site_name" content="'.$data['article']['siteName'].'" />';
        }

        if (!empty($data['article']['section'])) {
            $tags[] = '<meta property="article:section" content="'.$data['article']['section'].'" />';
        }

        if (!empty($data['article']['author'])) {
            $tags[] = '<meta name="author" content="'.$data['article']['author'].'">';
        }

        if (!empty($view->page) && $view->page instanceof Page) {
            /** @var Page $page */
            $page = $view->page;
            $revision = $page->getCurrentRevision();
            $created = $page->getCreatedDate();
            $modified = $revision->getPublishedDate();

            $tags[] = '<meta property="article:published_time" content="'.$created->format('c').'">';
            $tags[] = '<meta property="article:modified_time" content="'.$modified->format('c').'">';
        }

        if (empty($data['article']['tags']) || !is_array($data['article']['tags'])) {
            return $tags;
        }

        foreach ($data['article']['tags'] as $articleTag) {
            if (empty($articleTag)) {
                continue;
            }

            $tags[] = '<meta property="article:tag" content="'.$articleTag.'">';
        }

        return $tags;
    }

    protected function getOpenGraphData()
    {
        if (!empty($this->openGraphData)) {
            return $this->openGraphData;
        }

        $view = $this->getView();

        $data = new Config($this->getDefaults());

        // CMS page
        if (!empty($view->page) && $view->page instanceof Page) {
            /** @var \WShafer\OpenGraph\Repository\OpenGraphRepository $repo */
            $repo = $this->entityManager->getRepository('WShafer\OpenGraph\Entity\OpenGraph');
            $savedData = new Config($repo->getOpenGraphAsArrayByPage($view->page));
            $data->merge($savedData);
        }

        $this->openGraphData = $data->toArray();

        return $this->openGraphData;
    }

    protected function getDefaults()
    {
        $view = $this->getView();

        $configDefaults = $this->getConfigDefaults();

        $titleHelper = $view->plugin('headTitle');
        $titleRendered = $titleHelper->renderTitle();

        /** @var Page $page */
        $page = !empty($view->page) ? $view->page : new Page();
        $site = !empty($page->getSite()) ? $page->getSite() : new Site();

        return [
            'facebook' => [
                'appId' => !empty($configDefaults['facebook']['appId']) ? $configDefaults['facebook']['appId'] : '',
            ],
            'general' => [
                'ogType' => 'website',
            ],
            'website' => [
                'title' => !empty($titleRendered) ? $titleRendered : $configDefaults['website']['title'],
                'image' => $configDefaults['website']['image'],
                'description' => $page->getDescription() ? $page->getDescription() : $configDefaults['website']['description'],
                'siteName' => $site->getSiteTitle() ? $site->getSiteTitle() : $configDefaults['website']['siteName'],
            ],
            'article' => [
                'title' => !empty($titleRendered) ? $titleRendered : $configDefaults['article']['title'],
                'image' => $configDefaults['article']['image'],
                'description' => $page->getDescription() ? $page->getDescription() : $configDefaults['article']['description'],
                'siteName' => $site->getSiteTitle() ? $site->getSiteTitle() : $configDefaults['article']['siteName'],
                'tags' => $configDefaults['article']['tags'],
                'author' => $configDefaults['article']['author'],
                'section' => $configDefaults['article']['section']
            ]
        ];
    }

    protected function getConfigDefaults()
    {
        if (empty($this->config['openGraph']['defaults'])) {
            throw new \Exception('openGraph is not properly configured');
        }

        return $this->config['openGraph']['defaults'];
    }
}
