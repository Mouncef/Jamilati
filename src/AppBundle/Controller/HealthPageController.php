<?php
/**
 * Created by PhpStorm.
 * User: Mouncef
 * Date: 12/07/2017
 * Time: 15:21
 */

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class HealthPageController extends Controller
{
    public function indexAction(Request $request){

        $em = $this->getDoctrine()->getManager();

        $articlevideo = $em->getRepository('AppBundle:Articlevideo')->find5LatestPublishedArticles();
        $articleadvice = $this->getDoctrine()->getRepository('AppBundle:DayAdvice')->findAll();
        $articleinvention = $em->getRepository('AppBundle:Invention')->find5LatestPublishedArticles();

        $articlehealth = $em->getRepository('AppBundle:Articlehealth')->findLatestPublishedArticles();
        $lasthealth = $em->getRepository('AppBundle:Articlehealth')->findLastPublishedArticle();
        $cathealth = $this->getDoctrine()->getRepository('AppBundle:CatHealth')->findAll();

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $articlehealth,
            $request->query->getInt('page', 1),
            30
        );

        $articlemode = $em->getRepository('AppBundle:Articlemode')->find5LatestPublishedArticles();
        $lastmode = $em->getRepository('AppBundle:Articlemode')->findLastPublishedArticle();

        $articlebeauty = $em->getRepository('AppBundle:Articlebeauty')->find5LatestPublishedArticles();
        $lastbeauty = $em->getRepository('AppBundle:Articlebeauty')->findLastPublishedArticle();

        $articlekitchen = $em->getRepository('AppBundle:Articlekitchen')->find5LatestPublishedArticles();
        $lastkitchen = $em->getRepository('AppBundle:Articlekitchen')->findLastPublishedArticle();

        $articlefamily = $em->getRepository('AppBundle:Articlefamily')->find5LatestPublishedArticles();
        $lastfamily = $em->getRepository('AppBundle:Articlefamily')->findLastPublishedArticle();

        $articlenews = $em->getRepository('AppBundle:Articlenews')->find5LatestPublishedArticles();
        $lastnews = $em->getRepository('AppBundle:Articlenews')->findLastPublishedArticle();

        $articlestar = $em->getRepository('AppBundle:Articlestars')->find5LatestPublishedArticles();
        $laststar = $em->getRepository('AppBundle:Articlestars')->findLastPublishedArticle();

        $horoscope = $this->getDoctrine()->getRepository('AppBundle:Horoscope')->findAll();
        $articleimgday = $this->getDoctrine()->getRepository('AppBundle:DayPicture')->findAll();

        $sondage = $em->getRepository('AppBundle:Sondage')->find5LatestPublishedArticles();

        return $this->render('AppBundle:Frontoffice:Health/index.html.twig',[
            'articlevideo'          => $articlevideo,
            'articleadvice'         => $articleadvice,
            'articleinvention'      => $articleinvention,
            'articlemode'           => $articlemode,
            'articlebeauty'         => $articlebeauty,
            'articlekitchen'        => $articlekitchen,
            'articlehealth'         => $articlehealth,
            'articlefamily'         => $articlefamily,
            'articlenews'           => $articlenews,
            'articlestar'           => $articlestar,
            'horoscope'             => $horoscope,
            'articleimgday'         => $articleimgday,
            'sondage'               => $sondage,
            'lastmode'              => $lastmode,
            'lastbeauty'            => $lastbeauty,
            'lastkitchen'           => $lastkitchen,
            'lasthealth'            => $lasthealth,
            'lastfamily'            => $lastfamily,
            'lastnews'              => $lastnews,
            'laststar'              => $laststar,
            'cathealth'             => $cathealth,
            'pagination'            => $pagination
        ]);
    }

    public function viewAction($id, Request $request){
        $em = $this->getDoctrine()->getManager();
        $health = $em->getRepository('AppBundle:Articlehealth')->find($id);

        $articlevideo = $em->getRepository('AppBundle:Articlevideo')->find5LatestPublishedArticles();
        $articleadvice = $this->getDoctrine()->getRepository('AppBundle:DayAdvice')->findAll();
        $articleinvention = $em->getRepository('AppBundle:Invention')->find5LatestPublishedArticles();

        $articlehealth = $em->getRepository('AppBundle:Articlehealth')->findLatestPublishedArticles();
        $lasthealth = $em->getRepository('AppBundle:Articlehealth')->findLastPublishedArticle();
        $cathealth = $this->getDoctrine()->getRepository('AppBundle:CatHealth')->findAll();

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $articlehealth,
            $request->query->getInt('page', 1),
            30
        );

        $articlemode = $em->getRepository('AppBundle:Articlemode')->find5LatestPublishedArticles();
        $lastmode = $em->getRepository('AppBundle:Articlemode')->findLastPublishedArticle();

        $articlebeauty = $em->getRepository('AppBundle:Articlebeauty')->find5LatestPublishedArticles();
        $lastbeauty = $em->getRepository('AppBundle:Articlebeauty')->findLastPublishedArticle();

        $articlekitchen = $em->getRepository('AppBundle:Articlekitchen')->find5LatestPublishedArticles();
        $lastkitchen = $em->getRepository('AppBundle:Articlekitchen')->findLastPublishedArticle();

        $articlefamily = $em->getRepository('AppBundle:Articlefamily')->find5LatestPublishedArticles();
        $lastfamily = $em->getRepository('AppBundle:Articlefamily')->findLastPublishedArticle();

        $articlenews = $em->getRepository('AppBundle:Articlenews')->find5LatestPublishedArticles();
        $lastnews = $em->getRepository('AppBundle:Articlenews')->findLastPublishedArticle();

        $articlestar = $em->getRepository('AppBundle:Articlestars')->find5LatestPublishedArticles();
        $laststar = $em->getRepository('AppBundle:Articlestars')->findLastPublishedArticle();

        $horoscope = $this->getDoctrine()->getRepository('AppBundle:Horoscope')->findAll();
        $articleimgday = $this->getDoctrine()->getRepository('AppBundle:DayPicture')->findAll();

        $sondage = $em->getRepository('AppBundle:Sondage')->find5LatestPublishedArticles();

        $views = $health->getViews();
        $health->setViews($views + 1);
        $em->persist($health);
        $em->flush();

        return $this->render('AppBundle:Frontoffice:Health/view.html.twig',[
            'health'                => $health,
            'articlevideo'          => $articlevideo,
            'articleadvice'         => $articleadvice,
            'articleinvention'      => $articleinvention,
            'articlemode'           => $articlemode,
            'articlebeauty'         => $articlebeauty,
            'articlekitchen'        => $articlekitchen,
            'articlehealth'         => $articlehealth,
            'articlefamily'         => $articlefamily,
            'articlenews'           => $articlenews,
            'articlestar'           => $articlestar,
            'horoscope'             => $horoscope,
            'articleimgday'         => $articleimgday,
            'sondage'               => $sondage,
            'lastmode'              => $lastmode,
            'lastbeauty'            => $lastbeauty,
            'lastkitchen'           => $lastkitchen,
            'lasthealth'            => $lasthealth,
            'lastfamily'            => $lastfamily,
            'lastnews'              => $lastnews,
            'laststar'              => $laststar,
            'cathealth'             => $cathealth,
            'pagination'            => $pagination
        ]);

    }
}