<?php

namespace DJP\DeploymentsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('DJPDeploymentsBundle:Default:index.html.twig', array('name' => $name));
    }
}
