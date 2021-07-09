<?php


namespace App\Controller;


use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{

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