<?php

namespace Blog\Entity;

use Application\Entity\AbstractEntity;
use Application\Entity\Exception\EntityException;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="Blog\Entity\BlogRepository")
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
     * @ORM\Column(type="date")
     */
    protected $timestamp;

    /**
     * @ORM\ManyToOne(targetEntity="Blog\Entity\Blog", inversedBy="reply", cascade={"all"})
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
     * @return DateTime
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

}