<?php

namespace Reply\Entity;

use Application\Entity\AbstractEntity;
use Application\Entity\Exception\EntityException;
use Blog\Entity\Blog;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="Reply\Entity\ReplyRepository")
 * @ORM\Table(name="reply")
 */
class Reply extends AbstractEntity
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
    protected $name;

    /**
     * @ORM\Column(type="text")
     */
    protected $comment;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $timestamp;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $is_admin = 0;

    /**
     * @ORM\Column(type="integer")
     */
    protected $blog_id;

    /**
     * @ORM\ManyToOne(targetEntity="Blog\Entity\Blog", inversedBy="reply", cascade={"persist", "merge", "detach"})
     * @ORM\JoinColumn(name="blog_id", referencedColumnName="id", nullable=false)
     */
    protected $blog;

    /**
     * Init object.
     */
    public function __construct()
    {
        $this->blog      = new Blog();
        $this->timestamp = new \DateTime();
    }

    /**
     * @param Blog $blog
     * @throws \Application\Entity\Exception\EntityException
     */
    public function setBlog($blog)
    {
        if (!$blog instanceof Blog) {
            throw new EntityException('Invalid object!');
        }

        $this->blog = $blog;
    }

    /**
     * @return Blog
     */
    public function getBlog()
    {
        return $this->blog;
    }

    /**
     * @param string $comment
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
    }

    /**
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $timestamp
     */
    public function setTimestamp($timestamp)
    {
        $this->timestamp = new \DateTime($timestamp);
    }

    /**
     * @return \DateTime
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * @param bool $is_admin
     */
    public function setIsAdmin($is_admin)
    {
        $this->is_admin = (bool) $is_admin;
    }

    /**
     * @return bool
     */
    public function getIsAdmin()
    {
        return $this->is_admin;
    }

    /**
     * @param int $blog_id
     */
    public function setBlogId($blog_id)
    {
        $this->blog_id = (int) $blog_id;
    }

    /**
     * @return int
     */
    public function getBlogId()
    {
        return (int) $this->blog_id;
    }

}