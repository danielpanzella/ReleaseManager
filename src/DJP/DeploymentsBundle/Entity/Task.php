<?php

namespace DJP\DeploymentsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Task
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="DJP\DeploymentsBundle\Entity\TaskRepository")
 */
class Task
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var boolean
     *
     * @ORM\Column(name="isAssignable", type="boolean")
     */
    private $isAssignable;

    /**
     * @var string
     *
     * @ORM\Column(name="commandType", type="string", length=32)
     */
    private $commandType;

    /**
     * @var array
     *
     * @ORM\Column(name="commandArguments", type="json_array")
     */
    private $commandArguments;

    /**
     * @var Task[]
     *
     * @ORM\OneToMany(targetEntity="Task", mappedBy="parentTask")
     */
    private $subTasks;

    /**
     * @var Task
     *
     * @ORM\ManyToOne(targetEntity="Task", inversedBy="subTasks")
     */
    private $parentTask;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Task
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param boolean $isAssignable
     */
    public function setIsAssignable($isAssignable)
    {
        $this->isAssignable = $isAssignable;
    }

    /**
     * @return boolean
     */
    public function getIsAssignable()
    {
        return $this->isAssignable;
    }

    /**
     * @param array $commandArguments
     */
    public function setCommandArguments($commandArguments)
    {
        $this->commandArguments = $commandArguments;
    }

    /**
     * @return array
     */
    public function getCommandArguments()
    {
        return $this->commandArguments;
    }

    /**
     * @param string $commandType
     */
    public function setCommandType($commandType)
    {
        $this->commandType = $commandType;
    }

    /**
     * @return string
     */
    public function getCommandType()
    {
        return $this->commandType;
    }

    /**
     * @param \DJP\DeploymentsBundle\Entity\Task $parentTask
     */
    public function setParentTask($parentTask)
    {
        $this->parentTask = $parentTask;
    }

    /**
     * @return \DJP\DeploymentsBundle\Entity\Task
     */
    public function getParentTask()
    {
        return $this->parentTask;
    }

    /**
     * @param \DJP\DeploymentsBundle\Entity\Task[] $subTasks
     */
    public function setSubTasks($subTasks)
    {
        $this->subTasks = $subTasks;
    }

    /**
     * @return \DJP\DeploymentsBundle\Entity\Task[]
     */
    public function getSubTasks()
    {
        return $this->subTasks;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    public function __toString()
    {
        return $this->name;
    }
}
