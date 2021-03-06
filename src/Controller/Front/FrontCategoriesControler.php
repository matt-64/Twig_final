<?php


namespace App\Controller\Front;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;


class FrontCategoriesControler extends AbstractController
{
    /**
     * @Route ("/categories", name="categorieList")
     */
   public function categorieList(CategoryRepository $categoryRepository){

       $categories = $categoryRepository->findAll();


       return $this->render("front/CategoriesList.html.twig", ['categories' => $categories]);
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

        // si 'categorie' n'a pas été trouvé, je renvoie une exception (erreur)
        // pour afficher une 404
        if (is_null($categorie)) {
            throw new NotFoundHttpException();
        }

        return $this->render("front/ShowCategorieId.html.twig", ['categorie' => $categorie]);

    }
}