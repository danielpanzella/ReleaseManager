<?php

namespace DJP\DeploymentsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Role
 *
 * @ORM\ Table()
 * @ORM\Entity(repositoryClass="DJP\DeploymentsBundle\Entity\RoleRepository")
 */
class Role
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
     * @var Project
     *
     * @ORM\ManyToOne(targetEntity="Project", inversedBy="roles")
     */
    private $project;

    /**
     * @var Tasks[]
     *
     * @ORM\ManyToMany(targetEntity="Task")
     */
    private $tasks;

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
     * @return Role
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
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

    /**
     * @param \DJP\DeploymentsBundle\Entity\Project $project
     */
    public function setProject($project)
    {
        $this->project = $project;
    }

    /**
     * @return \DJP\DeploymentsBundle\Entity\Project
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * @param \DJP\DeploymentsBundle\Entity\Tasks[] $tasks
     */
    public function setTasks($tasks)
    {
        $this->tasks = $tasks;
    }

    /**
     * @return \DJP\DeploymentsBundle\Entity\Tasks[]
     */
    public function getTasks()
    {
        return $this->tasks;
    }

    public function __toString()
    {
        return $this->name;
    }
}
