<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class CategoriesControler extends AbstractController
{
    private $categories = [
        1 => [
            "title" => "Politique",
            "content" => "Tous les articles liés à Jean Lassalle",
            "id" => 1,
            "published" => true,
        ],
        2 => [
            "title" => "Economie",
            "content" => "Les meilleurs tuyaux pour avoir DU FRIC",
            "id" => 2,
            "published" => true
        ],
        3 => [
            "title" => "Securité",
            "content" => "Attention les étrangers sont très méchants",
            "id" => 3,
            "published" => true
        ],
        4 => [
            "title" => "Ecologie",
            "content" => "Hummer <3",
            "id" => 4,
            "published" => true
        ]
    ];
    /**
     * @Route("/categorie", name="categorieList")
     */
    public function categorieList()
    {
        return $this->render('templatesCategories.html.twig', ['categories' => $this->categories ]);
    }
//------------------------------------------------------------------------
    //Je créer ma 'Route'
    /**
     * @Route("/categorie/{id}", name="categorieShow")
     */
    // j'utilise le système 'wildcard' de symfony pour declarer une url avec une variable'$id'
    //je passe en param de methode le nom de ma variable '$id'
    public function categorieShow($id)
    {

        if (array_key_exists($id, $this->categories))
        {
            //je stock dans une variable, l'élément 'id' de mon tableau 'categories'
            $categorieId = $this->categories[$id];

            //Je rappel via le render et son 2ème paramètre, la variable 'categorieId'
            return $this->render('ShowCategorieId.html.twig', ['categories' => $categorieId ]);

        }

    }
}