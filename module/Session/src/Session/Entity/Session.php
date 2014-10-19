<?php

namespace Session\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="Session\Entity\SessionRepository")
 * @ORM\Table(name="session")
 */
class Session
{

    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=32, options={"fixed"=true})
     */
    protected $id;

    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=32, options={"fixed"=true})
     */
    protected $name;

    /**
     * @ORM\Column(type="integer")
     */
    protected $modified;

    /**
     * @ORM\Column(type="integer")
     */
    protected $lifetime;

    /**
     * @ORM\Column(type="text")
     */
    protected $data;

    /**
     * @param string $data
     */
    public function setData($data)
    {
        $this->data = (string) $data;
    }

    /**
     * @return string
     */
    public function getData()
    {
        return (string) $this->data;
    }

    /**
     * @param string $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $lifetime
     */
    public function setLifetime($lifetime)
    {
        $this->lifetime = (int) $lifetime;
    }

    /**
     * @return int
     */
    public function getLifetime()
    {
        return (int) $this->lifetime;
    }

    /**
     * @param int $modified
     */
    public function setModified($modified)
    {
        $this->modified = (int) $modified;
    }

    /**
     * @return int
     */
    public function getModified()
    {
        return (int) $this->modified;
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

}