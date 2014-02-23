<?php

namespace DJP\DeploymentsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Deployment
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="DJP\DeploymentsBundle\Entity\DeploymentRepository")
 */
class Deployment
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
     * @var \DateTime
     *
     * @ORM\Column(name="deployTime", type="datetime")
     */
    private $deployTime;

    /**
     * @var Project
     *
     * @ORM\ManyToOne(targetEntity="Project", inversedBy="deployments")
     */
    private $project;

    /**
     * @var Environment
     *
     * @ORM\ManyToOne(targetEntity="Environment", inversedBy="deployments")
     */
    private $environment;

    /**
     * @var Build
     *
     * @ORM\ManyToOne(targetEntity="Build", inversedBy="deployments")
     */
    private $build;


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
     * @return Deployment
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
     * Set deployTime
     *
     * @param \DateTime $deployTime
     * @return Deployment
     */
    public function setDeployTime($deployTime)
    {
        $this->deployTime = $deployTime;

        return $this;
    }

    /**
     * Get deployTime
     *
     * @return \DateTime 
     */
    public function getDeployTime()
    {
        return $this->deployTime;
    }

    /**
     * @param \DJP\DeploymentsBundle\Entity\Build $build
     */
    public function setBuild($build)
    {
        $this->build = $build;
    }

    /**
     * @return \DJP\DeploymentsBundle\Entity\Build
     */
    public function getBuild()
    {
        return $this->build;
    }

    /**
     * @param \DJP\DeploymentsBundle\Entity\Environment $environment
     */
    public function setEnvironment($environment)
    {
        $this->environment = $environment;
    }

    /**
     * @return \DJP\DeploymentsBundle\Entity\Environment
     */
    public function getEnvironment()
    {
        return $this->environment;
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

    public function __toString()
    {
        return $this->name;
    }

    public function performDeployment()
    {
        $servers = $this->getEnvironment()->getServers();
        foreach ($servers as $server) {
            $server->deploy();
        }
    }
}
