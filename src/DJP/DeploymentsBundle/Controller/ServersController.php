<?php

namespace DJP\DeploymentsBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\FOSRestController;
use DJP\DeploymentsBundle\Entity\Server;
use DJP\DeploymentsBundle\Form\ServerType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class ServersController extends FOSRestController
{
    /**
     * @Rest\View()
     */
    public function getServersAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('DJPDeploymentsBundle:Server')->findAll();

        return $entities;
    }

    public function postServerAction(Request $request)
    {
        return $this->processForm(new Server(), $request);
    }

    /**
     * @Rest\View()
     */
    public function getServerAction(Server $server)
    {
        if (!$server) {
            throw $this->createNotFoundException('Unable to find Server.');
        }

        return $server;
    }

    /**
     * @Rest\View()
     */
    public function putServerAction(Request $request, Server $server)
    {
        return $this->processForm($server, $request);
    }

    /**
     * @Rest\View(statusCode=204)
     */
    public function deleteServerAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('DJPDeploymentsBundle:Server')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Server.');
        }

        $em->remove($entity);
        $em->flush();
    }

    /**
     * Creates a form to edit a Server entity.
     *
     * @param Server $server The entity
     * @param Request $request The HTTP request
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function processForm(Server $server, Request $request)
    {
        $statusCode = $server->getId() ? 204 : 201;

        $form = $this->createForm(new ServerType(), $server);
        //$form->handleRequest($request);
        $form->submit($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($server);
            $em->flush();

            $response = new Response();
            $response->setStatusCode($statusCode);
            if (201 == $statusCode) {
                $response->headers->set(
                    "Location",
                    $this->generateUrl(
                        'deploy_get_server',
                        array('server' => $server->getId())
                    )
                );
            }
            return $response;
        }

        return View::create($form, 400);
    }
}
