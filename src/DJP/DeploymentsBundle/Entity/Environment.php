<?php

namespace DJP\DeploymentsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Environment
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="DJP\DeploymentsBundle\Entity\EnvironmentRepository")
 */
class Environment
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
     * @ORM\ManyToOne(targetEntity="Project", inversedBy="environments")
     */
    private $project;

    /**
     * @var Server[]
     *
     * @ORM\OneToMany(targetEntity="Server", mappedBy="environment")
     */
    private $servers;

    /**
     * @var Deployment[]
     *
     * @ORM\OneToMany(targetEntity="Deployment", mappedBy="environment")
     */
    private $deployments;



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
     * @return Environment
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
     * @param \DJP\DeploymentsBundle\Entity\Deployment[] $deployments
     */
    public function setDeployments($deployments)
    {
        $this->deployments = $deployments;
    }

    /**
     * @return \DJP\DeploymentsBundle\Entity\Deployment[]
     */
    public function getDeployments()
    {
        return $this->deployments;
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
     * @param \DJP\DeploymentsBundle\Entity\Server[] $servers
     */
    public function setServers($servers)
    {
        $this->servers = $servers;
    }

    /**
     * @return \DJP\DeploymentsBundle\Entity\Server[]
     */
    public function getServers()
    {
        return $this->servers;
    }

    public function __toString()
    {
        return $this->name;
    }
}
