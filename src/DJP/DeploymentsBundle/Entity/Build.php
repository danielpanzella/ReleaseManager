<?php

namespace DJP\DeploymentsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Build
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="DJP\DeploymentsBundle\Entity\BuildRepository")
 */
class Build
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
     * @ORM\Column(name="vcsRevisionId", type="string", length=255)
     */
    private $vcsRevisionId;

    /**
     * @var string
     *
     * @ORM\Column(name="vcsBranchId", type="string", length=64)
     */
    private $vcsBranchId;

    /**
     * @var Project
     *
     * @ORM\ManyToOne(targetEntity="Project", inversedBy="builds")
     */
    private $project;

    /**
     * @var Deployment[]
     *
     * @ORM\OneToMany(targetEntity="Deployment", mappedBy="build")
     */
    private $deployments;

    /**
     * @var Source
     *
     * @ORM\ManyToOne(targetEntity="Source", inversedBy="builds")
     */
    private $source;


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
     * Set vcsRevisionId
     *
     * @param string $vcsRevisionId
     * @return Build
     */
    public function setVcsRevisionId($vcsRevisionId)
    {
        $this->vcsRevisionId = $vcsRevisionId;

        return $this;
    }

    /**
     * Get vcsRevisionId
     *
     * @return string 
     */
    public function getVcsRevisionId()
    {
        return $this->vcsRevisionId;
    }

    /**
     * Set vcsBranchId
     *
     * @param string $vcsBranchId
     * @return Build
     */
    public function setVcsBranchId($vcsBranchId)
    {
        $this->vcsBranchId = $vcsBranchId;

        return $this;
    }

    /**
     * Get vcsBranchId
     *
     * @return string 
     */
    public function getVcsBranchId()
    {
        return $this->vcsBranchId;
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
     * @param \DJP\DeploymentsBundle\Entity\Source $source
     */
    public function setSource($source)
    {
        $this->source = $source;
    }

    /**
     * @return \DJP\DeploymentsBundle\Entity\Source
     */
    public function getSource()
    {
        return $this->source;
    }

    public function __toString()
    {
        return (string)$this->id;
    }
}
