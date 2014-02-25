<?php

namespace DJP\DeploymentsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Server
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="DJP\DeploymentsBundle\Entity\ServerRepository")
 */
class Server
{
    const AUTH_SSH_KEY = 'key';
    const AUTH_PASSWORD = 'pass';

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
     * @ORM\Column(name="hostname", type="string", length=64)
     */
    private $hostname;

    /**
     * @var string
     *
     * @ORM\Column(name="ipAddress", type="string", length=15)
     */
    private $ipAddress;

    /**
     * @var string
     *
     * @ORM\Column(name="deployUser", type="string", length=32)
     */
    private $deployUser;

    /**
     * @var string
     *
     * @ORM\Column(name="deployGroup", type="string", length=32)
     */
    private $deployGroup;

    /**
     * @var string Specifies whether to authenticate with this server using an ssh key or password
     *
     * @ORM\Column(name="authType", type="string", length=4)
     */
    private $authType;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="text")
     */
    private $password;

    /**
     * @var Project
     *
     * @ORM\ManyToOne(targetEntity="Project", inversedBy="servers")
     */
    private $project;

    /**
     * @var Role[]
     *
     * @ORM\ManyToMany(targetEntity="Role", inversedBy="servers")
     */
    private $roles;

    /**
     * @var Environment
     *
     * @ORM\ManyToOne(targetEntity="Environment", inversedBy="servers")
     */
    private $environment;

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
     * Set hostname
     *
     * @param string $hostname
     * @return Server
     */
    public function setHostname($hostname)
    {
        $this->hostname = $hostname;

        return $this;
    }

    /**
     * Get hostname
     *
     * @return string 
     */
    public function getHostname()
    {
        return $this->hostname;
    }

    /**
     * Set ipAddress
     *
     * @param string $ipAddress
     * @return Server
     */
    public function setIpAddress($ipAddress)
    {
        $this->ipAddress = $ipAddress;

        return $this;
    }

    /**
     * Get ipAddress
     *
     * @return string 
     */
    public function getIpAddress()
    {
        return $this->ipAddress;
    }

    /**
     * @param string $authType
     */
    public function setAuthType($authType)
    {
        $this->authType = $authType;
    }

    /**
     * @return string
     */
    public function getAuthType()
    {
        return $this->authType;
    }

    /**
     * @param string $deployUser
     */
    public function setDeployUser($deployUser)
    {
        $this->deployUser = $deployUser;
    }

    /**
     * @return string
     */
    public function getDeployUser()
    {
        return $this->deployUser;
    }

    /**
     * @param string $deployGroup
     */
    public function setDeployGroup($deployGroup)
    {
        $this->deployGroup = $deployGroup;
    }

    /**
     * @return string
     */
    public function getDeployGroup()
    {
        return $this->deployGroup;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
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

    public function deploy()
    {
        $deployer = deployer(false, array());
        $roles = $this->getRoles();
        $tasks = [];

        if ($this->authType == self::AUTH_SSH_KEY) {
            $password = new \Crypt_RSA();
            $password->loadKey($this->password);
        } else {
            $password = $this->password;
        }

        $deployer->connect(
            $this->ipAddress,
            $this->deployUser,
            $password
        );

        $deployer->run("touch imhere");



        foreach($roles as $role) {
            $tmpTasks = $role->getTasks();
            foreach ($tmpTasks as $task) {
                $tasks[] = $task;
            }
        }

        foreach ($tasks as $task) {
            $command = $task->getCommandType();
            $args = $task->getCommandArguments();

            if (method_exists($deployer, $command)) {
                call_user_func_array(array($deployer, $command), $args);
            }
        }
    }

    public function __toString()
    {
        return $this->hostname;
    }

}
