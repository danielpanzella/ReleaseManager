<?php

namespace DJP\DeploymentsBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\FOSRestController;
use DJP\DeploymentsBundle\Entity\Project;
use DJP\DeploymentsBundle\Form\ProjectType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Dokapi\DokapiRest\Annotation\Resource;

/**
 * ProjectsController
 *
 * @Resource("Project")
 */
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

    public function postProjectAction(Request $request)
    {
        return $this->processForm(new Project(), $request);
    }

    /**
     * @Rest\View()
     */
    public function getProjectAction(Project $project)
    {
        if (!$project) {
            throw $this->createNotFoundException('Unable to find Project.');
        }

        return $project;
    }

    /**
     * @Rest\View()
     */
    public function putProjectAction(Request $request, Project $project)
    {
        return $this->processForm($project, $request);
    }

    /**
     * @Rest\View(statusCode=204)
     */
    public function deleteProjectAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('DJPDeploymentsBundle:Project')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Project.');
        }

        $em->remove($entity);
        $em->flush();
    }

    /**
     * Creates a form to edit a Project entity.
     *
     * @param Project $project The entity
     * @param Request $request The HTTP request
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function processForm(Project $project, Request $request)
    {
        $statusCode = $project->getId() ? 204 : 201;

        $form = $this->createForm(new ProjectType(), $project);
        //$form->handleRequest($request);
        $form->submit($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($project);
            $em->flush();

            $response = new Response();
            $response->setStatusCode($statusCode);
            if (201 == $statusCode) {
                $response->headers->set(
                    "Location",
                    $this->generateUrl(
                        'deploy_get_project',
                        array('project' => $project->getId())
                    )
                );
            }
            return $response;
        }

        return View::create($form, 400);
    }
}
