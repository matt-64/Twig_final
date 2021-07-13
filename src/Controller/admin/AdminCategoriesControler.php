<?php


namespace App\Controller\admin;

use App\Entity\categorie;
use App\Entity\Tag;
use App\Repository\ArticleRepository;
use App\Repository\categorieRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;


class AdminCategoriesControler extends AbstractController
{
    /**
     * @Route ("/admin/categories", name="categorieList")
     */
   public function categorieList(CategoryRepository $categoryRepository){

       $categories = $categoryRepository->findAll();

       return $this->render("admin/admin_Categories_List.html.twig", ['categories' => $categories]);
   }
//------------------------------------------------------------------------
    //Je créer ma 'Route'
    /**
     * @Route("/admin/categorie/{id}", name="categorieShow")
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

        return $this->render("admin/admin_Show_CategorieId.html.twig", ['categorie' => $categorie]);
    }

    /**
     * @Route("/admin/categories/update/{id}", name="admin_categorie_update")
     */
    public function updateCategorie($id, CategoryRepository $categorieRepository, EntityManagerInterface $entityManager)
    {
        //Je fais une querie by 'id' que je stock dans ma variable $categorie
        $categorie = $categorieRepository->find($id);

        // j'utilise les setters de l'entité categorie pour renseigner les valeurs des colonnes
        $categorie->setTitle('Nouvelle categorie');

        //un persist pour une pré-sauvegarde
        $entityManager->persist($categorie);
        //un flush pour l'envoi en bdd
        $entityManager->flush();

        return $this->redirectToRoute('categorieList');
    }

    /**
     * @Route("/admin/categories/delete/{id}", name="admin_article_Delete")
     */
    public function deleteArticle($id, CategoryRepository $categoryRepository, EntityManagerInterface $entityManager)
    {
        $categorie = $categoryRepository->find($id);

        //une methode de la classe entityManager 'remove' qui prend la place de persist pour supprimer l'article en bdd
        $entityManager->remove($categorie);
        $entityManager->flush();

        return $this->redirectToRoute('categorieList');
    }

}