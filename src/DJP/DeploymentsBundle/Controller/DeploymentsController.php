<?php

namespace DJP\DeploymentsBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\FOSRestController;
use DJP\DeploymentsBundle\Entity\Deployment;
use DJP\DeploymentsBundle\Form\DeploymentType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Dokapi\DokapiRest\Annotation\Resource;

/**
 * DeploymentsController
 *
 * @Resource("Deployment")
 */
class DeploymentsController extends FOSRestController
{
    /**
     * @Rest\View()
     */
    public function getDeploymentsAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('DJPDeploymentsBundle:Deployment')->findAll();

        return $entities;
    }

    public function postDeploymentAction(Request $request)
    {
        return $this->processForm(new Deployment(), $request);
    }

    /**
     * @Rest\View()
     */
    public function getDeploymentAction(Deployment $deployment)
    {
        if (!$deployment) {
            throw $this->createNotFoundException('Unable to find Deployment.');
        }

        return $deployment;
    }

    /**
     * @Rest\View()
     */
    public function putDeploymentAction(Request $request, Deployment $deployment)
    {
        return $this->processForm($deployment, $request);
    }

    /**
     * @Rest\View(statusCode=204)
     */
    public function deleteDeploymentAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('DJPDeploymentsBundle:Deployment')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Deployment.');
        }

        $em->remove($entity);
        $em->flush();
    }

    /**
     * Creates a form to edit a Deployment entity.
     *
     * @param Deployment $deployment The entity
     * @param Request $request The HTTP request
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function processForm(Deployment $deployment, Request $request)
    {
        $statusCode = $deployment->getId() ? 204 : 201;

        $form = $this->createForm(new DeploymentType(), $deployment);
        //$form->handleRequest($request);
        $form->submit($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($deployment);
            $em->flush();

            $response = new Response();
            $response->setStatusCode($statusCode);
            if (201 == $statusCode) {
                $response->headers->set(
                    "Location",
                    $this->generateUrl(
                        'deploy_get_deployment',
                        array('deployment' => $deployment->getId())
                    )
                );
            }
            return $response;
        }

        return View::create($form, 400);
    }
}
