<?php


namespace Admin\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Laminas\Crypt\Password\Bcrypt;
use Laminas\Db\Sql\Ddl\Column\Datetime;
use Laminas\Hydrator\ClassMethods;

/**
 * Class User
 * @package Admin\Entity
 * @ORM\Entity(repositoryClass="\Admin\Repository\UserRepository")
 * @ORM\Table(name="user")
 */
class User
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;


    /**
     * @var integer
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var Role
     * @ORM\ManyToMany(targetEntity="Admin\Entity\Role")
     * @ORM\JoinColumns({
     *     @ORM\JoinColumn(name="role_id", referencedColumnName="id", nullable=false)
     * })
     */
    private $roles;

    /**
     * @var string
     * @ORM\Column(type="string", length=100 ,nullable=false)
     */
    private $name;

    /**
     * @var string
     * @ORM\Column(type="string", length=20, nullable=false)
     */
    private $cpf;

    /**
     * @var string
     * @ORM\Column(type="string", length=100, nullable=false, unique=true)
     */
    private $email;

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
     * @var string
     * @ORM\Column(name="pwd_reset_token", type="string", length=256, nullable=true)
     */
    private $pwdResetToken;

    /**
     * @var Datetime
     * @ORM\Column(name="pwd_reset_token_creation_date", type="datetime", nullable=true)
     */
    private $pwdResetTokenCreationDate;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $password;

    /**
     * @var integer
     * @ORM\Column(type="integer", length=11, nullable=false)
     */
    private $status;

    public function __construct(array $data)
    {
        $this->dateCreated = (new \DateTime("now"))->format('Y-m-d h:m:s');
        $this->dateUpdated = (new \DateTime("now"))->format('Y-m-d h:m:s');
        $this->status = User::STATUS_ACTIVE;
        $this->roles = new ArrayCollection();

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
     * @return Role
     */
    public function getRoles(): Role
    {
        return $this->roles;
    }

    /**
     * @param Role $role
     */
    public function addRole(Role $role): void
    {
        $this->roles[] = $role;
    }

    public function getRoleAsString(){
        $roleString = '';

        $roleCount = count($this->roles);

        $index = 0;

        foreach($this->roles as $role){

            if($index == $roleCount - 1)
                $roleString .= " " . $role->getName();
            else
                $roleString .= " | " . $role->getName();

            if(!is_null($role->getParent()) && $index == $roleCount - 1)
                $roleString .= " | " . $role->getParent()->getName();
            else if(!is_null($role->getParent()) && $index <> $roleCount - 1)
                $roleString .= " | " . $role->getParent()->getName();

            $index++;
        }


        return $roleString;

    }

    public function removeRoleAssociation(Role $role): void
    {
        $this->roles->removeElement($role);
    }

    /**
     * @return mixed
     */
    public function getCpf()
    {
        return $this->cpf;
    }

    /**
     * @param mixed $cpf
     */
    public function setCpf($cpf): void
    {
        $this->cpf = $cpf;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
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
    public function setDateUpdated($dateUpdated): void
    {
        $this->dateUpdated = $dateUpdated;
    }

    /**
     * @return mixed
     */
    public function getPwdResetToken()
    {
        return $this->pwdResetToken;
    }

    /**
     * @param mixed $pwdResetToken
     */
    public function setPwdResetToken($pwdResetToken): void
    {
        $this->pwdResetToken = $pwdResetToken;
    }

    /**
     * @return mixed
     */
    public function getPwdResetTokenCreationDate()
    {
        return $this->pwdResetTokenCreationDate;
    }

    /**
     * @param mixed $pwdResetTokenCreationDate
     */
    public function setPwdResetTokenCreationDate($pwdResetTokenCreationDate): void
    {
        $this->pwdResetTokenCreationDate = $pwdResetTokenCreationDate;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password): void
    {
        $this->password = $this->cryptPassword($password);
    }

    private function cryptPassword($password){
        $bcrypt = new Bcrypt();
        return $bcrypt->create($password);

    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status): void
    {
        $this->status = $status;
    }
}