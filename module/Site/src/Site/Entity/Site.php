<?php

namespace Site\Entity;

use Application\Entity\AbstractEntity;
use Application\Entity\Exception\EntityException;
use Banner\Entity\Banner;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Footer\Entity\Footer;
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
     * @ORM\Column(type="text", nullable=true)
     */
    protected $css;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $google_analytics;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $facebook_url;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $linkedin_url;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $google_plus_url;

    /**
     * @ORM\Column(type="boolean", nullable=false)
     */
    protected $dkim = 0;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $dkim_domain;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $dkim_selector;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $dkim_headers;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $dkim_private_key;

    /**
     * @ORM\ManyToOne(targetEntity="Status\Entity\Status")
     * @ORM\JoinColumn(name="status_id", referencedColumnName="id", nullable=false)
     */
    protected $status;

    /**
     * @ORM\OneToMany(targetEntity="Banner\Entity\Banner", mappedBy="site", cascade={"all"})
     * @ORM\JoinColumn(name="id", referencedColumnName="site_id", nullable=false)
     * @ORM\OrderBy({"priority" = "ASC"})
     */
    protected $banner;

    /**
     * @ORM\OneToMany(targetEntity="Footer\Entity\Footer", mappedBy="site", cascade={"all"})
     * @ORM\JoinColumn(name="id", referencedColumnName="site_id", nullable=false)
     * @ORM\OrderBy({"footer_column" = "ASC", "priority" = "ASC"})
     */
    protected $footer;

    /**
     * @ORM\OneToMany(targetEntity="Page\Entity\Page", mappedBy="site", cascade={"all"})
     * @ORM\JoinColumn(name="id", referencedColumnName="site_id", nullable=false)
     */
    protected $page;

    /**
     * @ORM\OneToMany(targetEntity="Blog\Entity\Blog", mappedBy="site", cascade={"all"})
     * @ORM\JoinColumn(name="id", referencedColumnName="site_id", nullable=false)
     */
    protected $blog;

    /**
     * Init default values.
     */
    public function __construct()
    {
        $this->status = new Status();
        $this->banner = new ArrayCollection();
        $this->footer = new ArrayCollection();
        $this->page   = new ArrayCollection();
        $this->blog   = new ArrayCollection();
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
     * @return Banner
     */
    public function getBanner()
    {
        return $this->banner;
    }

    /**
     * @param Footer $footer
     * @throws \Application\Entity\Exception\EntityException
     */
    public function setFooter($footer)
    {
        if (!$footer instanceof Footer) {
            throw new EntityException('Invalid object!');
        }

        $this->footer = $footer;
    }

    /**
     * @return mixed
     */
    public function getFooter()
    {
        return $this->footer;
    }

    /**
     * @param string $css
     */
    public function setCss($css)
    {
        $this->css = $css;
    }

    /**
     * @return string
     */
    public function getCss()
    {
        return $this->css;
    }

    /**
     * @param string $facebook_url
     */
    public function setFacebookUrl($facebook_url)
    {
        $this->facebook_url = $facebook_url;
    }

    /**
     * @return string
     */
    public function getFacebookUrl()
    {
        return $this->facebook_url;
    }

    /**
     * @param string $google_analytics
     */
    public function setGoogleAnalytics($google_analytics)
    {
        $this->google_analytics = $google_analytics;
    }

    /**
     * @return string
     */
    public function getGoogleAnalytics()
    {
        return $this->google_analytics;
    }

    /**
     * @param string $google_plus_url
     */
    public function setGooglePlusUrl($google_plus_url)
    {
        $this->google_plus_url = $google_plus_url;
    }

    /**
     * @return string
     */
    public function getGooglePlusUrl()
    {
        return $this->google_plus_url;
    }

    /**
     * @param string $linkedin_url
     */
    public function setLinkedinUrl($linkedin_url)
    {
        $this->linkedin_url = $linkedin_url;
    }

    /**
     * @return string
     */
    public function getLinkedinUrl()
    {
        return $this->linkedin_url;
    }

    /**
     * @param bool $dkim
     */
    public function setDkim($dkim)
    {
        $this->dkim = (bool) $dkim;
    }

    /**
     * @return bool
     */
    public function getDkim()
    {
        return (bool) $this->dkim;
    }

    /**
     * @param string $dkim_domain
     */
    public function setDkimDomain($dkim_domain)
    {
        $this->dkim_domain = $dkim_domain;
    }

    /**
     * @return string
     */
    public function getDkimDomain()
    {
        return $this->dkim_domain;
    }

    /**
     * @param string $dkim_headers
     */
    public function setDkimHeaders($dkim_headers)
    {
        $this->dkim_headers = $dkim_headers;
    }

    /**
     * @return string
     */
    public function getDkimHeaders()
    {
        return $this->dkim_headers;
    }

    /**
     * @param string $dkim_private_key
     */
    public function setDkimPrivateKey($dkim_private_key)
    {
        $this->dkim_private_key = $dkim_private_key;
    }

    /**
     * @return string
     */
    public function getDkimPrivateKey()
    {
        return $this->dkim_private_key;
    }

    /**
     * @param string $dkim_selector
     */
    public function setDkimSelector($dkim_selector)
    {
        $this->dkim_selector = $dkim_selector;
    }

    /**
     * @return string
     */
    public function getDkimSelector()
    {
        return $this->dkim_selector;
    }

}