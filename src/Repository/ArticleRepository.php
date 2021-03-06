<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }
    //méthode pour créer requête SQL
    public function searchByTerm($term)
    {
        $queryBuilder = $this->createQueryBuilder('article');

        //requête SQL
        $query = $queryBuilder
            ->select('article')
            //creation d'une jointure sur article et de son alias
            ->leftJoin('article.category', 'category')
            ->leftJoin('article.tag', 'tag')

            //utilisation des methode du query builder pour requete SQL
            ->where('article.content LIKE :term')
            //ajout de filtres suplémentaire avec orWhere
            ->orWhere('article.title LIKE :term')
            ->orWhere('category.title LIKE :term')
            ->orWhere('tag.title LIKE :term')

            ->setParameter('term', '%'.$term.'%')
            ->getQuery();

        return $query->getResult();
    }

    // /**
    //  * @return Article[] Returns an array of Article objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Article
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
