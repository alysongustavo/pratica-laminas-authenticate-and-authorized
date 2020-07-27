<?php


namespace Admin\Entity;

use Doctrine\ORM\Mapping as ORM;
use Laminas\Hydrator\ClassMethods;

/**
 * Class Privilege
 * @package Admin\Entity
 * @ORM\Entity(repositoryClass="\Admin\Repository\PrivilegeRepository")
 * @ORM\Table(name="privilege")
 */
class Privilege
{

    /**
     * @var integer
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var Resource
     *
     * @ORM\ManyToOne(targetEntity="Admin\Entity\Resource")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="resource_id", referencedColumnName="id", onDelete="CASCADE", nullable=false)
     * })
     */
    private $resource;

    /**
     * @var Role
     *
     * @ORM\ManyToOne(targetEntity="Admin\Entity\Role")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="role_id", referencedColumnName="id", onDelete="CASCADE", nullable=false)
     * })
     */
    private $role;

    /**
     * @var string
     *
     * @ORM\Column(name="permissions", type="text", nullable=false)
     */
    private $permissions;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="date_created", nullable=false)
     */
    private $dateCreated;

    /**
     * @var DateTime
     * @ORM\Column(name="date_updated", nullable=false)
     */
    private $dateUpdated;

    public function __construct(array $data)
    {
        $this->dateCreated = (new \DateTime("now"))->format('Y-m-d h:m:s');
        $this->dateUpdated = (new \DateTime("now"))->format('Y-m-d h:m:s');

        $hydrator = new ClassMethods();
        $hydrator->hydrate($data, $this);
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getResource()
    {
        return $this->resource;
    }

    /**
     * @param mixed $resource
     */
    public function setResource($resource): void
    {
        $this->resource = $resource;
    }

    /**
     * @return mixed
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param mixed $role
     */
    public function setRole($role): void
    {
        $this->role = $role;
    }

    /**
     * @return mixed
     */
    public function getPermissions()
    {
        return $this->permissions;
    }

    /**
     * @param mixed $permissions
     */
    public function setPermissions($permissions): void
    {
        $this->permissions = $permissions;
    }

    /**
     * @return mixed
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    /**
     * @param mixed $dateCreated
     */
    public function setDateCreated($dateCreated): void
    {
        $this->dateCreated = $dateCreated;
    }

    /**
     * @return mixed
     */
    public function getDateUpdated()
    {
        return $this->dateUpdated;
    }

    /**
     * @param mixed $dateUpdated
     */
    public function setDateUpdate($dateUpdated): void
    {
        $this->dateUpdated = $dateUpdated;
    }

}