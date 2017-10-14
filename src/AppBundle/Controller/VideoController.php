<?php
/**
 * Created by PhpStorm.
 * User: Mouncef
 * Date: 05/07/2017
 * Time: 16:10
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Articlevideo;
use AppBundle\Entity\CatVideo;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;

class VideoController extends Controller
{
    public function indexAction()
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Unable to access this page!');
        $catvid = $this->getDoctrine()->getRepository('AppBundle:CatVideo')->findAll();
        $articlevid = $this->getDoctrine()->getRepository('AppBundle:Articlevideo')->findBy(array(),array('date' => 'DESC'));
        return $this->render('AppBundle:Backoffice:Video/adminvideopage.html.twig', array(
            'catvid' => $catvid,
            'articlevid' => $articlevid,
        ));
    }

    public function addcatAction(Request $request)
    {
        $catvid = $this->getDoctrine()->getRepository('AppBundle:CatVideo')->findAll();
        $articlevid = $this->getDoctrine()->getRepository('AppBundle:Articlevideo')->findBy(array(),array('date' => 'DESC'));

        $catvideo = new CatVideo();

        $form = $this->createFormBuilder($catvideo)
            ->add('lib', TextType::Class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            // $form->getData() holds the submitted values
            // but, the original `$catmode` variable has also been updated
            $request->getSession()->getFlashBag()->add('success', 'Catégorie créée avec succés !');
            $catvideo = $form->getData();
            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            $em = $this->getDoctrine()->getManager();
            $em->persist($catvideo);
            $em->flush();

            return $this->redirectToRoute('jamilati_admin_video');
        }

        return $this->render('AppBundle:Backoffice:Video/adminaddvideo.html.twig', array(
            'form' => $form->createView(),
            'articlevid' => $articlevid,
            'catvid' => $catvid,
        ));
    }

    public function addarticleAction(Request $request)
    {
        $catvid = $this->getDoctrine()->getRepository('AppBundle:CatVideo')->findAll();
        $articlevid = $this->getDoctrine()->getRepository('AppBundle:Articlevideo')->findBy(array(),array('date' => 'DESC'));
        $articlevideo = new Articlevideo();
        $user = $this->get('security.token_storage')->getToken()->getUsername();

        $form = $this->createFormBuilder($articlevideo)
            ->add('titre', TextType::Class)
            ->add('url', TextType::class)
            ->add('date', DateType::class, array(
                'widget' => 'single_text',
            ))
            ->add('content1', TextareaType::Class)
            ->add('content2', TextareaType::Class, ['required'=>false])
            ->add('content3', TextareaType::Class, ['required'=>false])
            ->add('catvideo', EntityType::class, array(
                // query choices from this entity
                'class' => 'AppBundle:CatVideo',
                // use the User.username property as the visible option string
                'choice_label' => 'lib',
            ))
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
            $request->getSession()->getFlashBag()->add('success', 'Vidéo crée avec succés !');
            $articlevideo = $form->getData();
            $articlevideo->setUser($user);
            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            $em = $this->getDoctrine()->getManager();
            $em->persist($articlevideo);
            $em->flush();

            return $this->redirectToRoute('jamilati_admin_video');
        }

        return $this->render('AppBundle:Backoffice:Video/adminaddarticlevideo.html.twig', array(
            'form' => $form->createView(),
            'articlevid' => $articlevid,
            'catvid' => $catvid,
        ));
    }

    public function editcatAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $cat = $em->getRepository('AppBundle:CatVideo')->find($id);
        $catvid = $this->getDoctrine()->getRepository('AppBundle:CatVideo')->findAll();
        $articlevid = $this->getDoctrine()->getRepository('AppBundle:Articlevideo')->findBy(array(),array('date' => 'DESC'));

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

            return $this->redirect($this->generateUrl('jamilati_admin_video'));

        }

        return $this->render('AppBundle:Backoffice:Video/admineditcat.html.twig', array(
            'form' => $form->createView(),
            'catvid' => $catvid,
            'articlevid' => $articlevid,
        ));

    }

    public function editarticleAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository('AppBundle:Articlevideo')->find($id);
        $catvid = $this->getDoctrine()->getRepository('AppBundle:CatVideo')->findAll();
        $articlevid = $this->getDoctrine()->getRepository('AppBundle:Articlevideo')->findBy(array(),array('date' => 'DESC'));
        if (!$article) {
            throw $this->createNotFoundException(
                'Aucun article trouvée avec cet id '.$id
            );
        }

        $form = $this->createFormBuilder($article)
            ->add('titre', TextType::Class)
            ->add('url', TextType::class)
            ->add('date', DateType::class, array(
                'widget' => 'single_text',
            ))
            ->add('content1', TextareaType::Class)
            ->add('content2', TextareaType::Class, ['required'=>false])
            ->add('content3', TextareaType::Class, ['required'=>false])
            ->add('catvideo', EntityType::class, array(
                // query choices from this entity
                'class' => 'AppBundle:CatVideo',
                // use the User.username property as the visible option string
                'choice_label' => 'lib',
            ))
            ->add('listtitre1', TextType::Class, ['required'=>false])
            ->add('listcontent1', TextType::Class, ['required'=>false])
            ->add('listtitre2', TextType::Class, ['required'=>false])
            ->add('listcontent2', TextType::Class, ['required'=>false])
            ->add('listtitre3', TextType::Class, ['required'=>false])
            ->add('listcontent3', TextType::Class, ['required'=>false])
            ->getForm();

        if ($form->handleRequest($request)->isValid()) {
            $request->getSession()->getFlashBag()->add('warning', 'Vidéo Modifié avec succés !');
            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();

            return $this->redirect($this->generateUrl('jamilati_admin_video'));

        }

        return $this->render('AppBundle:Backoffice:Video/admineditarticle.html.twig', array(
            'form' => $form->createView(),
            'catvid' => $catvid,
            'articlevid' => $articlevid,
        ));

    }

    public function removecatAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $cat = $em->getRepository('AppBundle:CatVideo')->find($id);

        if (!$cat) {
            throw $this->createNotFoundException(
                'Aucune catégorie trouvée avec cet id '.$id
            );
        }

        $request->getSession()->getFlashBag()->add('danger', 'Catégorie supprimée !');
        $em->remove($cat);
        $em->flush();
        return $this->redirect($this->generateUrl('jamilati_admin_video'));

    }

    public function removearticleAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository('AppBundle:Articlevideo')->find($id);

        if (!$article) {
            throw $this->createNotFoundException(
                'Aucun Article trouvée avec cet id '.$id
            );
        }

        $request->getSession()->getFlashBag()->add('danger', 'Vidéo supprimée !');
        $em->remove($article);
        $em->flush();
        return $this->redirect($this->generateUrl('jamilati_admin_video'));

    }

    public function publishAction($id, Request $request){
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository('AppBundle:Articlevideo')->find($id);

        if (!$article) {
            throw $this->createNotFoundException(
                'Aucun Article trouvée avec cet id '.$id
            );
        }

        $request->getSession()->getFlashBag()->add('success', 'Article publié !');
        $article->setIsPublished(1);
        $em->persist($article);
        $em->flush();
        return $this->redirect($this->generateUrl('jamilati_admin_video'));
    }

    public function unpublishAction($id, Request $request){
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository('AppBundle:Articlevideo')->find($id);

        if (!$article) {
            throw $this->createNotFoundException(
                'Aucun Article trouvée avec cet id '.$id
            );
        }

        $request->getSession()->getFlashBag()->add('success', "Article n'est plus publié !");
        $article->setIsPublished(0);
        $em->persist($article);
        $em->flush();
        return $this->redirect($this->generateUrl('jamilati_admin_video'));
    }
}