<?php
/**
 * Created by PhpStorm.
 * User: Mouncef
 * Date: 11/07/2017
 * Time: 20:17
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Horoscope;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;

class HoroscopeController extends Controller
{
    public function indexAction()
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Unable to access this page!');
        $articlehoro = $this->getDoctrine()->getRepository('AppBundle:Horoscope')->findAll();
        return $this->render('AppBundle:Backoffice:Horoscope/adminhoropage.html.twig', array(
            'articlehoro' => $articlehoro,
        ));
    }

    public function addarticleAction(Request $request)
    {
        $articlehoro = $this->getDoctrine()->getRepository('AppBundle:Horoscope')->findAll();
        $articlehoroscope = new Horoscope();

        $form = $this->createFormBuilder($articlehoroscope)
            ->add('name', TextType::Class)
            ->add('content', TextType::class)
            ->getForm()
        ;

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $request->getSession()->getFlashBag()->add('success', 'Horoscope crée avec succés !');
            $articlehoroscope = $form->getData();
            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            $em = $this->getDoctrine()->getManager();
            $em->persist($articlehoroscope);
            $em->flush();

            return $this->redirectToRoute('jamilati_admin_horo');
        }

        return $this->render('AppBundle:Backoffice:Horoscope/adminaddarticlehoro.html.twig', array(
            'form' => $form->createView(),
            'articlehoro' => $articlehoro,
        ));
    }

    public function editarticleAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository('AppBundle:Horoscope')->find($id);
        $articlehoro = $this->getDoctrine()->getRepository('AppBundle:Horoscope')->findAll();

        if (!$article) {
            throw $this->createNotFoundException(
                'Aucun article trouvée avec cet id '.$id
            );
        }

        $form = $this->createFormBuilder($article)
            ->add('name', TextType::Class)
            ->add('content', TextType::class)
            ->getForm()
        ;

        if ($form->handleRequest($request)->isValid()) {
            $request->getSession()->getFlashBag()->add('warning', 'Horoscope Modifié avec succés !');
            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();

            return $this->redirect($this->generateUrl('jamilati_admin_horo'));

        }

        return $this->render('AppBundle:Backoffice:Horoscope/admineditarticle.html.twig', array(
            'form' => $form->createView(),
            'articlehoro' => $articlehoro,
        ));

    }

    public function removearticleAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository('AppBundle:Horoscope')->find($id);

        if (!$article) {
            throw $this->createNotFoundException(
                'Aucun Article trouvée avec cet id '.$id
            );
        }

        $request->getSession()->getFlashBag()->add('danger', 'Horoscope supprimé !');
        $em->remove($article);
        $em->flush();
        return $this->redirect($this->generateUrl('jamilati_admin_horo'));

    }

}