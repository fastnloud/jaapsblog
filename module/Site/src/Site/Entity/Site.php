<?php

namespace Site\Entity;

use Application\Entity\AbstractEntity;
use Application\Entity\Exception\EntityException;
use Banner\Entity\Banner;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Status\Entity\Status;

/**
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="Site\Entity\SiteRepository")
 * @ORM\Table(name="site")
 */
class Site extends AbstractEntity
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $title;

    /**
     * @ORM\Column(type="string")
     */
    protected $domain;

    /**
     * @ORM\Column(type="string")
     */
    protected $email;

    /**
     * @ORM\Column(name="google_analytics", type="text", nullable=true)
     */
    protected $googleAnalytics;

    /**
     * @ORM\ManyToOne(targetEntity="Status\Entity\Status")
     * @ORM\JoinColumn(name="status_id", referencedColumnName="id", nullable=false)
     */
    protected $status;

    /**
     * @ORM\OneToMany(targetEntity="Banner\Entity\Banner", mappedBy="site", cascade={"all"})
     * @ORM\JoinColumn(name="id", referencedColumnName="site_id", nullable=false)
     */
    protected $banner;

    /**
     * Init default values.
     */
    public function __construct()
    {
        $this->status = new Status();
        $this->banner = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return (int) $this->id;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $googleAnalytics
     */
    public function setGoogleAnalytics($googleAnalytics)
    {
        $this->googleAnalytics = $googleAnalytics;
    }

    /**
     * @return string
     */
    public function getGoogleAnalytics()
    {
        return $this->googleAnalytics;
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
     * @param string $domain
     */
    public function setDomain($domain)
    {
        $this->domain = $domain;
    }

    /**
     * @return string
     */
    public function getDomain()
    {
        return $this->domain;
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
     * @param Banner $banner
     * @throws \Application\Entity\Exception\EntityException
     */
    public function setBanner($banner)
    {
        if (!$banner instanceof Banner) {
            throw new EntityException('Invalid object!');
        }

        $this->banner = $banner;
    }

    /**
     * @return mixed
     */
    public function getBanner()
    {
        return $this->banner;
    }

}