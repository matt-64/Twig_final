<?php


namespace App\Controller;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class CategoriesControler extends AbstractController
{
    /**
     * @Route ("/categories", name="categorieList")
     */
   public function categorieList(CategoryRepository $categoryRepository){

       $categories = $categoryRepository->findAll();

       return $this->render("CategorieList.html.twig", ['categories' => $categories]);
   }
//------------------------------------------------------------------------
    //Je créer ma 'Route'
    /**
     * @Route("/categorie/{id}", name="categorieShow")
     */
    // j'utilise le système 'wildcard' de symfony pour declarer une url avec une variable'$id'
    //je passe en param de methode le nom de ma variable '$id'
    public function categorieShow($id, CategoryRepository $categoryRepository )
    {

        $categorie = $categoryRepository->find($id);

        return $this->render("ShowCategorieId.html.twig", ['categorie' => $categorie]);

    }
}