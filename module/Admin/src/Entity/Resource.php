<?php


namespace Admin\Entity;

use Doctrine\ORM\Mapping as ORM;
use Laminas\Db\Sql\Ddl\Column\Datetime;
use Laminas\Hydrator\ClassMethods;

/**
 * Class Resource
 * @package Admin\Entity
 * @ORM\Entity(repositoryClass="\Admin\Repository\ResourceRepository")
 * @ORM\Table(name="resource")
 */
class Resource
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
     * @ORM\Column(type="string", length=100, nullable=false, unique=true)
     */
    private $name;

    /**
     * @var string
     * @ORM\Column(type="text", nullable=false)
     */
    private $description;

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