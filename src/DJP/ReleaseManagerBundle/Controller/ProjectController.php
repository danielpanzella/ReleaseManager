<?php

namespace DJP\ReleaseManagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("/projects")
 * @Template()
 */
class ProjectController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {
        return array('name' => "");
    }

    /**
     * @Route("/edit")
     * @Template()
     */
    public function editAction()
    {
        return array('name' => "");
    }

    /**
     * @Route("/view")
     * @Template()
     */
    public function viewAction()
    {
        return array('name' => "");
    }

    /**
     * @Route("/new")
     * @Template()
     */
    public function newAction()
    {
        return array('name' => "");
    }

}
