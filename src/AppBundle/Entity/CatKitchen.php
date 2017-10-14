<?php
/**
 * Created by PhpStorm.
 * User: Mouncef
 * Date: 21/06/2017
 * Time: 17:59
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * CatKitchen
 *
 * @ORM\Table(name="cat_kitchen")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CatKitchenRepository")
 */
class CatKitchen
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
     * @ORM\OneToMany(targetEntity="Articlekitchen", mappedBy="catkitchen")
     */
    private $articlekitchens;

    public function __construct()
    {
        $this->articlekitchens = new ArrayCollection();
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
     * @return CatKitchen
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