<?php

namespace DJP\ReleaseManagerServiceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Default ReleaseManager controller.
 *
 * @Route("/")
 */
class DefaultController extends Controller
{
    /**
     * @Route("/", name="rms_home")
     * @Method("GET")
     * @Template()
     */
    public function indexAction($name = "World")
    {
        return array('name' => $name);
    }
}
