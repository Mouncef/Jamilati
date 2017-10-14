<?php
/**
 * Created by PhpStorm.
 * User: Mouncef
 * Date: 12/07/2017
 * Time: 17:12
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Sondage;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;

class SondageController extends Controller
{
    public function indexAction()
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Unable to access this page!');
        $articleson = $this->getDoctrine()->getRepository('AppBundle:Sondage')->findBy(array(),array('date' => 'DESC'));
        return $this->render('AppBundle:Backoffice:Sondage/adminsondagepage.html.twig', array(
            'articleson' => $articleson,
        ));
    }

    public function addarticleAction(Request $request)
    {
        $articleson = $this->getDoctrine()->getRepository('AppBundle:Sondage')->findBy(array(),array('date' => 'DESC'));
        $articlesondage = new Sondage();
        $articlesondage->setUpdatedAt(new \DateTime('now'));

        $form = $this->createFormBuilder($articlesondage)
            ->add('lib', TextType::Class)
            ->add('date', DateType::class, array(
                'widget' => 'single_text',
            ))
            ->add('image1', FileType::class, ['required' => false])
            ->add('image2', FileType::class, ['required' => false])
            ->getForm()
        ;

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $request->getSession()->getFlashBag()->add('success', 'Article crée avec succés !');
            $articlesondage = $form->getData();
            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            $em = $this->getDoctrine()->getManager();
            $em->persist($articlesondage);
            $em->flush();

            return $this->redirectToRoute('jamilati_admin_sondage');
        }

        return $this->render('AppBundle:Backoffice:Sondage/adminaddarticlesondage.html.twig', array(
            'form' => $form->createView(),
            'articleson' => $articleson,
        ));
    }

    public function editarticleAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository('AppBundle:Sondage')->find($id);
        $articleson = $this->getDoctrine()->getRepository('AppBundle:Sondage')->findBy(array(),array('date' => 'DESC'));

        if (!$article) {
            throw $this->createNotFoundException(
                'Aucun article trouvée avec cet id '.$id
            );
        }

        $article->setUpdatedAt(new \DateTime('now'));

        $form = $this->createFormBuilder($article)
            ->add('lib', TextType::Class)
            ->add('date', DateType::class, array(
                'widget' => 'single_text',
            ))
            ->add('image1', FileType::class, ['required' => false])
            ->add('image2', FileType::class, ['required' => false])
            ->getForm()
        ;

        if ($form->handleRequest($request)->isValid()) {
            $request->getSession()->getFlashBag()->add('warning', 'Article Modifié avec succés !');
            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();

            return $this->redirect($this->generateUrl('jamilati_admin_sondage'));

        }

        return $this->render('AppBundle:Backoffice:Sondage/admineditarticle.html.twig', array(
            'form' => $form->createView(),
            'articleson' => $articleson,
        ));

    }


    public function removearticleAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository('AppBundle:Sondage')->find($id);

        if (!$article) {
            throw $this->createNotFoundException(
                'Aucun Article trouvée avec cet id '.$id
            );
        }

        $request->getSession()->getFlashBag()->add('danger', 'Article supprimé !');
        $em->remove($article);
        $em->flush();
        return $this->redirect($this->generateUrl('jamilati_admin_sondage'));

    }

    public function publishAction($id, Request $request){
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository('AppBundle:Sondage')->find($id);

        if (!$article) {
            throw $this->createNotFoundException(
                'Aucun Article trouvée avec cet id '.$id
            );
        }

        $request->getSession()->getFlashBag()->add('success', 'Sondage publié !');
        $article->setIsPublished(1);
        $em->persist($article);
        $em->flush();
        return $this->redirect($this->generateUrl('jamilati_admin_sondage'));
    }

    public function unpublishAction($id, Request $request){
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository('AppBundle:Sondage')->find($id);

        if (!$article) {
            throw $this->createNotFoundException(
                'Aucun Article trouvée avec cet id '.$id
            );
        }

        $request->getSession()->getFlashBag()->add('success', "Sondage n'est plus publié !");
        $article->setIsPublished(0);
        $em->persist($article);
        $em->flush();
        return $this->redirect($this->generateUrl('jamilati_admin_sondage'));
    }

}