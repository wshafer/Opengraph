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
 * @ORM\Table(name="rcm_page_open_graph_website")
 */
class OpenGraphWebsite
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
     * @var string Website Title
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $title;

    /**
     * @var string Website Image
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $image;

    /**
     * @var string Website Description
     *
     * @ORM\Column(type="text", nullable=true)
     */
    protected $description;

    /**
     * @var string Website Name
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $siteName;

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
    
    public function toArray()
    {
        return [
            'title' => $this->getTitle(),
            'image' => $this->getImage(),
            'description' => $this->getDescription(),
            'siteName' => $this->getSiteName()
        ];
    }
}
