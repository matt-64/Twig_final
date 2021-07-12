<?php


namespace App\Controller\Front;


use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class FrontArticleController extends AbstractController
{
    /**
     * @Route("/articles/{id}",name="article_Show")
     */
    public function articleShow($id, ArticleRepository  $articleRepository)
    {
        $article = $articleRepository->find($id);

        // si l'article n'a pas été trouvé, je renvoie une exception (erreur)
        // pour afficher une 404
        if (is_null($article)) {
            throw new NotFoundHttpException();
        }

        return $this->render("front/ArticleShow.html.twig", ['article' => $article]);
    }
    // Read
    /**
     * @Route ("/articles", name="article_List")
     */
    public function articleList(ArticleRepository $articleRepository)
    {
        //je dois faire une requête SELECT en BDD sur la table article
        //La classe qui me permet de faire des requêtes SELECT est ArticleRepository
        //donc je dois instancier cette classe
        //pour ça, j'utilise l'autowire (je place la classe en argument du controleur)
        //suivi de la variable dans laquelle je veux que sf m'instancie la classe

        $articles = $articleRepository->findAll();

        return $this->render("front/ArticleList.html.twig", [
            'articles' => $articles
        ]);
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

        return $this->render('front/article_search.html.twig', [
            'articles' => $articles,
            'term' => $term
        ]);
    }
}