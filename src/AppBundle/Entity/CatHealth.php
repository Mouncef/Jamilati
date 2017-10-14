<?php
/**
 * Created by PhpStorm.
 * User: Mouncef
 * Date: 22/06/2017
 * Time: 17:24
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * CatHealth
 *
 * @ORM\Table(name="cat_health")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CatHealthRepository")
 */
class CatHealth
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="lib", type="string", length=255, unique=true)
     */
    private $lib;

    /**
     * @ORM\OneToMany(targetEntity="Articlehealth", mappedBy="cathealth")
     */
    private $articlehealths;

    public function __construct()
    {
        $this->articlehealths = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set lib
     *
     * @param string $lib
     *
     * @return CatHealth
     */
    public function setLib($lib)
    {
        $this->lib = $lib;

        return $this;
    }

    /**
     * Get lib
     *
     * @return string
     */
    public function getLib()
    {
        return $this->lib;
    }

}