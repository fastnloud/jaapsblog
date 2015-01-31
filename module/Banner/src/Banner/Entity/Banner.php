<?php

namespace Banner\Entity;

use Application\Entity\AbstractEntity;
use Application\Entity\Exception\EntityException;
use Doctrine\ORM\Mapping as ORM;
use Site\Entity\Site;
use Status\Entity\Status;

/**
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="Banner\Entity\BannerRepository")
 * @ORM\Table(name="banner")
 */
class Banner extends AbstractEntity
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
     * @ORM\Column(type="text")
     */
    protected $content;

    /**
     * @ORM\Column(type="integer")
     */
    protected $site_id;

    /**
     * @ORM\Column(type="integer")
     */
    protected $priority;

    /**
     * @ORM\ManyToOne(targetEntity="Status\Entity\Status")
     * @ORM\JoinColumn(name="status_id", referencedColumnName="id", nullable=false)
     */
    protected $status;

    /**
     * @ORM\ManyToOne(targetEntity="Site\Entity\Site", inversedBy="banner", cascade={"persist", "merge", "detach"})
     * @ORM\JoinColumn(name="site_id", referencedColumnName="id", nullable=false)
     */
    protected $site;

    /**
     * Init object.
     */
    public function __construct()
    {
        $this->site   = new Site();
        $this->status = new Status();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return (int) $this->id;
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

}