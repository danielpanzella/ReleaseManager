<?php

namespace DJP\ReleaseManagerServiceBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use DJP\DeploymentsBundle\Entity\Project;

class ProjectsController extends FOSRestController
{
    /**
     * @Rest\View()
     */
    public function getProjectsAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('DJPDeploymentsBundle:Project')->findAll();

        return $entities;
    }

    public function postProjectAction()
    {

    }

    /**
     * @Rest\View()
     */
    public function getProjectAction(Project $project)
    {
        return $project;
    }

    /**
     * @Rest\View()
     */
    public function putProjectAction($id)
    {

    }
}
