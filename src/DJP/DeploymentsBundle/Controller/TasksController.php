<?php

namespace DJP\DeploymentsBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\FOSRestController;
use DJP\DeploymentsBundle\Entity\Task;
use DJP\DeploymentsBundle\Form\TaskType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Dokapi\DokapiRest\Annotation\Resource;

/**
 * TasksController
 *
 * @Resource("Task")
 */
class TasksController extends FOSRestController
{
    /**
     * @Rest\View()
     */
    public function getTasksAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('DJPDeploymentsBundle:Task')->findAll();

        return $entities;
    }

    public function postTaskAction(Request $request)
    {
        return $this->processForm(new Task(), $request);
    }

    /**
     * @Rest\View()
     */
    public function getTaskAction(Task $task)
    {
        if (!$task) {
            throw $this->createNotFoundException('Unable to find Task.');
        }

        return $task;
    }

    /**
     * @Rest\View()
     */
    public function putTaskAction(Request $request, Task $task)
    {
        return $this->processForm($task, $request);
    }

    /**
     * @Rest\View(statusCode=204)
     */
    public function deleteTaskAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('DJPDeploymentsBundle:Task')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Task.');
        }

        $em->remove($entity);
        $em->flush();
    }

    /**
     * Creates a form to edit a Task entity.
     *
     * @param Task $task The entity
     * @param Request $request The HTTP request
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function processForm(Task $task, Request $request)
    {
        $statusCode = $task->getId() ? 204 : 201;

        $form = $this->createForm(new TaskType(), $task);
        //$form->handleRequest($request);
        $form->submit($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($task);
            $em->flush();

            $response = new Response();
            $response->setStatusCode($statusCode);
            if (201 == $statusCode) {
                $response->headers->set(
                    "Location",
                    $this->generateUrl(
                        'deploy_get_task',
                        array('task' => $task->getId())
                    )
                );
            }
            return $response;
        }

        return View::create($form, 400);
    }
}
