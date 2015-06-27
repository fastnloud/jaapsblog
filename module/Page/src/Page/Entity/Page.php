<?php

namespace Page\Entity;

use Application\Entity\AbstractEntity;
use Application\Entity\Exception\EntityException;
use Doctrine\ORM\Mapping as ORM;
use Route\Entity\Route;
use Site\Entity\Site;
use Status\Entity\Status;

/**
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="Page\Entity\PageRepository")
 * @ORM\Table(name="page", uniqueConstraints={@ORM\UniqueConstraint(name="slug", columns={"slug", "site_id"})})
 */
class Page extends AbstractEntity
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=80)
     */
    protected $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $content;

    /**
     * @ORM\Column(type="string", length=80)
     */
    protected $label;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $slug;

    /**
     * @ORM\Column(type="integer")
     */
    protected $priority = 0;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $is_visible = 0;

    /**
     * @ORM\Column(type="string", nullable=true, length=80)
     */
    protected $meta_title;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $meta_description;

    /**
     * @ORM\Column(type="string", nullable=true, length=255)
     */
    protected $meta_keywords;

    /**
     * @ORM\Column(type="integer")
     */
    protected $site_id;

    /**
     * @ORM\ManyToOne(targetEntity="Status\Entity\Status")
     * @ORM\JoinColumn(name="status_id", referencedColumnName="id", nullable=false)
     */
    protected $status;

    /**
     * @ORM\ManyToOne(targetEntity="Route\Entity\Route")
     * @ORM\JoinColumn(name="route_id", referencedColumnName="id", nullable=false)
     */
    protected $route;

    /**
     * @ORM\ManyToOne(targetEntity="Site\Entity\Site", inversedBy="page")
     * @ORM\JoinColumn(name="site_id", referencedColumnName="id", nullable=false)
     */
    protected $site;

    /**
     * Init default values.
     */
    public function __construct()
    {
        $this->status = new Status();
        $this->site   = new Site();
        $this->route  = new Route();
    }

    /**
     * @param string $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return (int) $this->id;
    }

    /**
     * @param string $label
     */
    public function setLabel($label)
    {
        $this->label = $label;
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param string $meta_description
     */
    public function setMetaDescription($meta_description)
    {
        $this->meta_description = $meta_description;
    }

    /**
     * @return string
     */
    public function getMetaDescription()
    {
        return $this->meta_description;
    }

    /**
     * @param string $meta_keywords
     */
    public function setMetaKeywords($meta_keywords)
    {
        $this->meta_keywords = $meta_keywords;
    }

    /**
     * @return string
     */
    public function getMetaKeywords()
    {
        return $this->meta_keywords;
    }

    /**
     * @param string $meta_title
     */
    public function setMetaTitle($meta_title)
    {
        $this->meta_title = $meta_title;
    }

    /**
     * @return string
     */
    public function getMetaTitle()
    {
        return $this->meta_title;
    }

    /**
     * @param int $site_id
     */
    public function setSiteId($site_id)
    {
        $this->site_id = (int) $site_id;
    }

    /**
     * @return int
     */
    public function getSiteId()
    {
        return (int) $this->site_id;
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
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param Status $status
     * @throws \Application\Entity\Exception\EntityException
     */
    public function setStatus($status)
    {
        if (!$status instanceof Status) {
            throw new EntityException('Invalid object!');
        }

        $this->status = $status;
    }

    /**
     * @return Status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param Site $site
     * @throws \Application\Entity\Exception\EntityException
     */
    public function setSite($site)
    {
        if (!$site instanceof Site) {
            throw new EntityException('Invalid object!');
        }

        $this->site = $site;
    }

    /**
     * @return Site
     */
    public function getSite()
    {
        return $this->site;
    }

    /**
     * @param Route $route
     * @throws \Application\Entity\Exception\EntityException
     */
    public function setRoute($route)
    {
        if (!$route instanceof Route) {
            throw new EntityException('Invalid object!');
        }

        $this->route = $route;
    }

    /**
     * @return Route
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * @param int $priority
     */
    public function setPriority($priority)
    {
        $this->priority = (int) $priority;
    }

    /**
     * @return int
     */
    public function getPriority()
    {
        return (int) $this->priority;
    }

    /**
     * @param int $is_visible
     */
    public function setIsVisible($is_visible)
    {
        $this->is_visible = (int) $is_visible;
    }

    /**
     * @return int
     */
    public function getIsVisible()
    {
        return (int) $this->is_visible;
    }

}