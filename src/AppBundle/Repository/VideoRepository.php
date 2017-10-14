<?php

namespace AppBundle\Repository;

/**
 * VideoRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class VideoRepository extends \Doctrine\ORM\EntityRepository
{
    public function findLatestPublishedArticles(){
        return $this->getEntityManager()
            ->createQuery(
                'SELECT v FROM AppBundle:Articlevideo v WHERE v.isPublished = 1 ORDER BY v.date DESC'
            )
            ->getResult()
            ;
    }

    public function find5LatestPublishedArticles(){
        return $this->getEntityManager()
            ->createQuery(
                'SELECT v FROM AppBundle:Articlevideo v WHERE v.isPublished = 1 ORDER BY v.date DESC'
            )
            ->setMaxResults(5)
            ->getResult()
            ;
    }

    public function findLastPublishedArticle(){
        return $this->getEntityManager()
            ->createQuery(
                'SELECT v FROM AppBundle:Articlevideo v WHERE v.isPublished = 1 ORDER BY v.date DESC'
            )
            ->setMaxResults(1)
            ->getOneOrNullResult()
            ;
    }
}
