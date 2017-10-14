<?php
/**
 * Created by PhpStorm.
 * User: Mouncef
 * Date: 11/07/2017
 * Time: 21:00
 */

namespace AppBundle\Controller;


use AppBundle\Entity\DayPicture;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;

class DayImageController extends Controller
{

    public function indexAction()
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Unable to access this page!');
        $articledm = $this->getDoctrine()->getRepository('AppBundle:DayPicture')->findAll();
        return $this->render('AppBundle:Backoffice:DayImage/admindmpage.html.twig', array(
            'articledm' => $articledm,
        ));
    }


    public function addarticleAction(Request $request)
    {
        $articledm = $this->getDoctrine()->getRepository('AppBundle:DayPicture')->findAll();
        $articledaypic = new DayPicture();
        $articledaypic->setUpdatedAt(new \DateTime('now'));

        $form = $this->createFormBuilder($articledaypic)
            ->add('titre', TextType::Class)
            ->add('image', FileType::class, ['required' => false])
            ->add('comment', TextareaType::Class)
            ->getForm()
        ;

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $request->getSession()->getFlashBag()->add('success', 'Article crée avec succés !');
            $articledaypic = $form->getData();
            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            $em = $this->getDoctrine()->getManager();
            $em->persist($articledaypic);
            $em->flush();

            return $this->redirectToRoute('jamilati_admin_dm');
        }

        return $this->render('AppBundle:Backoffice:DayImage/adminaddarticledm.html.twig', array(
            'form' => $form->createView(),
            'articledm' => $articledm,
        ));
    }


    public function editarticleAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository('AppBundle:DayPicture')->find($id);
        $articledm = $this->getDoctrine()->getRepository('AppBundle:DayPicture')->findAll();

        if (!$article) {
            throw $this->createNotFoundException(
                'Aucun article trouvée avec cet id '.$id
            );
        }

        $article->setUpdatedAt(new \DateTime('now'));

        $form = $this->createFormBuilder($article)
            ->add('titre', TextType::Class)
            ->add('image', FileType::class, ['required' => false])
            ->add('comment', TextareaType::Class)
            ->getForm();

        if ($form->handleRequest($request)->isValid()) {
            $request->getSession()->getFlashBag()->add('warning', 'Article Modifié avec succés !');
            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();

            return $this->redirect($this->generateUrl('jamilati_admin_dm'));

        }

        return $this->render('AppBundle:Backoffice:DayImage/admineditarticle.html.twig', array(
            'form' => $form->createView(),
            'articledm' => $articledm,
        ));

    }


    public function removearticleAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository('AppBundle:DayPicture')->find($id);

        if (!$article) {
            throw $this->createNotFoundException(
                'Aucun Article trouvée avec cet id '.$id
            );
        }

        $request->getSession()->getFlashBag()->add('danger', 'Article supprimé !');
        $em->remove($article);
        $em->flush();
        return $this->redirect($this->generateUrl('jamilati_admin_dm'));

    }

}