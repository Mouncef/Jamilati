<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Articlevideo
 *
 * @ORM\Table(name="video")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\VideoRepository")
 */
class Articlevideo
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
     * @ORM\Column(name="titre", type="string", length=255)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255)
     */
    private $url;

    /**
     * @var string
     *
     * @ORM\Column(name="user", type="string", length=255)
     */
    private $user;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="content1", type="text")
     */
    private $content1;

    /**
     * @var string
     *
     * @ORM\Column(name="content2", type="text", nullable=true)
     */
    private $content2;

    /**
     * @var string
     *
     * @ORM\Column(name="content3", type="text", nullable=true)
     */
    private $content3;

    /**
     * @var string
     *
     * @ORM\Column(name="listtitre1", type="string", length=255, nullable=true)
     */
    private $listtitre1;

    /**
     * @var string
     *
     * @ORM\Column(name="listcontent1", type="string", length=255, nullable=true)
     */
    private $listcontent1;

    /**
     * @var string
     *
     * @ORM\Column(name="listtitre2", type="string", length=255, nullable=true)
     */
    private $listtitre2;

    /**
     * @var string
     *
     * @ORM\Column(name="listcontent2", type="string", length=255, nullable=true)
     */
    private $listcontent2;

    /**
     * @var string
     *
     * @ORM\Column(name="listtitre3", type="string", length=255, nullable=true)
     */
    private $listtitre3;

    /**
     * @var string
     *
     * @ORM\Column(name="listcontent3", type="string", length=255, nullable=true)
     */
    private $listcontent3;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_published", type="boolean")
     */
    private $isPublished = false;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\CatVideo", inversedBy="articlevideos")
     * @ORM\JoinColumn(name="catvideo_id", referencedColumnName="id")
     */
    private $catvideo;

    /**
     * @var integer
     * @ORM\Column(name="views", type="integer")
     */
    private $views = 0;

    public function increaseViews(){
        $this->views++;
    }

    public function decreaseViews(){
        $this->views--;
    }

    /**
     * @return mixed
     */
    public function getViews()
    {
        return $this->views;
    }

    /**
     * @param mixed $views
     */
    public function setViews($views)
    {
        $this->views = $views;
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
     * Set titre
     *
     * @param string $titre
     *
     * @return Articlevideo
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set url
     *
     * @param string $url
     *
     * @return Articlevideo
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set user
     *
     * @param string $user
     *
     * @return Articlevideo
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return string
     */
    public function getUser()
    {
        return $this->user;
    }


    /**
     * @return mixed
     */
    public function getCatvideo()
    {
        return $this->catvideo;
    }

    /**
     * @param CatVideo $catvideo
     */
    public function setCatvideo($catvideo)
    {
        $this->catvideo = $catvideo;
    }

    /**
     * @return bool
     */
    public function isIsPublished()
    {
        return $this->isPublished;
    }

    /**
     * @param bool $isPublished
     */
    public function setIsPublished($isPublished)
    {
        $this->isPublished = $isPublished;
    }

    /**
     * @return string
     */
    public function getListcontent3()
    {
        return $this->listcontent3;
    }

    /**
     * @param string $listcontent3
     */
    public function setListcontent3($listcontent3)
    {
        $this->listcontent3 = $listcontent3;
    }

    /**
     * @return string
     */
    public function getListtitre3()
    {
        return $this->listtitre3;
    }

    /**
     * @param string $listtitre3
     */
    public function setListtitre3($listtitre3)
    {
        $this->listtitre3 = $listtitre3;
    }

    /**
     * @return string
     */
    public function getListcontent2()
    {
        return $this->listcontent2;
    }

    /**
     * @param string $listcontent2
     */
    public function setListcontent2($listcontent2)
    {
        $this->listcontent2 = $listcontent2;
    }

    /**
     * @return string
     */
    public function getListtitre2()
    {
        return $this->listtitre2;
    }

    /**
     * @param string $listtitre2
     */
    public function setListtitre2($listtitre2)
    {
        $this->listtitre2 = $listtitre2;
    }

    /**
     * @return string
     */
    public function getListcontent1()
    {
        return $this->listcontent1;
    }

    /**
     * @param string $listcontent1
     */
    public function setListcontent1($listcontent1)
    {
        $this->listcontent1 = $listcontent1;
    }

    /**
     * @return string
     */
    public function getListtitre1()
    {
        return $this->listtitre1;
    }

    /**
     * @param string $listtitre1
     */
    public function setListtitre1($listtitre1)
    {
        $this->listtitre1 = $listtitre1;
    }

    /**
     * @return string
     */
    public function getContent3()
    {
        return $this->content3;
    }

    /**
     * @param string $content3
     */
    public function setContent3($content3)
    {
        $this->content3 = $content3;
    }

    /**
     * @return string
     */
    public function getContent2()
    {
        return $this->content2;
    }

    /**
     * @param string $content2
     */
    public function setContent2($content2)
    {
        $this->content2 = $content2;
    }

    /**
     * @return string
     */
    public function getContent1()
    {
        return $this->content1;
    }

    /**
     * @param string $content1
     */
    public function setContent1($content1)
    {
        $this->content1 = $content1;
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }
}

