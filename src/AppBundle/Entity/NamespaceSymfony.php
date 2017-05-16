<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class NamespaceSymfony {

    /**
     * @ORM\Column(name="id", type="integer")
     *
     * @ORM\Id
     *
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="name", type="text")
     */
    private $name;

    /**
     * @ORM\Column(name="url", type="text")
     */
    private $url;

    /**
     *  @ORM\OneToMany(targetEntity="InterfaceSymfony", mappedBy="namespace")
     */
    private $interfaces;

    /**
     * @ORM\ManyToOne(targetEntity="NamespaceSymfony", inversedBy="child")
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity="NamespaceSymfony", mappedBy="parent")
     */
    private $child;

    /**
     * @return mixed
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param mixed $parent
     */
    public function setParent($parent)
    {
        $this->parent = $parent;
    }

    /**
     * @return mixed
     */
    public function getChild()
    {
        return $this->child;
    }

    /**
     * @param mixed $child
     */
    public function setChild($child)
    {
        $this->child = $child;
    }

    /**
     * @ORM\OneToMany(targetEntity="ClassSymfony", mappedBy="namespace")
     */
    private $classes;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param mixed $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return mixed
     */
    public function getInterface()
    {
        return $this->interfaces;
    }

    /**
     * @param mixed $interface
     */
    public function setInterface($interface)
    {
        $this->interfaces = $interface;
    }

    /**
     * @return mixed
     */
    public function getClass()
    {
        return $this->classes;
    }

    /**
     * @param mixed $class
     */
    public function setClass($class)
    {
        $this->classes = $class;
    }

}