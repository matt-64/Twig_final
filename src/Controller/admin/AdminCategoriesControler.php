<?php


namespace App\Controller\admin;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;


class AdminCategoriesControler extends AbstractController
{
    /**
     * @Route ("/admin/categories", name="categorieList")
     */
    public function categorieList(CategoryRepository $categoryRepository)
    {

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
    public function categorieShow($id, CategoryRepository $categoryRepository)
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
    public function updateCategorie($id, CategoryRepository $categorieRepository, EntityManagerInterface $entityManager, Request $request)
    {
        //Je fais une querie by 'id' que je stock dans ma variable $categorie
        $categorie = $categorieRepository->find($id);

        // j'utilise les setters de l'entité categorie pour renseigner les valeurs des colonnes
//        méthode hardcode----->    $categorie->setTitle('Gaming');

        $categoryForm = $this->createForm(CategoryType::class, $categorie);
        $categoryForm->handleRequest($request);

        //un persist pour une pré-sauvegarde
        $entityManager->persist($categorie);
        //un flush pour l'envoi en bdd
        $entityManager->flush();

        if ($categoryForm->isSubmitted() && $categoryForm->isValid()) {
            $entityManager->persist($categorie);
            $entityManager->flush();

            return $this->redirectToRoute('categorieList');
        }
        return $this->render('admin/admin_category_insert.html.twig', [
            'categoryForm' => $categoryForm->createView()
        ]);


    }

    /**
     * @Route("/admin/categories/delete/{id}", name="admin_categorie_Delete")
     */
    public function deleteCategorie($id, CategoryRepository $categoryRepository, EntityManagerInterface $entityManager)
    {
        $categorie = $categoryRepository->find($id);

        //une methode de la classe entityManager 'remove' qui prend la place de persist pour supprimer la categorie en bdd
        $entityManager->remove($categorie);
        $entityManager->flush();

        return $this->redirectToRoute('categorieList');
    }

    /**
     * @Route("/admin/categories/insert", name="admin_categorie_insert")
     */
    public function insertCategorie(Request $request, EntityManagerInterface $entityManager)
    {
        $categorie = new Category();
        dump($categorie);
        //on génère le formulaire en utilisant le gabarit + une instance de l'entité Categorie
        $categoryForm = $this->createForm(CategoryType::class, $categorie);

        //On lie le formulaire aux données de POST(aux données envoyées au post)
        $categoryForm->handleRequest($request);


        //Si le formulaire est bien rempli et bien valide (tous les champs complet) alors
        //j'utilise la méthode persit & flush de l'entityManager pour flush en Bd.
        if ($categoryForm->isSubmitted() && $categoryForm->isValid()) {
            $entityManager->persist($categorie);
            $entityManager->flush();
            //Je redirige vers la page categorie_list
            return $this->redirectToRoute('categorieList');
        }

        return $this->render('admin/admin_category_insert.html.twig', [
            'categoryForm' => $categoryForm->createView()
            //clef => variable
        ]);
    }
}