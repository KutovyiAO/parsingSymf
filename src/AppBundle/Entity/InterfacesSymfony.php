<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM Entity
 */
class InterfacesSymfony {

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





}