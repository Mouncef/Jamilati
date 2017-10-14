<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Grafikart\UploadBundle\Annotation\Uploadable;
use Grafikart\UploadBundle\Annotation\UploadableField;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Sondage
 *
 * @ORM\Table(name="sondage")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SondageRepository")
 * @Uploadable()
 */
class Sondage
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
     * @ORM\Column(name="lib", type="string", length=255)
     */
    private $lib;

    /**
     * @var string
     * @ORM\Column(name="filename1", type="string", length=255)
     */
    private $filename1;

    /**
     * @var integer
     * @ORM\Column(name="nbvotes1", type="integer")
     */
    private $nbvotes1 = 0;

    /**
     * @var integer
     * @ORM\Column(name="nbvotes2", type="integer")
     */
    private $nbvotes2 = 0;

    /**
     * @UploadableField(filename="filename1", path="uploads/Sondage/Images/Image1")
     * @Assert\Image(maxWidth="2000", maxHeight="2000")
     */
    private $image1;

    /**
     * @var string
     * @ORM\Column(name="filename2", type="string", length=255)
     */
    private $filename2;

    /**
     * @UploadableField(filename="filename2", path="uploads/Sondage/Images/Image2")
     * @Assert\Image(maxWidth="2000", maxHeight="2000")
     */
    private $image2;

    /**
     * @var \DateTime
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @var \DateTime
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_published", type="boolean")
     */
    private $isPublished = false;



    public function increaseNbVotes1(){
        $this->nbvotes1++;
    }

    public function increaseNbVotes2(){
        $this->nbvotes2++;
    }

    public function decreaseNbVotes1(){
        $this->nbvotes1--;
    }

    public function decreaseNbVotes2(){
        $this->nbvotes2--;
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
     * @return Sondage
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

    /**
     * @return string
     */
    public function getFilename1()
    {
        return $this->filename1;
    }

    /**
     * @param string $filename1
     */
    public function setFilename1($filename1)
    {
        $this->filename1 = $filename1;
    }

    /**
     * @return File/null
     */
    public function getImage1()
    {
        return $this->image1;
    }

    /**
     * @param File $image1/null
     */
    public function setImage1($image1)
    {
        $this->image1 = $image1;
    }

    /**
     * @return string
     */
    public function getFilename2()
    {
        return $this->filename2;
    }

    /**
     * @param string $filename2
     */
    public function setFilename2($filename2)
    {
        $this->filename2 = $filename2;
    }

    /**
     * @return File/null
     */
    public function getImage2()
    {
        return $this->image2;
    }

    /**
     * @param File $image2/null
     */
    public function setImage2($image2)
    {
        $this->image2 = $image2;
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
     * @return mixed
     */
    public function getNbvotes1()
    {
        return $this->nbvotes1;
    }

    /**
     * @param mixed $nbvotes1
     */
    public function setNbvotes1($nbvotes1)
    {
        $this->nbvotes1 = $nbvotes1;
    }

    /**
     * @return int
     */
    public function getNbvotes2()
    {
        return $this->nbvotes2;
    }

    /**
     * @param int $nbvotes2
     */
    public function setNbvotes2($nbvotes2)
    {
        $this->nbvotes2 = $nbvotes2;
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
}

