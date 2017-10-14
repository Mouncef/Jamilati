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
 * CatNews
 *
 * @ORM\Table(name="cat_news")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CatNewsRepository")
 */
class CatNews
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
     * @ORM\OneToMany(targetEntity="Articlenews", mappedBy="catnews")
     */
    private $articlenewss;

    public function __construct()
    {
        $this->articlenewss = new ArrayCollection();
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
     * @return CatNews
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