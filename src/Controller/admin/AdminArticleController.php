<?php


namespace App\Controller\admin;

use App\Entity\Article;
use App\Entity\Tag;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminArticleController extends AbstractController
{
    /**
     * @Route("/admin/articles/insert", name="admin_article_insert")
     */
    public function insertArticle(Request $request, EntityManagerInterface $entityManager)
    {
        $article = new Article();

        //on génère le formulaire en utilisant le gabarit + une instance de l'entité Article
        $articleForm = $this->createForm(ArticleType::class, $article);

        //On lie le formulaire aux données de POST(aux données envoyées au post)
        $articleForm->handleRequest($request);


        //Si le formulaire est bien rempli et bien valide (tous les champs complet) alors
        //j'utilise la méthode persit & flush de l'entityManager pour flush en Bd.
        if ($articleForm->isSubmitted() && $articleForm->isValid()){
            $entityManager->persist($article);
            $entityManager->flush();
            $this->addFlash('success', 'Article Created! Votre article est bien crée!');
            //Je redirige vers la page article_list
            return $this->redirectToRoute('admin_article_List');

        }

        return $this->render('admin/admin_insert.html.twig', [
            'articleForm' => $articleForm->createView()
            //clef => variable
        ]);
    }
    // Create-> (SQL)insert
//    /**
//     * @Route("/admin/articles/static", name="admin_article_Insert")
//     */
//    public function  insertArtile(EntityManagerInterface $entityManager, CategoryRepository $categoryRepository)
//    {
//
//        // J'utilise l'entité Article, pour créer un nouvel article en bdd
//        // une instance de l'entité Article = un enregistrement d'article en bdd
//        $article = new Article();
//
//        // j'utilise les setters de l'entité Article pour renseigner les valeurs des colonnes
//        $article->setTitle('Tire article depuis controleur');
//        $article->setContent('blablabnkzd');
//        $article->setIsPublished(true);
//        $article->setCreatedAt(new \DateTime('NOW'));
//
//        //je recupère la catégorie dont l'id =1
//        //doctrine me créé une insctance de l'entité category avec les infos de category en bdd
//        $category = $categoryRepository->find(1);
//        $article->setCategory($category);
//
//        //creation d"un nouveau tag
//        $tag = new Tag();
//        //creation de son titre et de sa couleur
//        $tag->setTitle("info");
//        $tag->setColor("blue");
//
//        $entityManager->persist($tag);
//        $article->setTag($tag);
//
//
//        //je prends toutes les entités crées(ici une seule) et je les 'pré' sauvegarde
//        $entityManager->persist($article);
//
//        // je récupère toutes les entités pré-sauvegardées et je les insère en BDD
//        $entityManager->flush();
//
//        return $this->redirectToRoute('admin_article_List');
//    }
    //------------------------------------------------------------------------------------------------------------
    // Update
    /**
     * @Route("/admin/articles/update/{id}", name="admin_article_update")
     */
    public function updateArticle($id, ArticleRepository $articleRepository, EntityManagerInterface $entityManager, Request $request)
    {
        // pour l'insert : $article = new Article();
        $article = $articleRepository->find($id);

        // on génère le formulaire en utilisant le gabarit + une instance de l'entité Article
        $articleForm = $this->createForm(ArticleType::class, $article);

        // on lie le formulaire aux données de POST (aux données envoyées en POST)
        $articleForm->handleRequest($request);

        // si le formulaire a été posté et qu'il est valide (que tous les champs
        // obligatoires sont remplis correctement), alors on enregistre l'article
        // créé en bdd
        if ($articleForm->isSubmitted() && $articleForm->isValid()) {
            $entityManager->persist($article);
            $entityManager->flush();
            $this->addFlash('success', 'Congrats ! Votre article a bien été mis à jour!');

            return $this->redirectToRoute('admin_article_List');
        }

        return $this->render('admin/admin_insert.html.twig', [
            'articleForm' => $articleForm->createView()
        ]);
    }
//    /**
//     * @Route("/admin/articles/update/Static/{id}", name="admin_article_update")
//     */
//    public function updateArticle($id, ArticleRepository $articleRepository, EntityManagerInterface $entityManager)
//    {
//        //Je fais une querie by 'id' que je stock dans ma variable $article
//        $article = $articleRepository->find($id);
//
//        // j'utilise les setters de l'entité Article pour renseigner les valeurs des colonnes
//     Modification du title en 'dur'
//        $article->setTitle('call of duty');
//
//        //un persist pour une pré-sauvegarde
//        $entityManager->persist($article);
//        //un flush pour l'envoi en bdd
//        $entityManager->flush();
//
//        return $this->redirectToRoute('admin_article_List');
//
//    }
    //------------------------------------------------------------------------------------------------------------
    // Delete
    /**
     * @Route("/admin/articles/delete/{id}", name="admin_article_Delete")
     */
    public function deleteArticle($id, ArticleRepository $articleRepository, EntityManagerInterface $entityManager)
    {
        $article = $articleRepository->find($id);

        //une methode de la classe entityManager 'remove' qui prend la place de persist pour supprimer l'article en bdd
        $entityManager->remove($article);
        $entityManager->flush();

        $this->addFlash('success', 'Article Created! Votre article a bien été supprimé!');


        return $this->redirectToRoute('admin_article_List');
    }
    //------------------------------------------------------------------------------------------------------------
    // Read
    /**
     * @Route ("/admin/articles", name="admin_article_List")
     */
    public function articleList(ArticleRepository $articleRepository)
    {
        //je dois faire une requête SELECT en BDD sur la table article
        //La classe qui me permet de faire des requêtes SELECT est ArticleRepository
        //donc je dois instancier cette classe
        //pour ça, j'utilise l'autowire (je place la classe en argument du controleur)
        //suivi de la variable dans laquelle je veux que sf m'instancie la classe

        $articles = $articleRepository->findAll();

        return $this->render("admin/admin_article_list.html.twig", [
            'articles' => $articles
        ]);
    }


}