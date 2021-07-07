<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Column;

//exercice:
//créez une table article avec ces colonnes : id, title, content, createdAt


//J'utilise une classe du VENDOR '@ORM' afin de créer une entité du nom de la classe
/**
 * @ORM\Entity()
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
     * @Column(type="string", length=32)
     */
    private $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $content;

    /**
     * @ORM\Column(type="datetime")
     */
    private  $createdAt;

    /**
     * @return mixed
     */

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
