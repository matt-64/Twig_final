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
     * @ORM\Column(type="string", nullable=true)
     */
    private $content;

    /**
     * @ORM\Column(type="datetime")
     */
    private  $createdAt;

}
