<?php

namespace DJP\DeploymentsBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use DJP\DeploymentsBundle\Entity\Build;
use DJP\DeploymentsBundle\Form\BuildType;

/**
 * Build controller.
 *
 * @Route("/build")
 */
class BuildController extends Controller
{

    /**
     * Lists all Build entities.
     *
     * @Route("/", name="build")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('DJPDeploymentsBundle:Build')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Build entity.
     *
     * @Route("/", name="build_create")
     * @Method("POST")
     * @Template("DJPDeploymentsBundle:Build:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Build();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('build_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a Build entity.
    *
    * @param Build $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Build $entity)
    {
        $form = $this->createForm(new BuildType(), $entity, array(
            'action' => $this->generateUrl('build_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Build entity.
     *
     * @Route("/new", name="build_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Build();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Build entity.
     *
     * @Route("/{id}", name="build_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DJPDeploymentsBundle:Build')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Build entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Build entity.
     *
     * @Route("/{id}/edit", name="build_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DJPDeploymentsBundle:Build')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Build entity.');
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
    * Creates a form to edit a Build entity.
    *
    * @param Build $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Build $entity)
    {
        $form = $this->createForm(new BuildType(), $entity, array(
            'action' => $this->generateUrl('build_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Build entity.
     *
     * @Route("/{id}", name="build_update")
     * @Method("PUT")
     * @Template("DJPDeploymentsBundle:Build:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DJPDeploymentsBundle:Build')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Build entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('build_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Build entity.
     *
     * @Route("/{id}", name="build_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('DJPDeploymentsBundle:Build')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Build entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('build'));
    }

    /**
     * Creates a form to delete a Build entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('build_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
