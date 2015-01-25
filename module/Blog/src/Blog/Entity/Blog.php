<?php

namespace Blog\Entity;

use Application\Entity\AbstractEntity;
use Application\Entity\Exception\EntityException;
use Category\Entity\Category;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Reply\Entity\Reply;
use Status\Entity\Status;

/**
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="Blog\Entity\BlogRepository")
 * @ORM\Table(name="blog")
 */
class Blog extends AbstractEntity
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
     * @ORM\Column(type="string", length=80)
     */
    protected $subtitle;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $lead;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $content;

    /**
     * @ORM\Column(type="string", length=80)
     */
    protected $author;

    /**
     * @ORM\Column(type="date")
     */
    protected $date;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    protected $slug;

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
     * @ORM\ManyToOne(targetEntity="Category\Entity\Category")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id", nullable=false)
     */
    protected $category;

    /**
     * @ORM\ManyToOne(targetEntity="Status\Entity\Status")
     * @ORM\JoinColumn(name="status_id", referencedColumnName="id", nullable=false)
     */
    protected $status;

    /**
     * @ORM\OneToMany(targetEntity="Reply\Entity\Reply", mappedBy="blog", cascade={"all"})
     * @ORM\JoinColumn(name="id", referencedColumnName="blog_id", nullable=false)
     */
    protected $reply;

    /**
     * Init object.
     */
    public function __construct()
    {
        $this->status   = new Status();
        $this->category = new Category();
        $this->reply    = new ArrayCollection();
        $this->date     = new \DateTime();
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
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param Category $category
     * @throws \Application\Entity\Exception\EntityException
     */
    public function setCategory($category)
    {
        if (!$category instanceof Category) {
            throw new EntityException('Invalid object!');
        }

        $this->category = $category;
    }

    /**
     * @return Category
     */
    public function getCategory()
    {
        return $this->category;
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
     * @param string $date
     */
    public function setDate($date)
    {
        $this->date = new \DateTime($date);
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return (int) $this->id;
    }

    /**
     * @param string $lead
     */
    public function setLead($lead)
    {
        $this->lead = $lead;
    }

    /**
     * @return string
     */
    public function getLead()
    {
        return $this->lead;
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
     * @param string $subtitle
     */
    public function setSubtitle($subtitle)
    {
        $this->subtitle = $subtitle;
    }

    /**
     * @return string
     */
    public function getSubtitle()
    {
        return $this->subtitle;
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
     * @param Reply $reply
     * @throws \Application\Entity\Exception\EntityException
     */
    public function setReply($reply)
    {
        if (!$reply instanceof Reply) {
            throw new EntityException('Invalid object!');
        }

        $this->reply = $reply;
    }

    /**
     * @return Reply
     */
    public function getReply()
    {
        return $this->reply;
    }

}