<?php

namespace DJP\UserManagementBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('DJPUserManagementBundle:Default:index.html.twig', array('name' => $name));
    }
}
