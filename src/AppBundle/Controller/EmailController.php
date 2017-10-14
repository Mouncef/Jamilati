<?php
/**
 * Created by PhpStorm.
 * User: Mouncef
 * Date: 13/07/2017
 * Time: 00:42
 */

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class EmailController extends Controller
{
    public function indexAction(){
        $em = $this->getDoctrine()->getManager();
        $emails = $em->getRepository('AppBundle:Email')->findAll();

        return $this->render('AppBundle:Backoffice/Email:list.html.twig', [
            'emails' => $emails
        ]);
    }

}