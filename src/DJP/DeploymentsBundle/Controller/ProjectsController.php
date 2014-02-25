<?php

namespace DJP\DeploymentsBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\FOSRestController;
use DJP\DeploymentsBundle\Entity\Project;
use DJP\DeploymentsBundle\Form\ProjectType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

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
            throw $this->createNotFoundException('Unable to find Project entity.');
        }

        return $project;
    }

    /**
     * @Rest\View()
     */
    public function putProjectAction($request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DJPDeploymentsBundle:Project')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Project entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('project_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * @Rest\View()
     */
    public function deleteProjectAction($id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('DJPDeploymentsBundle:Project')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Project entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('project'));
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
        $form = $this->createForm(new ProjectType(), $project, array());
        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($project);
            $em->flush();

            return new Response(
                null,
                201,
                array(
                    "Location" => $this->generateUrl('api_post_project', array('id' => $project->getId()))
                )
            );
        }

        return print_r($form);//View::create($form, 400);
    }
}
