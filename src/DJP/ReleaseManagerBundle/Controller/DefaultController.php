<?php

namespace DJP\ReleaseManagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Default ReleaseManager controller.
 *
 * @Route("/")
 */
class DefaultController extends Controller
{
    /**
     * Displays the home page
     *
     * @Route("/", name="home")
     * @Method("GET")
     * @Template()
     */
    public function indexAction($name = "World")
    {
        return array('name' => $name);
    }
}
