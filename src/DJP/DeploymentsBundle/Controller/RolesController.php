<?php

namespace DJP\DeploymentsBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\FOSRestController;
use DJP\DeploymentsBundle\Entity\Role;
use DJP\DeploymentsBundle\Form\RoleType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Dokapi\DokapiRest\Annotation\Resource;

/**
 * RolesController
 *
 * @Resource("Role")
 */
class RolesController extends FOSRestController
{
    /**
     * @Rest\View()
     */
    public function getRolesAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('DJPDeploymentsBundle:Role')->findAll();

        return $entities;
    }

    public function postRoleAction(Request $request)
    {
        return $this->processForm(new Role(), $request);
    }

    /**
     * @Rest\View()
     */
    public function getRoleAction(Role $role)
    {
        if (!$role) {
            throw $this->createNotFoundException('Unable to find Role.');
        }

        return $role;
    }

    /**
     * @Rest\View()
     */
    public function putRoleAction(Request $request, Role $role)
    {
        return $this->processForm($role, $request);
    }

    /**
     * @Rest\View(statusCode=204)
     */
    public function deleteRoleAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('DJPDeploymentsBundle:Role')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Role.');
        }

        $em->remove($entity);
        $em->flush();
    }

    /**
     * Creates a form to edit a Role entity.
     *
     * @param Role $role The entity
     * @param Request $request The HTTP request
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function processForm(Role $role, Request $request)
    {
        $statusCode = $role->getId() ? 204 : 201;

        $form = $this->createForm(new RoleType(), $role);
        //$form->handleRequest($request);
        $form->submit($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($role);
            $em->flush();

            $response = new Response();
            $response->setStatusCode($statusCode);
            if (201 == $statusCode) {
                $response->headers->set(
                    "Location",
                    $this->generateUrl(
                        'deploy_get_role',
                        array('role' => $role->getId())
                    )
                );
            }
            return $response;
        }

        return View::create($form, 400);
    }
}
