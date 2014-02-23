<?php

namespace DJP\DeploymentsBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use DJP\DeploymentsBundle\Entity\Deployment;
use DJP\DeploymentsBundle\Form\DeploymentType;

/**
 * Deployment controller.
 *
 * @Route("/deployment")
 */
class DeploymentController extends Controller
{

    /**
     * Lists all Deployment entities.
     *
     * @Route("/", name="deployment")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('DJPDeploymentsBundle:Deployment')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Deployment entity.
     *
     * @Route("/", name="deployment_create")
     * @Method("POST")
     * @Template("DJPDeploymentsBundle:Deployment:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Deployment();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('deployment_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a Deployment entity.
    *
    * @param Deployment $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Deployment $entity)
    {
        $form = $this->createForm(new DeploymentType(), $entity, array(
            'action' => $this->generateUrl('deployment_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Deployment entity.
     *
     * @Route("/new", name="deployment_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Deployment();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Deployment entity.
     *
     * @Route("/{id}", name="deployment_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DJPDeploymentsBundle:Deployment')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Deployment entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Deployment entity.
     *
     * @Route("/{id}/edit", name="deployment_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DJPDeploymentsBundle:Deployment')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Deployment entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Deployment entity.
     *
     * @Route("/{id}/run", name="deployment_run")
     * @Method("GET")
     * @Template()
     */
    public function runAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DJPDeploymentsBundle:Deployment')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Deployment entity.');
        }

        $entity->performDeployment();

        return ['entity' => print_r(\Doctrine\Common\Util\Debug::export($entity, 3), true)];
    }

    /**
    * Creates a form to edit a Deployment entity.
    *
    * @param Deployment $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Deployment $entity)
    {
        $form = $this->createForm(new DeploymentType(), $entity, array(
            'action' => $this->generateUrl('deployment_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Deployment entity.
     *
     * @Route("/{id}", name="deployment_update")
     * @Method("PUT")
     * @Template("DJPDeploymentsBundle:Deployment:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DJPDeploymentsBundle:Deployment')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Deployment entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('deployment_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Deployment entity.
     *
     * @Route("/{id}", name="deployment_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('DJPDeploymentsBundle:Deployment')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Deployment entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('deployment'));
    }

    /**
     * Creates a form to delete a Deployment entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('deployment_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
