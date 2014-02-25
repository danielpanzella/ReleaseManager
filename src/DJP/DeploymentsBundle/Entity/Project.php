<?php

namespace DJP\DeploymentsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Project
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="DJP\DeploymentsBundle\Entity\ProjectRepository")
 */
class Project
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
     * @Assert\NotBlank()
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var Role[]
     *
     * @ORM\OneToMany(targetEntity="Role", mappedBy="project")
     */
    private $roles;

    /**
     * @var Environment[]
     *
     * @ORM\OneToMany(targetEntity="Environment", mappedBy="project")
     */
    private $environemnts;

    /**
     * @var Server[]
     *
     * @ORM\OneToMany(targetEntity="Server", mappedBy="project")
     */
    private $servers;

    /**
     * @var Build[]
     *
     * @ORM\OneToMany(targetEntity="Build", mappedBy="project")
     */
    private $builds;

    /**
     * @var Deployment[]
     *
     * @ORM\OneToMany(targetEntity="Environment", mappedBy="project")
     */
    private $deployments;

    /**
     * @var Source[]
     *
     * @ORM\OneToMany(targetEntity="Source", mappedBy="project")
     */
    private $sources;


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
     * @return Project
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
     * @param \DJP\DeploymentsBundle\Entity\Build[] $builds
     */
    public function setBuilds($builds)
    {
        $this->builds = $builds;
    }

    /**
     * @return \DJP\DeploymentsBundle\Entity\Build[]
     */
    public function getBuilds()
    {
        return $this->builds;
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
     * @param \DJP\DeploymentsBundle\Entity\Environment[] $environemnts
     */
    public function setEnvironemnts($environemnts)
    {
        $this->environemnts = $environemnts;
    }

    /**
     * @return \DJP\DeploymentsBundle\Entity\Environment[]
     */
    public function getEnvironemnts()
    {
        return $this->environemnts;
    }

    /**
     * @param \DJP\DeploymentsBundle\Entity\Role[] $roles
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;
    }

    /**
     * @return \DJP\DeploymentsBundle\Entity\Role[]
     */
    public function getRoles()
    {
        return $this->roles;
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

    /**
     * @param \DJP\DeploymentsBundle\Entity\Source[] $sources
     */
    public function setSources($sources)
    {
        $this->sources = $sources;
    }

    /**
     * @return \DJP\DeploymentsBundle\Entity\Source[]
     */
    public function getSources()
    {
        return $this->sources;
    }

    public function __toString()
    {
        return $this->name;
    }
}
