<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Email;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class FrontofficeController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $articlevideo = $em->getRepository('AppBundle:Articlevideo')->find5LatestPublishedArticles();
        $articleadvice = $this->getDoctrine()->getRepository('AppBundle:DayAdvice')->findAll();
        $articleinvention = $em->getRepository('AppBundle:Invention')->find5LatestPublishedArticles();


        $articlemode = $em->getRepository('AppBundle:Articlemode')->find5LatestPublishedArticles();
        $lastmode = $em->getRepository('AppBundle:Articlemode')->findLastPublishedArticle();

        $articlebeauty = $em->getRepository('AppBundle:Articlebeauty')->find5LatestPublishedArticles();
        $lastbeauty = $em->getRepository('AppBundle:Articlebeauty')->findLastPublishedArticle();

        $articlekitchen = $em->getRepository('AppBundle:Articlekitchen')->find5LatestPublishedArticles();
        $lastkitchen = $em->getRepository('AppBundle:Articlekitchen')->findLastPublishedArticle();

        $articlehealth = $em->getRepository('AppBundle:Articlehealth')->find5LatestPublishedArticles();
        $lasthealth = $em->getRepository('AppBundle:Articlehealth')->findLastPublishedArticle();

        $articlefamily = $em->getRepository('AppBundle:Articlefamily')->find5LatestPublishedArticles();
        $lastfamily = $em->getRepository('AppBundle:Articlefamily')->findLastPublishedArticle();

        $articlenews = $em->getRepository('AppBundle:Articlenews')->find5LatestPublishedArticles();
        $lastnews = $em->getRepository('AppBundle:Articlenews')->findLastPublishedArticle();

        $articlestar = $em->getRepository('AppBundle:Articlestars')->find5LatestPublishedArticles();
        $laststar = $em->getRepository('AppBundle:Articlestars')->findLastPublishedArticle();

        $horoscope = $this->getDoctrine()->getRepository('AppBundle:Horoscope')->findAll();
        $articleimgday = $this->getDoctrine()->getRepository('AppBundle:DayPicture')->findAll();

        $sondage = $em->getRepository('AppBundle:Sondage')->find5LatestPublishedArticles();


        return $this->render('AppBundle:Frontoffice:index.html.twig',[
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
        ]);
    }
    
    public function adminAction()
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Unable to access this page!');
        $nbMode = $this->getDoctrine()->getRepository('AppBundle:Articlemode')->findNbEnregistrement();
        $nbBeauty = $this->getDoctrine()->getRepository('AppBundle:Articlebeauty')->findNbEnregistrement();
        $nbKitchen = $this->getDoctrine()->getRepository('AppBundle:Articlekitchen')->findNbEnregistrement();
        $nbHealth = $this->getDoctrine()->getRepository('AppBundle:Articlehealth')->findNbEnregistrement();
        $nbFamily = $this->getDoctrine()->getRepository('AppBundle:Articlefamily')->findNbEnregistrement();
        $nbNews = $this->getDoctrine()->getRepository('AppBundle:Articlenews')->findNbEnregistrement();
        $nbStars = $this->getDoctrine()->getRepository('AppBundle:Articlestars')->findNbEnregistrement();

        return $this->render('AppBundle:Backoffice:admin.html.twig', [
            'nbMode'        => $nbMode,
            'nbBeauty'      => $nbBeauty,
            'nbKitchen'     => $nbKitchen,
            'nbHealth'      => $nbHealth,
            'nbFamily'      => $nbFamily,
            'nbNews'        => $nbNews,
            'nbStars'       => $nbStars,
        ]);
    }

    public function voteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $sondage = $em->getRepository('AppBundle:Sondage')->find($id);
        $image1 = $request->query->getAlnum('image1');
        $image2 = $request->query->getAlnum('image2');


        if ($image1) {
            $sondage->increaseNbVotes1();
            $em->persist($sondage);
        }

        elseif ($image2) {
            $sondage->increaseNbVotes2();
            $em->persist($sondage);
        }

        else {
            echo "Aucun Vote n'a été fait";
        }

        $em->flush();

        return $this->redirectToRoute('jamilati_homepage');
    }

    public function emailAction(Request $request){

        $em = $this->getDoctrine()->getManager();

        $email = new Email();

        $mc = $request->query->get('email');

        if ($mc) {
            $email->setEmail($mc);
            $em->persist($email);
        } else {
            echo "Aucun Email n'a été envoyé";
        }

        $em->flush();

        return $this->redirectToRoute('jamilati_homepage');
    }

    public function contactAction(Request $request){

        $msg = $request->query->get('message');
        $name = $request->query->get('name');
        $email = $request->query->get('email');
        $subject = $request->query->get('subject');


        if ($request->isMethod('GET')) {
            $message = (new \Swift_Message($subject))
                ->setFrom($email)
                ->setTo('zaghratmoncef@gmail.com')
                ->setBody(
                    $this->renderView(
                    // app/Resources/views/Emails/registration.html.twig
                        'Emails/messageContact.html.twig',
                        array(
                            'name' => $name,
                            'msg'  => $msg,
                            'email'  => $email,
                            'subject'  => $subject
                        )
                    ),
                    'text/html'
                )
            ;

            $this->get('mailer')->send($message);


        } else {
            echo "Votre message n'a pas été envoyé";
        }

        return $this->redirectToRoute('jamilati_homepage');

    }
}
