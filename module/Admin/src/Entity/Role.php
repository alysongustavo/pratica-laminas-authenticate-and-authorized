<?php


namespace Admin\Entity;

use Doctrine\ORM\Mapping as ORM;
use Laminas\Db\Sql\Ddl\Column\Datetime;
use Laminas\Hydrator\ClassMethods;

/**
 * Class Role
 * @package Admin\Entity
 * @ORM\Entity(repositoryClass="\Admin\Repository\RoleRepository")
 * @ORM\Table(name="role")
 */
class Role
{

    /**
     * @var integer
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=128, nullable=false, unique=true)
     */
    private $name;

    /**
     * @var string
     * @ORM\Column(type="text", nullable=false)
     */
    private $description;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $layout;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $redirect;

    /**
     * @var integer
     * @ORM\Column(type="integer", length=1, nullable=true)
     */
    private $developer;

    /**
     * @var Datetime
     * @ORM\Column(name="date_created", nullable=false)
     */
    private $dateCreated;

    /**
     * @var Datetime
     * @ORM\Column(name="date_updated", nullable=false)
     */
    private $dateUpdated;

    /**
     * @var Role
     * @ORM\ManyToOne(targetEntity="\Admin\Entity\Role")
     * @ORM\JoinColumns({
     *  @ORM\JoinColumn(name="parent_id", referencedColumnName="id", onDelete="SET NULL", nullable=true)
     * })
     */
    private $parent;

    public function __construct(array $data)
    {
        $this->dateCreated = (new \DateTime("now"))->format('Y-m-d h:m:s');
        $this->dateUpdated = (new \DateTime("now"))->format('Y-m-d h:m:s');
        $this->redirect = 'admin';

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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description): void
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getLayout()
    {
        return $this->layout;
    }

    /**
     * @param mixed $layout
     */
    public function setLayout($layout): void
    {
        $this->layout = $layout;
    }

    /**
     * @return mixed
     */
    public function getRedirect()
    {
        return $this->redirect;
    }

    /**
     * @param mixed $redirect
     */
    public function setRedirect($redirect): void
    {
        $this->redirect = $redirect;
    }

    /**
     * @return mixed
     */
    public function getDeveloper()
    {
        return $this->developer;
    }

    /**
     * @param mixed $developer
     */
    public function setDeveloper($developer): void
    {
        $this->developer = $developer;
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

    /**
     * @return mixed
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param mixed $parent
     */
    public function setParent($parent): void
    {
        $this->parent = $parent;
    }

}