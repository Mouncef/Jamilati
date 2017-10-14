<?php
/**
 * Created by PhpStorm.
 * User: Mouncef
 * Date: 25/06/2017
 * Time: 16:50
 */

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * ArticlefamilyRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ArticlefamilyRepository extends EntityRepository
{

    public function findNbEnregistrement(){
        return $this->getEntityManager()
            ->createQuery(
                'SELECT COUNT(f.id) FROM AppBundle:Articlefamily f'
            )
            ->getSingleScalarResult();
    }

    public function findLatestPublishedArticles(){
        return $this->getEntityManager()
            ->createQuery(
                'SELECT f FROM AppBundle:Articlefamily f WHERE f.isPublished = 1 ORDER BY f.date DESC'
            )
            ->getResult()
            ;
    }

    public function find5LatestPublishedArticles(){
        return $this->getEntityManager()
            ->createQuery(
                'SELECT f FROM AppBundle:Articlefamily f WHERE f.isPublished = 1 ORDER BY f.date DESC'
            )
            ->setMaxResults(5)
            ->getResult()
            ;
    }

    public function findLastPublishedArticle(){
        return $this->getEntityManager()
            ->createQuery(
                'SELECT f FROM AppBundle:Articlefamily f WHERE f.isPublished = 1 ORDER BY f.date DESC'
            )
            ->setMaxResults(1)
            ->getOneOrNullResult()
            ;
    }

}