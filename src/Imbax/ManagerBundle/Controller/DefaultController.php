<?php

namespace Imbax\ManagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('ImbaxManagerBundle:Default:index.html.twig', array('name' => $name));
    }
}
