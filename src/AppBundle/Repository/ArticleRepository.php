<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\Article;


/**
 * ArticleRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ArticleRepository extends EntityRepository
{

    /**
     * @param $numberOfArticles
     * @return array
     */
    public function getLastArticles($numberOfArticles){
        return $this->findBy(
            array(),
            array('createdAt' => 'DESC'),
            $numberOfArticles,
            0
        );
    }

    public function getArchive(){
        // Attention, l'utilisation de la fonction YEAR
        // impose l'installation de la bibliothèque
        // orocrm/doctrine-extensions
        $em = $this->getEntityManager();
        $query = $em->createQuery(
            "SELECT YEAR(a.createdAt) as year_published,
              COUNT(a.id) as numberOfArticles
              FROM AppBundle:Article as a
              GROUP BY year_published"
        );
        return $query->getArrayResult();
    }

    public function getAuthorListForAside(){
        $qb = $this->createQueryBuilder('a')
            ->select("w.id, concat_ws(' ',w.firstName,w.name) as fullName, COUNT(a.id) as numberOfArticles")
            ->join('a.author','w')
            ->addGroupBy('w.id');

        return $qb->getQuery()->getArrayResult();
    }

    public function getMostPopularArticles($numberOfArticles){
        $qb = $this->createQueryBuilder('a')
            ->select("a.id, a.title, a.lead, a.createdAt,
                concat_ws(' ',w.firstName,w.name) as authorName,
                COUNT(c.id) as numberOfComments, a.slug")
            ->join('a.comments','c')
            ->join('a.author','w')
            ->orderBy('numberOfComments', 'DESC')
            ->addOrderBy('a.createdAt', 'DESC')
            ->addGroupBy('a.id')
            ->setMaxResults($numberOfArticles);

        //var_dump($qb->getDQL());

        return $qb->getQuery()->getArrayResult();
    }

    public function getMostPopularArticleDQL($numberOfArticles){
        $em = $this->getEntityManager();



        $sql ="SELECT a.id, a.title, a.lead, a.createdAt,
                concat_ws(' ',w.firstName,w.name) as authorName,
                COUNT(c.id) as numberOfComments, a.slug
                FROM AppBundle:Article as a
                INNER JOIN a.comments as c
                INNER JOIN a.author as w
                GROUP BY a.id
                ORDER BY numberOfComments DESC, a.createdAt DESC
                ";

        $query = $em->createQuery($sql)->setMaxResults($numberOfArticles);

        return $query->getArrayResult();

    }

    public function getArticleByTag($tag){
        $qb = $this->createQueryBuilder('a')
            ->select('a')
            ->join('a.tags', 't')
            ->where('t.tagName= :tag')
            ->setParameter('tag', $tag);

        return $qb->getQuery()->getResult();
    }

    public function getArticleByYear($year){
        $qb = $this->createQueryBuilder('a')
            ->select('a')
            ->where('YEAR(a.createdAt)= :year')
            ->setParameter('year', $year);

        return $qb->getQuery()->getResult();
    }

    public function getArticleByAuthor($id){
        $qb = $this->createQueryBuilder('a')
            ->select('a')
            ->join('a.author', 'w')
            ->where('w.id= :id')
            ->setParameter('id', $id);

        return $qb->getQuery()->getResult();
    }

    public function getTotalNumberOfArticles(){
        $qb = $this->createQueryBuilder('a')
            ->select('count(a)');

        return $qb->getQuery()->getSingleScalarResult();
    }

    public function getArticlesByPage($maxPerPage, $page = 1){
        $qb = $this->createQueryBuilder('a')
            ->select('a')
            ->setFirstResult(($page-1) * $maxPerPage)
            ->setMaxResults($maxPerPage);

        return $qb->getQuery()->getResult();
    }


}
