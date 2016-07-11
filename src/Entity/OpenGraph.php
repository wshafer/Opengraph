<?php

namespace WShafer\OpenGraph\Entity;

use Doctrine\ORM\Mapping as ORM;
use Rcm\Entity\Page;

/**
 * Open Graph Entity
 *
 * This object contains the main Open Graph Entity.
 *
 * @category  Reliv
 * @package   Rcm
 * @author    Westin Shafer <westin@havenly.com>
 * @copyright 2016 Reliv International
 * @license   License.txt New BSD License
 * @version   Release: 1.0
 * @link      http://github.com/reliv
 *
 * @ORM\Entity(repositoryClass="WShafer\OpenGraph\Repository\OpenGraphRepository")
 * @ORM\Table(name="rcm_page_open_graph")
 */
class OpenGraph
{
    /**
     * @var int Auto-Incremented Primary Key
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @var string Open Graph Type
     *
     * @ORM\Column(type="string")
     */
    protected $type;

    /**
     * @var \Rcm\Entity\Page Primary Domain name for a site.
     *
     * @ORM\OneToOne(targetEntity="\Rcm\Entity\Page")
     * @ORM\JoinColumn(
     *     name="pageId",
     *     referencedColumnName="pageId",
     *     onDelete="SET NULL"
     * )
     */
    protected $page;

    /**
     * @var OpenGraphWebsite Website Object.
     *
     * @ORM\OneToOne(targetEntity="OpenGraphWebsite", orphanRemoval=true, cascade={"persist", "remove"})
     * @ORM\JoinColumn(
     *     name="website",
     *     referencedColumnName="id",
     *     onDelete="SET NULL"
     * )
     */
    protected $website;

    /**
     * @var OpenGraphArticle Article Object.
     *
     * @ORM\OneToOne(targetEntity="OpenGraphArticle", orphanRemoval=true, cascade={"persist", "remove"})
     * @ORM\JoinColumn(
     *     name="article",
     *     referencedColumnName="id",
     *     onDelete="SET NULL"
     * )
     */
    protected $article;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return \Rcm\Entity\Page
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * @param \Rcm\Entity\Page $page
     */
    public function setPage(Page $page)
    {
        $this->page = $page;
    }

    /**
     * @return OpenGraphWebsite
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * @param OpenGraphWebsite $website
     */
    public function setWebsite(OpenGraphWebsite $website)
    {
        $this->website = $website;
        $this->article = null;
    }

    /**
     * @return OpenGraphArticle
     */
    public function getArticle()
    {
        return $this->article;
    }

    /**
     * @param OpenGraphArticle $article
     */
    public function setArticle(OpenGraphArticle $article)
    {
        $this->article = $article;
        $this->website = null;
    }
    
    
    public function toArray()
    {
        return [
            'ogType' => $this->getType()? $this->getType() : null
        ];
    }
}
