<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var Classifields[]\ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Classifields", mappedBy="owner")
     * @ORM\JoinColumn(name="owner_id", referencedColumnName="id")
     */
    private $classifields;

    /**
     * User constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->classifields = new ArrayCollection();
    }

    /**
     * @return Classifields[]\ArrayCollection
     */
    public function getClassifields()
    {
        return $this->classifields;
    }

    /**
     * @param Classifields $classifields
     * @return $this
     */
    public function addClassifields(Classifields $classifields)
    {
        $this->classifields[] = $classifields;

        return $this;
    }
}