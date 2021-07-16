<?php


namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


//exercice:
//créez une table article avec ces colonnes : id, title, content, createdAt


//J'utilise une classe du VENDOR '@ORM' afin de créer une entité du nom de la classe
/**
 * @ORM\Entity(repositoryClass=ArticleRepository::class)
 */
class Article
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="integer",unique=true)
     * @ORM\GeneratedValue()
     */
    private $id;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message="Rempli le titre de l'article stp")
     */
    private $title;


    /**
     * @ORM\Column(type="text")
     * @Assert\Length(
     *     min=5,
     *     max=30,
     *     minMessage="Vous devez écrire plus de 5 caractères",
     *     maxMessage="Vous devez écrire moins de 30 caractères"
     * )
     */
    private $content;


    /**
     * @ORM\Column(type="datetime")
     */
    private  $createdAt;


    /**
     * @ORM\Column(type="boolean")
     *
     */
    private $isPublished;

    /**
     * @return mixed
     */
    public function getIsPublished()
    {
        return $this->isPublished;
    }
    /**
     * @param mixed $isPublished
     */
    public function setIsPublished($isPublished): void
    {
        $this->isPublished = $isPublished;
    }

    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="articles")
     */
    private $category;
    /**
     * @return mixed
     */
    public function getCategory()
    {
        return $this->category;
    }
    /**
     * @param mixed $category
     */
    public function setCategory($category): void
    {
        $this->category = $category;
    }

    /**
     * @ORM\ManyToOne(targetEntity="Tag", inversedBy="articles")
     */
    private $tag;

    /**
     * @return mixed
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * @param mixed $tag
     */
    public function setTag($tag): void
    {
        $this->tag = $tag;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }
    /**
     * @param mixed $title
     */
    public function setTitle($title): void
    {
        $this->title = $title;
    }


    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }
    /**
     * @param mixed $content
     */
    public function setContent($content): void
    {
        $this->content = $content;
    }


    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
    /**
     * @param mixed $createdAt
     */
    public function setCreatedAt($createdAt): void
    {
        $this->createdAt = $createdAt;
    }

}
