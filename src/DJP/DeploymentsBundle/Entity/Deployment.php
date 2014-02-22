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
}
