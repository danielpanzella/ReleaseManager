<?php

namespace DJP\DeploymentsBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\FOSRestController;
use DJP\DeploymentsBundle\Entity\Build;
use DJP\DeploymentsBundle\Form\BuildType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class BuildsController extends FOSRestController
{
    /**
     * @Rest\View()
     */
    public function getBuildsAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('DJPDeploymentsBundle:Build')->findAll();

        return $entities;
    }

    public function postBuildAction(Request $request)
    {
        return $this->processForm(new Build(), $request);
    }

    /**
     * @Rest\View()
     */
    public function getBuildAction(Build $build)
    {
        if (!$build) {
            throw $this->createNotFoundException('Unable to find Build.');
        }

        return $build;
    }

    /**
     * @Rest\View()
     */
    public function putBuildAction(Request $request, Build $build)
    {
        return $this->processForm($build, $request);
    }

    /**
     * @Rest\View(statusCode=204)
     */
    public function deleteBuildAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('DJPDeploymentsBundle:Build')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Build.');
        }

        $em->remove($entity);
        $em->flush();
    }

    /**
     * Creates a form to edit a Build entity.
     *
     * @param Build $build The entity
     * @param Request $request The HTTP request
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function processForm(Build $build, Request $request)
    {
        $statusCode = $build->getId() ? 204 : 201;

        $form = $this->createForm(new BuildType(), $build);
        //$form->handleRequest($request);
        $form->submit($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($build);
            $em->flush();

            $response = new Response();
            $response->setStatusCode($statusCode);
            if (201 == $statusCode) {
                $response->headers->set(
                    "Location",
                    $this->generateUrl(
                        'deploy_get_build',
                        array('build' => $build->getId())
                    )
                );
            }
            return $response;
        }

        return View::create($form, 400);
    }
}
