<?php

namespace DJP\ReleaseManagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use DJP\DeploymentsBundle\Entity as Deploy;

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
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('DJPDeploymentsBundle:Project')->findAll();
        return array( "projects" => $entities);
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
     * @Route("/{project}")
     * @Template()
     */
    public function manageAction(Deploy\Project $project)
    {
        return $project;
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
