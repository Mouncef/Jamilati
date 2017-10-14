<?php
/**
 * Created by PhpStorm.
 * User: Mouncef
 * Date: 25/06/2017
 * Time: 16:52
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * CatStars
 *
 * @ORM\Table(name="cat_stars")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CatStarsRepository")
 */
class CatStars
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
     * @ORM\OneToMany(targetEntity="Articlestars", mappedBy="catstars")
     */
    private $articlestarss;

    public function __construct()
    {
        $this->articlestarss = new ArrayCollection();
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
     * @return CatStars
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