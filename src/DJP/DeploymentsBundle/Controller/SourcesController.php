<?php

namespace DJP\DeploymentsBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\FOSRestController;
use DJP\DeploymentsBundle\Entity\Source;
use DJP\DeploymentsBundle\Form\SourceType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class SourcesController extends FOSRestController
{
    /**
     * @Rest\View()
     */
    public function getSourcesAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('DJPDeploymentsBundle:Source')->findAll();

        return $entities;
    }

    public function postSourceAction(Request $request)
    {
        return $this->processForm(new Source(), $request);
    }

    /**
     * @Rest\View()
     */
    public function getSourceAction(Source $source)
    {
        if (!$source) {
            throw $this->createNotFoundException('Unable to find Source.');
        }

        return $source;
    }

    /**
     * @Rest\View()
     */
    public function putSourceAction(Request $request, Source $source)
    {
        return $this->processForm($source, $request);
    }

    /**
     * @Rest\View(statusCode=204)
     */
    public function deleteSourceAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('DJPDeploymentsBundle:Source')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Source.');
        }

        $em->remove($entity);
        $em->flush();
    }

    /**
     * Creates a form to edit a Source entity.
     *
     * @param Source $source The entity
     * @param Request $request The HTTP request
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function processForm(Source $source, Request $request)
    {
        $statusCode = $source->getId() ? 204 : 201;

        $form = $this->createForm(new SourceType(), $source);
        //$form->handleRequest($request);
        $form->submit($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($source);
            $em->flush();

            $response = new Response();
            $response->setStatusCode($statusCode);
            if (201 == $statusCode) {
                $response->headers->set(
                    "Location",
                    $this->generateUrl(
                        'deploy_get_source',
                        array('source' => $source->getId())
                    )
                );
            }
            return $response;
        }

        return View::create($form, 400);
    }
}
