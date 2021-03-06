<?php
/**
 * Created by PhpStorm.
 * User: Mouncef
 * Date: 10/07/2017
 * Time: 16:23
 */

namespace AppBundle\Repository;


use Doctrine\ORM\EntityRepository;

/**
 * Class ArticleStarsRepository
 *
 *  This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ArticleStarsRepository extends EntityRepository
{
    public function findNbEnregistrement(){
        return $this->getEntityManager()
            ->createQuery(
                'SELECT COUNT(s.id) FROM AppBundle:Articlestars s'
            )
            ->getSingleScalarResult();
    }

    public function findLatestPublishedArticles(){
        return $this->getEntityManager()
            ->createQuery(
                'SELECT s FROM AppBundle:Articlestars s WHERE s.isPublished = 1 ORDER BY s.date DESC'
            )
            ->getResult()
            ;
    }

    public function find5LatestPublishedArticles(){
        return $this->getEntityManager()
            ->createQuery(
                'SELECT s FROM AppBundle:Articlestars s WHERE s.isPublished = 1 ORDER BY s.date DESC'
            )
            ->setMaxResults(5)
            ->getResult()
            ;
    }

    public function findLastPublishedArticle(){
        return $this->getEntityManager()
            ->createQuery(
                'SELECT s FROM AppBundle:Articlestars s WHERE s.isPublished = 1 ORDER BY s.date DESC'
            )
            ->setMaxResults(1)
            ->getOneOrNullResult()
            ;
    }
}