<?php
/**
 * Created by PhpStorm.
 * User: Mouncef
 * Date: 11/07/2017
 * Time: 21:25
 */

namespace AppBundle\Controller;


use AppBundle\Entity\DayAdvice;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;

class DayAdviceController extends Controller
{

    public function indexAction()
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Unable to access this page!');
        $articleda = $this->getDoctrine()->getRepository('AppBundle:DayAdvice')->findAll();
        return $this->render('AppBundle:Backoffice:DayAdvice/admindapage.html.twig', array(
            'articleda' => $articleda,
        ));
    }


    public function addarticleAction(Request $request)
    {
        $articleda = $this->getDoctrine()->getRepository('AppBundle:DayAdvice')->findAll();
        $articledayad = new DayAdvice();

        $form = $this->createFormBuilder($articledayad)
            ->add('content', TextareaType::Class)
            ->add('author', TextType::class)
            ->getForm()
        ;

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $request->getSession()->getFlashBag()->add('success', 'Article crée avec succés !');
            $articledayad = $form->getData();
            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            $em = $this->getDoctrine()->getManager();
            $em->persist($articledayad);
            $em->flush();

            return $this->redirectToRoute('jamilati_admin_da');
        }

        return $this->render('AppBundle:Backoffice:DayAdvice/adminaddarticleda.html.twig', array(
            'form' => $form->createView(),
            'articleda' => $articleda,
        ));
    }


    public function editarticleAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository('AppBundle:DayAdvice')->find($id);
        $articleda = $this->getDoctrine()->getRepository('AppBundle:DayAdvice')->findAll();

        if (!$article) {
            throw $this->createNotFoundException(
                'Aucun article trouvée avec cet id '.$id
            );
        }

        $form = $this->createFormBuilder($article)
            ->add('content', TextareaType::Class)
            ->add('author', TextType::class)
            ->getForm()
        ;

        if ($form->handleRequest($request)->isValid()) {
            $request->getSession()->getFlashBag()->add('warning', 'Article Modifié avec succés !');
            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();

            return $this->redirect($this->generateUrl('jamilati_admin_da'));

        }

        return $this->render('AppBundle:Backoffice:DayAdvice/admineditarticle.html.twig', array(
            'form' => $form->createView(),
            'articleda' => $articleda,
        ));

    }


    public function removearticleAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository('AppBundle:DayAdvice')->find($id);

        if (!$article) {
            throw $this->createNotFoundException(
                'Aucun Article trouvée avec cet id '.$id
            );
        }

        $request->getSession()->getFlashBag()->add('danger', 'Article supprimé !');
        $em->remove($article);
        $em->flush();
        return $this->redirect($this->generateUrl('jamilati_admin_da'));

    }

}