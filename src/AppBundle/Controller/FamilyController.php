<?php
/**
 * Created by PhpStorm.
 * User: Mouncef
 * Date: 25/06/2017
 * Time: 17:00
 */

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use AppBundle\Entity\CatFamily;
use AppBundle\Entity\Articlefamily;

class FamilyController extends Controller
{
    public function indexAction()
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Unable to access this page!');
        $catfam = $this->getDoctrine()->getRepository('AppBundle:CatFamily')->findAll();
        $articlefam = $this->getDoctrine()->getRepository('AppBundle:Articlefamily')->findBy(array(),array('date' => 'DESC'));
        return $this->render('AppBundle:Backoffice:Family/adminfamilypage.html.twig', array(
            'catfam' => $catfam,
            'articlefam' => $articlefam,
        ));
    }

    public function addcatAction(Request $request)
    {
        $catfam = $this->getDoctrine()->getRepository('AppBundle:CatFamily')->findAll();
        $articlefam = $this->getDoctrine()->getRepository('AppBundle:Articlefamily')->findBy(array(),array('date' => 'DESC'));
        $catfamily = new CatFamily();

        $form = $this->createFormBuilder($catfamily)
            ->add('lib', TextType::Class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            // $form->getData() holds the submitted values
            // but, the original `$catmode` variable has also been updated
            $request->getSession()->getFlashBag()->add('success', 'Catégorie créée avec succés !');
            $catfamily = $form->getData();
            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            $em = $this->getDoctrine()->getManager();
            $em->persist($catfamily);
            $em->flush();

            return $this->redirectToRoute('jamilati_admin_family');
        }

        return $this->render('AppBundle:Backoffice:Family/adminaddfamily.html.twig', array(
            'form' => $form->createView(),
            'articlefam' => $articlefam,
            'catfam' => $catfam,
        ));
    }

    public function addarticleAction(Request $request)
    {
        $catfam = $this->getDoctrine()->getRepository('AppBundle:CatFamily')->findAll();
        $articlefam = $this->getDoctrine()->getRepository('AppBundle:Articlefamily')->findBy(array(),array('date' => 'DESC'));
        $articlefamily = new Articlefamily();
        $articlefamily->setUpdatedAt(new \DateTime('now'));
        $user = $this->get('security.token_storage')->getToken()->getUsername();

        $form = $this->createFormBuilder($articlefamily)
            ->add('titre', TextType::Class)
            ->add('date', DateType::class, array(
                'widget' => 'single_text',
            ))
            ->add('content1', TextareaType::Class)
            ->add('content2', TextareaType::Class, ['required' => false])
            ->add('content3', TextareaType::Class, ['required' => false])
            ->add('catfamily', EntityType::class, array(
                // query choices from this entity
                'class' => 'AppBundle:CatFamily',
                // use the User.username property as the visible option string
                'choice_label' => 'lib',
            ))
            ->add('cover', FileType::class, ['required'=>false])
            ->add('listtitre1', TextType::Class, ['required'=>false])
            ->add('listcontent1', TextType::Class, ['required'=>false])
            ->add('listtitre2', TextType::Class, ['required'=>false])
            ->add('listcontent2', TextType::Class, ['required'=>false])
            ->add('listtitre3', TextType::Class, ['required'=>false])
            ->add('listcontent3', TextType::Class, ['required'=>false])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $request->getSession()->getFlashBag()->add('success', 'Article crée avec succés !');
            $articlefamily = $form->getData();
            $articlefamily->setUser($user);
            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            $em = $this->getDoctrine()->getManager();
            $em->persist($articlefamily);
            $em->flush();

            return $this->redirectToRoute('jamilati_admin_family');
        }

        return $this->render('AppBundle:Backoffice:Family/adminaddarticlefamily.html.twig', array(
            'form' => $form->createView(),
            'articlefam' => $articlefam,
            'catfam' => $catfam,
        ));
    }

    public function editcatAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $cat = $em->getRepository('AppBundle:CatFamily')->find($id);
        $catfam = $this->getDoctrine()->getRepository('AppBundle:CatFamily')->findAll();
        $articlefam = $this->getDoctrine()->getRepository('AppBundle:Articlefamily')->findBy(array(),array('date' => 'DESC'));

        if (!$cat) {
            throw $this->createNotFoundException(
                'Aucune catégorie trouvée avec cet id '.$id
            );
        }

        $form = $this->createFormBuilder($cat)
            ->add('lib', TextType::class)
            ->getForm();

        if ($form->handleRequest($request)->isValid()) {
            $request->getSession()->getFlashBag()->add('warning', 'Catégorie Modifiée avec succés !');
            $em = $this->getDoctrine()->getManager();
            $em->persist($cat);
            $em->flush();

            return $this->redirect($this->generateUrl('jamilati_admin_family'));

        }

        return $this->render('AppBundle:Backoffice:Family/admineditcat.html.twig', array(
            'form' => $form->createView(),
            'catfam' => $catfam,
            'articlefam' => $articlefam,
        ));

    }

    public function editarticleAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository('AppBundle:Articlefamily')->find($id);
        $catfam = $this->getDoctrine()->getRepository('AppBundle:CatFamily')->findAll();
        $articlefam = $this->getDoctrine()->getRepository('AppBundle:Articlefamily')->findBy(array(),array('date' => 'DESC'));

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
            ->add('content1', TextareaType::Class)
            ->add('content2', TextareaType::Class, ['required' => false])
            ->add('content3', TextareaType::Class, ['required' => false])
            ->add('catfamily', EntityType::class, array(
                // query choices from this entity
                'class' => 'AppBundle:CatFamily',
                // use the User.username property as the visible option string
                'choice_label' => 'lib',
            ))
            ->add('cover', FileType::class, ['required'=>false])
            ->add('listtitre1', TextType::Class, ['required'=>false])
            ->add('listcontent1', TextType::Class, ['required'=>false])
            ->add('listtitre2', TextType::Class, ['required'=>false])
            ->add('listcontent2', TextType::Class, ['required'=>false])
            ->add('listtitre3', TextType::Class, ['required'=>false])
            ->add('listcontent3', TextType::Class, ['required'=>false])
            ->getForm();

        if ($form->handleRequest($request)->isValid()) {
            $request->getSession()->getFlashBag()->add('warning', 'Article Modifié avec succés !');
            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();

            return $this->redirect($this->generateUrl('jamilati_admin_family'));

        }

        return $this->render('AppBundle:Backoffice:Family/admineditarticle.html.twig', array(
            'form' => $form->createView(),
            'catfam' => $catfam,
            'articlefam' => $articlefam,
        ));

    }

    public function removecatAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $cat = $em->getRepository('AppBundle:CatFamily')->find($id);

        if (!$cat) {
            throw $this->createNotFoundException(
                'Aucune catégorie trouvée avec cet id '.$id
            );
        }

        $request->getSession()->getFlashBag()->add('danger', 'Catégorie supprimée !');
        $em->remove($cat);
        $em->flush();
        return $this->redirect($this->generateUrl('jamilati_admin_family'));

    }

    public function removearticleAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository('AppBundle:Articlefamily')->find($id);

        if (!$article) {
            throw $this->createNotFoundException(
                'Aucun Article trouvée avec cet id '.$id
            );
        }

        $request->getSession()->getFlashBag()->add('danger', 'Article supprimé !');
        $em->remove($article);
        $em->flush();
        return $this->redirect($this->generateUrl('jamilati_admin_family'));

    }

    public function publishAction($id, Request $request){
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository('AppBundle:Articlefamily')->find($id);

        if (!$article) {
            throw $this->createNotFoundException(
                'Aucun Article trouvée avec cet id '.$id
            );
        }

        $request->getSession()->getFlashBag()->add('success', 'Article publié !');
        $article->setIsPublished(1);
        $em->persist($article);
        $em->flush();
        return $this->redirect($this->generateUrl('jamilati_admin_family'));
    }

    public function unpublishAction($id, Request $request){
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository('AppBundle:Articlefamily')->find($id);

        if (!$article) {
            throw $this->createNotFoundException(
                'Aucun Article trouvée avec cet id '.$id
            );
        }

        $request->getSession()->getFlashBag()->add('success', "Article n'est plus publié !");
        $article->setIsPublished(0);
        $em->persist($article);
        $em->flush();
        return $this->redirect($this->generateUrl('jamilati_admin_family'));
    }
}