<?php


namespace App\Controller;


use App\Entity\Article;
use App\Entity\Tag;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Id;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    /**
     * @Route("/articles/insert", name="articleInsert")
     */
    public function  insertArtile(EntityManagerInterface $entityManager, CategoryRepository $categoryRepository)
    {

        // J'utilise l'entité Article, pour créer un nouvel article en bdd
        // une instance de l'entité Article = un enregistrement d'article en bdd
        $article = new Article();

        // j'utilise les setters de l'entité Article pour renseigner les valeurs des colonnes
        $article->setTitle('Tire article depuis controleur');
        $article->setContent('blablabnkzd');
        $article->setIsPublished(true);
        $article->setCreatedAt(new \DateTime('NOW'));

        //je recupère la catégorie dont l'id =1
        //doctrine me créé une insctance de l'entité category avec les infos de category en bdd
        $category = $categoryRepository->find(1);
        $article->setCategory($category);


        //creation d"un nouveau tag
        $tag = new Tag();
        $tag->setTitle("info");
        $tag->setColor("blue");

        $entityManager->persist($tag);
        $article->setTag($tag);


        //je prends toutes les entités crées(ici une seule) et je les 'pré' sauvegarde
        //pré sauvegarde avant
        $entityManager->persist($article);

        // je récupère toutes les entités pré-sauvegardées et je les insère en BDD
        $entityManager->flush();

        return $this->redirectToRoute('articleList');
    }

    /**
     * @Route("/articles/update/{id}", name="update")
     */
    public function updateArticle($id, ArticleRepository $articleRepository, EntityManagerInterface $entityManager)
    {
        $article = $articleRepository->find($id);

        // j'utilise les setters de l'entité Article pour renseigner les valeurs des colonnes
        $article->setTitle('La regression');

        $entityManager->persist($article);
        $entityManager->flush();

        return $this->redirectToRoute('articleList');

    }

    /**
     * @Route ("/articles", name="articleList")
     */
    public function articleList(ArticleRepository $articleRepository)
    {
        //je dois faire une requête SELECT en BDD
        //sur la table article
        //La classe qui me permet de faire des requêtes SELECT est ArticleRepository
        //donc je dois instancier cette classe
        //popur ça, j'utilise l'autowire (je place la classe en argument du controleur)
        //suivi de la variable dans laquelle je veux que sf m'instancie la classe

        $articles = $articleRepository->findAll();

        return $this->render("ArticleList.html.twig", ['articles' => $articles]);

    }

    /**
     * @Route("/articles/{id}",name="articleShow")
     */
    public function articleShow($id, ArticleRepository  $articleRepository)
    {

       $article = $articleRepository->find($id);

        // si l'article n'a pas été trouvé, je renvoie une exception (erreur)
        // pour afficher une 404
        if (is_null($article)) {
            throw new NotFoundHttpException();
        }

        return $this->render("ArticleShow.html.twig", ['article' => $article]);
    }

    //Je créer ma route pour mon search
    /**
     * @Route("/search", name="search")
     */
    public function search(ArticleRepository $articleRepository, Request $request)
    {
        // ma variable qui permet de stocker mon search
        $term = $request->query->get('q');

        $articles = $articleRepository->searchByTerm($term);

        return $this->render('article_search.html.twig', [
            'articles' => $articles,
            'term' => $term
        ]);
    }

}