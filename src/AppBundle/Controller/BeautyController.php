<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use AppBundle\Entity\CatBeauty;
use AppBundle\Entity\Articlebeauty;

class BeautyController extends Controller
{

    public function indexAction()
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Unable to access this page!');
        $catbeaut = $this->getDoctrine()->getRepository('AppBundle:CatBeauty')->findAll();
        $articlebeaut = $this->getDoctrine()->getRepository('AppBundle:Articlebeauty')->findBy(array(),array('date' => 'DESC'));
        return $this->render('AppBundle:Backoffice:Beauty/adminbeautypage.html.twig', array(
            'catbeaut' => $catbeaut,
            'articlebeaut' => $articlebeaut,
        ));
    }

    public function addcatAction(Request $request)
    {
        $catbeaut = $this->getDoctrine()->getRepository('AppBundle:CatBeauty')->findAll();
        $articlebeaut = $this->getDoctrine()->getRepository('AppBundle:Articlebeauty')->findBy(array(),array('date' => 'DESC'));
        $catbeauty = new CatBeauty();

        $form = $this->createFormBuilder($catbeauty)
            ->add('lib', TextType::Class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            // $form->getData() holds the submitted values
            // but, the original `$catmode` variable has also been updated
            $request->getSession()->getFlashBag()->add('success', 'Catégorie créée avec succés !');
            $catbeauty = $form->getData();
            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            $em = $this->getDoctrine()->getManager();
            $em->persist($catbeauty);
            $em->flush();

            return $this->redirectToRoute('jamilati_admin_beauty');
        }

        return $this->render('AppBundle:Backoffice:Beauty/adminaddbeauty.html.twig', array(
            'form' => $form->createView(),
            'articlebeaut' => $articlebeaut,
            'catbeaut' => $catbeaut,
        ));
    }

    public function addarticleAction(Request $request)
    {
        $catbeaut = $this->getDoctrine()->getRepository('AppBundle:CatBeauty')->findAll();
        $articlebeaut = $this->getDoctrine()->getRepository('AppBundle:Articlebeauty')->findBy(array(),array('date' => 'DESC'));
        $articlebeauty = new Articlebeauty();
        $articlebeauty->setUpdatedAt(new \DateTime('now'));
        $user = $this->get('security.token_storage')->getToken()->getUsername();

        $form = $this->createFormBuilder($articlebeauty)
            ->add('titre', TextType::Class)
            ->add('date', DateType::class, array(
                'widget' => 'single_text',
            ))

            ->add('content1', TextareaType::Class)
            ->add('content2', TextareaType::Class, ['required'=>false])
            ->add('content3', TextareaType::Class, ['required'=>false])
            ->add('catbeauty', EntityType::class, array(
                // query choices from this entity
                'class' => 'AppBundle:CatBeauty',
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
            $articlebeauty = $form->getData();
            $articlebeauty->setUser($user);
            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            $em = $this->getDoctrine()->getManager();
            $em->persist($articlebeauty);
            $em->flush();

            return $this->redirectToRoute('jamilati_admin_beauty');
        }

        return $this->render('AppBundle:Backoffice:Beauty/adminaddarticlebeauty.html.twig', array(
            'form' => $form->createView(),
            'articlebeaut' => $articlebeaut,
            'catbeaut' => $catbeaut,
        ));
    }

    public function editcatAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $cat = $em->getRepository('AppBundle:CatBeauty')->find($id);
        $catbeaut = $this->getDoctrine()->getRepository('AppBundle:CatBeauty')->findAll();
        $articlebeaut = $this->getDoctrine()->getRepository('AppBundle:Articlebeauty')->findBy(array(),array('date' => 'DESC'));

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

            return $this->redirect($this->generateUrl('jamilati_admin_beauty'));

        }

        return $this->render('AppBundle:Backoffice:Beauty/admineditcat.html.twig', array(
            'form' => $form->createView(),
            'catbeaut' => $catbeaut,
            'articlebeaut' => $articlebeaut,
        ));

    }

    public function editarticleAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository('AppBundle:Articlebeauty')->find($id);
        $catbeaut = $this->getDoctrine()->getRepository('AppBundle:CatBeauty')->findAll();
        $articlebeaut = $this->getDoctrine()->getRepository('AppBundle:Articlebeauty')->findBy(array(),array('date' => 'DESC'));

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
            ->add('catbeauty', EntityType::class, array(
                // query choices from this entity
                'class' => 'AppBundle:CatBeauty',
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

            return $this->redirect($this->generateUrl('jamilati_admin_beauty'));

        }

        return $this->render('AppBundle:Backoffice:Beauty/admineditarticle.html.twig', array(
            'form' => $form->createView(),
            'catbeaut' => $catbeaut,
            'articlebeaut' => $articlebeaut,
        ));

    }

    public function removecatAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $cat = $em->getRepository('AppBundle:CatBeauty')->find($id);

        if (!$cat) {
            throw $this->createNotFoundException(
                'Aucune catégorie trouvée avec cet id '.$id
            );
        }

        $request->getSession()->getFlashBag()->add('danger', 'Catégorie supprimée !');
        $em->remove($cat);
        $em->flush();
        return $this->redirect($this->generateUrl('jamilati_admin_beauty'));

    }

    public function removearticleAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository('AppBundle:Articlebeauty')->find($id);

        if (!$article) {
            throw $this->createNotFoundException(
                'Aucun Article trouvée avec cet id '.$id
            );
        }

        $request->getSession()->getFlashBag()->add('danger', 'Article supprimé !');
        $em->remove($article);
        $em->flush();
        return $this->redirect($this->generateUrl('jamilati_admin_beauty'));

    }

    public function publishAction($id, Request $request){
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository('AppBundle:Articlebeauty')->find($id);

        if (!$article) {
            throw $this->createNotFoundException(
                'Aucun Article trouvée avec cet id '.$id
            );
        }

        $request->getSession()->getFlashBag()->add('success', 'Article publié !');
        $article->setIsPublished(1);
        $em->persist($article);
        $em->flush();
        return $this->redirect($this->generateUrl('jamilati_admin_beauty'));
    }

    public function unpublishAction($id, Request $request){
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository('AppBundle:Articlebeauty')->find($id);

        if (!$article) {
            throw $this->createNotFoundException(
                'Aucun Article trouvée avec cet id '.$id
            );
        }

        $request->getSession()->getFlashBag()->add('success', "Article n'est plus publié !");
        $article->setIsPublished(0);
        $em->persist($article);
        $em->flush();
        return $this->redirect($this->generateUrl('jamilati_admin_beauty'));
    }
}
