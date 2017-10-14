<?php
/**
 * Created by PhpStorm.
 * User: Mouncef
 * Date: 21/06/2017
 * Time: 18:08
 */

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use AppBundle\Entity\CatKitchen;
use AppBundle\Entity\Articlekitchen;

class KitchenController extends Controller
{
    public function indexAction()
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Unable to access this page!');
        $catkit = $this->getDoctrine()->getRepository('AppBundle:CatKitchen')->findAll();
        $articlekit = $this->getDoctrine()->getRepository('AppBundle:Articlekitchen')->findBy(array(),array('date' => 'DESC'));
        return $this->render('AppBundle:Backoffice:Kitchen/adminkitchenpage.html.twig', array(
            'catkit' => $catkit,
            'articlekit' => $articlekit,
        ));
    }

    public function addcatAction(Request $request)
    {
        $catkit = $this->getDoctrine()->getRepository('AppBundle:CatKitchen')->findAll();
        $articlekit = $this->getDoctrine()->getRepository('AppBundle:Articlekitchen')->findBy(array(),array('date' => 'DESC'));
        $catkitchen = new CatKitchen();

        $form = $this->createFormBuilder($catkitchen)
            ->add('lib', TextType::Class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            // $form->getData() holds the submitted values
            // but, the original `$catmode` variable has also been updated
            $request->getSession()->getFlashBag()->add('success', 'Catégorie créée avec succés !');
            $catkitchen = $form->getData();
            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            $em = $this->getDoctrine()->getManager();
            $em->persist($catkitchen);
            $em->flush();

            return $this->redirectToRoute('jamilati_admin_kitchen');
        }

        return $this->render('AppBundle:Backoffice:Kitchen/adminaddkitchen.html.twig', array(
            'form' => $form->createView(),
            'articlekit' => $articlekit,
            'catkit' => $catkit,
        ));
    }

    public function addarticleAction(Request $request)
    {
        $catkit = $this->getDoctrine()->getRepository('AppBundle:CatKitchen')->findAll();
        $articlekit = $this->getDoctrine()->getRepository('AppBundle:Articlekitchen')->findBy(array(),array('date' => 'DESC'));
        $articlekitchen = new Articlekitchen();
        $articlekitchen->setUpdatedAt(new \DateTime('now'));
        $user = $this->get('security.token_storage')->getToken()->getUsername();

        $form = $this->createFormBuilder($articlekitchen)
            ->add('titre', TextType::Class)
            ->add('date', DateType::class, array(
                'widget' => 'single_text',
            ))
            ->add('content1', TextareaType::Class)
            ->add('content2', TextareaType::Class, ['required'=>false])
            ->add('content3', TextareaType::Class, ['required'=>false])
            ->add('catkitchen', EntityType::class, array(
                // query choices from this entity
                'class' => 'AppBundle:CatKitchen',
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
            $articlekitchen = $form->getData();
            $articlekitchen->setUser($user);
            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            $em = $this->getDoctrine()->getManager();
            $em->persist($articlekitchen);
            $em->flush();

            return $this->redirectToRoute('jamilati_admin_kitchen');
        }

        return $this->render('AppBundle:Backoffice:Kitchen/adminaddarticlekitchen.html.twig', array(
            'form' => $form->createView(),
            'articlekit' => $articlekit,
            'catkit' => $catkit,
        ));
    }

    public function editcatAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $cat = $em->getRepository('AppBundle:CatKitchen')->find($id);
        $catkit = $this->getDoctrine()->getRepository('AppBundle:CatKitchen')->findAll();
        $articlekit = $this->getDoctrine()->getRepository('AppBundle:Articlekitchen')->findBy(array(),array('date' => 'DESC'));

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

            return $this->redirect($this->generateUrl('jamilati_admin_kitchen'));

        }

        return $this->render('AppBundle:Backoffice:Kitchen/admineditcat.html.twig', array(
            'form' => $form->createView(),
            'catkit' => $catkit,
            'articlekit' => $articlekit,
        ));

    }

    public function editarticleAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository('AppBundle:Articlekitchen')->find($id);
        $catkit = $this->getDoctrine()->getRepository('AppBundle:CatKitchen')->findAll();
        $articlekit = $this->getDoctrine()->getRepository('AppBundle:Articlekitchen')->findBy(array(),array('date' => 'DESC'));
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
            ->add('content2', TextareaType::Class, ['required'=>false])
            ->add('content3', TextareaType::Class, ['required'=>false])
            ->add('catkitchen', EntityType::class, array(
                // query choices from this entity
                'class' => 'AppBundle:CatKitchen',
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

            return $this->redirect($this->generateUrl('jamilati_admin_kitchen'));

        }

        return $this->render('AppBundle:Backoffice:Kitchen/admineditarticle.html.twig', array(
            'form' => $form->createView(),
            'catkit' => $catkit,
            'articlekit' => $articlekit,
        ));

    }

    public function removecatAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $cat = $em->getRepository('AppBundle:CatKitchen')->find($id);

        if (!$cat) {
            throw $this->createNotFoundException(
                'Aucune catégorie trouvée avec cet id '.$id
            );
        }

        $request->getSession()->getFlashBag()->add('danger', 'Catégorie supprimée !');
        $em->remove($cat);
        $em->flush();
        return $this->redirect($this->generateUrl('jamilati_admin_kitchen'));

    }

    public function removearticleAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository('AppBundle:Articlekitchen')->find($id);

        if (!$article) {
            throw $this->createNotFoundException(
                'Aucun Article trouvée avec cet id '.$id
            );
        }

        $request->getSession()->getFlashBag()->add('danger', 'Article supprimé !');
        $em->remove($article);
        $em->flush();
        return $this->redirect($this->generateUrl('jamilati_admin_kitchen'));

    }

    public function publishAction($id, Request $request){
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository('AppBundle:Articlekitchen')->find($id);

        if (!$article) {
            throw $this->createNotFoundException(
                'Aucun Article trouvée avec cet id '.$id
            );
        }

        $request->getSession()->getFlashBag()->add('success', 'Article publié !');
        $article->setIsPublished(1);
        $em->persist($article);
        $em->flush();
        return $this->redirect($this->generateUrl('jamilati_admin_kitchen'));
    }

    public function unpublishAction($id, Request $request){
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository('AppBundle:Articlekitchen')->find($id);

        if (!$article) {
            throw $this->createNotFoundException(
                'Aucun Article trouvée avec cet id '.$id
            );
        }

        $request->getSession()->getFlashBag()->add('success', "Article n'est plus publié !");
        $article->setIsPublished(0);
        $em->persist($article);
        $em->flush();
        return $this->redirect($this->generateUrl('jamilati_admin_kitchen'));
    }

}