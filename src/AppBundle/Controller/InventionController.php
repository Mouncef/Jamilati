<?php
/**
 * Created by PhpStorm.
 * User: Mouncef
 * Date: 12/07/2017
 * Time: 17:37
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Invention;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;


class InventionController extends Controller
{
    public function indexAction()
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Unable to access this page!');
        $articleinv = $this->getDoctrine()->getRepository('AppBundle:Invention')->findBy(array(),array('date' => 'DESC'));
        return $this->render('AppBundle:Backoffice:Invention/admininventionpage.html.twig', array(
            'articleinv' => $articleinv,
        ));
    }

    public function addarticleAction(Request $request)
    {
        $articleinv = $this->getDoctrine()->getRepository('AppBundle:Invention')->findBy(array(),array('date' => 'DESC'));
        $articleinvention = new Invention();
        $articleinvention->setUpdatedAt(new \DateTime('now'));

        $form = $this->createFormBuilder($articleinvention)
            ->add('titre', TextType::Class)
            ->add('date', DateType::class, array(
                'widget' => 'single_text',
            ))
            ->add('image', FileType::class, ['required' => false])
            ->getForm()
        ;

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $request->getSession()->getFlashBag()->add('success', 'Article crée avec succés !');
            $articleinvention = $form->getData();
            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            $em = $this->getDoctrine()->getManager();
            $em->persist($articleinvention);
            $em->flush();

            return $this->redirectToRoute('jamilati_admin_invention');
        }

        return $this->render('AppBundle:Backoffice:Invention/adminaddarticleinvention.html.twig', array(
            'form' => $form->createView(),
            'articleinv' => $articleinv,
        ));
    }

    public function editarticleAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository('AppBundle:Invention')->find($id);
        $articleinv = $this->getDoctrine()->getRepository('AppBundle:Invention')->findBy(array(),array('date' => 'DESC'));

        if (!$article) {
            throw $this->createNotFoundException(
                'Aucun article trouvée avec cet id '.$id
            );
        }

        $article->setUpdatedAt(new \DateTime('now'));

        $form = $this->createFormBuilder($article)
            ->add('titre', TextType::Class)
            ->add('date', DateType::class, array(
                'widget' => 'single_text',
            ))
            ->add('image', FileType::class, ['required' => false])
            ->getForm()
        ;

        if ($form->handleRequest($request)->isValid()) {
            $request->getSession()->getFlashBag()->add('warning', 'Article Modifié avec succés !');
            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();

            return $this->redirect($this->generateUrl('jamilati_admin_invention'));

        }

        return $this->render('AppBundle:Backoffice:Invention/admineditarticle.html.twig', array(
            'form' => $form->createView(),
            'articleinv' => $articleinv,
        ));

    }


    public function removearticleAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository('AppBundle:Invention')->find($id);

        if (!$article) {
            throw $this->createNotFoundException(
                'Aucun Article trouvée avec cet id '.$id
            );
        }

        $request->getSession()->getFlashBag()->add('danger', 'Article supprimé !');
        $em->remove($article);
        $em->flush();
        return $this->redirect($this->generateUrl('jamilati_admin_invention'));

    }

    public function publishAction($id, Request $request){
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository('AppBundle:Invention')->find($id);

        if (!$article) {
            throw $this->createNotFoundException(
                'Aucun Article trouvée avec cet id '.$id
            );
        }

        $request->getSession()->getFlashBag()->add('success', 'Article publié !');
        $article->setIsPublished(1);
        $em->persist($article);
        $em->flush();
        return $this->redirect($this->generateUrl('jamilati_admin_invention'));
    }

    public function unpublishAction($id, Request $request){
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository('AppBundle:Invention')->find($id);

        if (!$article) {
            throw $this->createNotFoundException(
                'Aucun Article trouvée avec cet id '.$id
            );
        }

        $request->getSession()->getFlashBag()->add('warning', "Article n'est plus publié !");
        $article->setIsPublished(0);
        $em->persist($article);
        $em->flush();
        return $this->redirect($this->generateUrl('jamilati_admin_invention'));
    }


}