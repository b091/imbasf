<?php

namespace Imbax\CMSBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $pages = $em->getRepository('ImbaxCMSBundle:Page')->findAll();

        return $this->render('ImbaxCMSBundle:Default:index.html.twig', [
            'pages' => $pages
        ]);
    }


    public function displayAction($id)
    {

        $em = $this->getDoctrine()->getManager();
        $page = $em->getRepository('ImbaxCMSBundle:Page')->find($id);

        return $this->render('ImbaxCMSBundle:Default:display.html.twig', [
            'page' => $page
        ]);
    }
}
