<?php

namespace DJP\DeploymentsBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\FOSRestController;
use DJP\DeploymentsBundle\Entity\Environment;
use DJP\DeploymentsBundle\Form\EnvironmentType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class EnvironmentsController extends FOSRestController
{
    /**
     * @Rest\View()
     */
    public function getEnvironmentsAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('DJPDeploymentsBundle:Environment')->findAll();

        return $entities;
    }

    public function postEnvironmentAction(Request $request)
    {
        return $this->processForm(new Environment(), $request);
    }

    /**
     * @Rest\View()
     */
    public function getEnvironmentAction(Environment $environment)
    {
        if (!$environment) {
            throw $this->createNotFoundException('Unable to find Environment.');
        }

        return $environment;
    }

    /**
     * @Rest\View()
     */
    public function putEnvironmentAction(Request $request, Environment $environment)
    {
        return $this->processForm($environment, $request);
    }

    /**
     * @Rest\View(statusCode=204)
     */
    public function deleteEnvironmentAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('DJPDeploymentsBundle:Environment')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Environment.');
        }

        $em->remove($entity);
        $em->flush();
    }

    /**
     * Creates a form to edit a Environment entity.
     *
     * @param Environment $environment The entity
     * @param Request $request The HTTP request
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function processForm(Environment $environment, Request $request)
    {
        $statusCode = $environment->getId() ? 204 : 201;

        $form = $this->createForm(new EnvironmentType(), $environment);
        //$form->handleRequest($request);
        $form->submit($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($environment);
            $em->flush();

            $response = new Response();
            $response->setStatusCode($statusCode);
            if (201 == $statusCode) {
                $response->headers->set(
                    "Location",
                    $this->generateUrl(
                        'deploy_get_environment',
                        array('environment' => $environment->getId())
                    )
                );
            }
            return $response;
        }

        return View::create($form, 400);
    }
}
