<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Image;
use AppBundle\Entity\Author;
use AppBundle\Entity\Comment;
use AppBundle\Entity\Tag;
use Doctrine\Common\Collections\arrayCollection;
/**
 * Article
 *
 * @ORM\Table(name="articles")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ArticleRepository")
 */
class Article
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
     * @ORM\Column(name="title", type="string", length=80, unique=true)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="lead", type="text")
     */
    private $lead;

    /**
     * @var string
     *
     * @ORM\Column(name="text", type="text")
     */
    private $text;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updatedAt", type="datetime", nullable=true)
     */
    private $updatedAt;
    
    /**
     *@ORM\OneToOne(targetEntity="Image")
     * @var Image 
     */
    private $image;
    /**
     *@ORM\ManyToOne(targetEntity="Author")
     * @ORM\JoinColumn(nullable=false)
     * @var Author
     */
    private $auteur;
    /**
     *@ORM\OneToMany(targetEntity="comment",mappedBy="article")
     * @var ArrayCollection
     */
      private $comments;
      /**
       *@ORM\ManyToMany(targetEntity="tag",inversedBy="articles")
       * @var ArrayCollection
       */
      private $tag;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Article
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set lead
     *
     * @param string $lead
     * @return Article
     */
    public function setLead($lead)
    {
        $this->lead = $lead;

        return $this;
    }

    /**
     * Get lead
     *
     * @return string 
     */
    public function getLead()
    {
        return $this->lead;
    }

    /**
     * Set text
     *
     * @param string $text
     * @return Article
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string 
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Article
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Article
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->tag = new ArrayCollection();
    }

    /**
     * Set image
     *
     * @param \AppBundle\Entity\Image $image
     * @return Article
     */
    public function setImage(\AppBundle\Entity\Image $image = null)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \AppBundle\Entity\Image 
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set auteur
     *
     * @param \AppBundle\Entity\Author $auteur
     * @return Article
     */
    public function setAuteur(\AppBundle\Entity\Author $auteur)
    {
        $this->auteur = $auteur;

        return $this;
    }

    /**
     * Get auteur
     *
     * @return \AppBundle\Entity\Author 
     */
    public function getAuteur()
    {
        return $this->auteur;
    }

    /**
     * Add comments
     *
     * @param \AppBundle\Entity\comment $comments
     * @return Article
     */
    public function addComment(\AppBundle\Entity\comment $comments)
    {
        $this->comments[] = $comments;

        return $this;
    }

    /**
     * Remove comments
     *
     * @param \AppBundle\Entity\comment $comments
     */
    public function removeComment(\AppBundle\Entity\comment $comments)
    {
        $this->comments->removeElement($comments);
    }

    /**
     * Get comments
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Add tag
     *
     * @param \AppBundle\Entity\tag $tag
     * @return Article
     */
    public function addTag(\AppBundle\Entity\tag $tag)
    {
        $this->tag[] = $tag;

        return $this;
    }

    /**
     * Remove tag
     *
     * @param \AppBundle\Entity\tag $tag
     */
    public function removeTag(\AppBundle\Entity\tag $tag)
    {
        $this->tag->removeElement($tag);
    }

    /**
     * Get tag
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTag()
    {
        return $this->tag;
    }
}
