<?php

namespace WShafer\OpenGraph\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Open Graph Image
 *
 * This object contains the data model for Open Graph Images
 *
 * @category  Reliv
 * @package   Rcm
 * @author    Westin Shafer <westin@havenly.com>
 * @copyright 2016 Reliv International
 * @license   License.txt New BSD License
 * @version   Release: 1.0
 * @link      http://github.com/reliv
 *
 * @ORM\Entity
 * @ORM\Table(name="rcm_page_open_graph_article")
 */
class OpenGraphArticle
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
     * @var string Article Title
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $title;

    /**
     * @var string Article Image
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $image;

    /**
     * @var string Article Description
     *
     * @ORM\Column(type="text", nullable=true)
     */
    protected $description;

    /**
     * @var string Article Name
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $siteName;

    /**
     * @var string Article Author Name
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $author;

    /**
     * @var string Article Section
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $section;

    /**
     * @var string Article Tags
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $tags;

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
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param string $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getSiteName()
    {
        return $this->siteName;
    }

    /**
     * @param string $siteName
     */
    public function setSiteName($siteName)
    {
        $this->siteName = $siteName;
    }

    /**
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param string $author
     */
    public function setAuthor($author)
    {
        $this->author = $author;
    }

    /**
     * @return string
     */
    public function getSection()
    {
        return $this->section;
    }

    /**
     * @param string $section
     */
    public function setSection($section)
    {
        $this->section = $section;
    }

    /**
     * @return string
     */
    public function getTags()
    {
        return explode(",", $this->tags);
    }

    /**
     * @param array $tags
     */
    public function setTags(array $tags)
    {
        $this->tags = implode(",", $tags);
    }
    
    public function addTag($tag)
    {
        $tags = $this->getTags();
        $tags[] = $tag;
        $this->setTags($tags);
    }
    
    public function toArray()
    {
        return [
            'title' => $this->getTitle(),
            'image' => $this->getImage(),
            'description' => $this->getDescription(),
            'siteName' => $this->getSiteName(),
            'author' => $this->getAuthor(),
            'section' => $this->getSection(),
            'tags' => $this->getTags()
        ];
    }
}
