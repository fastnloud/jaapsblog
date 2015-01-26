<?php

namespace Footer\Entity;

use Application\Entity\AbstractEntity;
use Application\Entity\Exception\EntityException;
use Doctrine\ORM\Mapping as ORM;
use Site\Entity\Site;
use Status\Entity\Status;

/**
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="Footer\Entity\FooterRepository")
 * @ORM\Table(name="footer")
 */
class Footer extends AbstractEntity
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
    protected $label;

    /**
     * @ORM\Column(type="string")
     */
    protected $href;

    /**
     * @ORM\Column(type="integer")
     */
    protected $site_id;

    /**
     * @ORM\Column(type="integer")
     */
    protected $priority;

    /**
     * @ORM\Column(type="integer")
     */
    protected $footer_column;

    /**
     * @ORM\ManyToOne(targetEntity="Status\Entity\Status")
     * @ORM\JoinColumn(name="status_id", referencedColumnName="id", nullable=false)
     */
    protected $status;

    /**
     * @ORM\ManyToOne(targetEntity="Site\Entity\Site", inversedBy="footer", cascade={"persist", "merge", "detach"})
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
     * @param int $footer_column
     */
    public function setFooterColumn($footer_column)
    {
        $this->footer_column = (int) $footer_column;
    }

    /**
     * @return int
     */
    public function getFooterColumn()
    {
        return (int) $this->footer_column;
    }

    /**
     * @param string $href
     */
    public function setHref($href)
    {
        $this->href = $href;
    }

    /**
     * @return string
     */
    public function getHref()
    {
        return $this->href;
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

}