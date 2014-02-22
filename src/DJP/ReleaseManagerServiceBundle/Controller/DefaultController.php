<?php

namespace DJP\ReleaseManagerServiceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('DJPReleaseManagerServiceBundle:Default:index.html.twig', array('name' => $name));
    }
}
