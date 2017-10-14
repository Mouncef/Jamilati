<?php
/**
 * Created by PhpStorm.
 * User: Mouncef
 * Date: 25/06/2017
 * Time: 16:55
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Grafikart\UploadBundle\Annotation\Uploadable;
use Grafikart\UploadBundle\Annotation\UploadableField;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Articlefamily
 *
 * @ORM\Table(name="articlenews")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ArticlenewsRepository")
 * @Uploadable()
 */
class Articlenews
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\CatNews", inversedBy="articlenewss")
     * @ORM\JoinColumn(name="catnews_id", referencedColumnName="id")
     */
    private $catnews;

    /**
     * @var string
     * @ORM\Column(name="filename", type="string", length=255)
     */
    private $filename;

    /**
     * @UploadableField(filename="filename", path="uploads/News/Cover")
     * @Assert\Image(maxWidth="2000", maxHeight="2000")
     */
    private $cover;

    /**
     * @var \DateTime
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;

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
     * @return Articlenews
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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Articlenews
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set content1
     *
     * @param string $content1
     *
     * @return Articlenews
     */
    public function setContent1($content1)
    {
        $this->content1 = $content1;

        return $this;
    }

    /**
     * Get content1
     *
     * @return string
     */
    public function getContent1()
    {
        return $this->content1;
    }


    /**
     * Set catbeauty
     *
     * @param \AppBundle\Entity\CatNews $catnews
     *
     * @return Articlenews
     */
    public function setCatNews(CatNews $catnews = null)
    {
        $this->catnews = $catnews;

        return $this;
    }

    /**
     * Get catnews
     *
     * @return \AppBundle\Entity\CatNews
     */
    public function getCatNews()
    {
        return $this->catnews;
    }

    /**
     * @return string
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * @param string $filename
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;
    }

    /**
     * @return File/null
     */
    public function getCover()
    {
        return $this->cover;
    }

    /**
     * @param File $cover/null
     */
    public function setCover($cover)
    {
        $this->cover = $cover;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return string
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param string $user
     */
    public function setUser($user)
    {
        $this->user = $user;
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
}