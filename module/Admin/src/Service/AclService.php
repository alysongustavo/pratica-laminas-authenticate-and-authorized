<?php


namespace Admin\Service;


use Laminas\Permissions\Acl\Acl;
use Laminas\Permissions\Acl\Role\GenericRole as Role;
use Laminas\Permissions\Acl\Resource\GenericResource as Resource;

use Laminas\Permissions\Acl\Role\RoleInterface;
use Laminas\Permissions\Acl\Resource\ResourceInterface;

class AclService extends Acl
{

    protected $roles = [];

    protected $resources = [];

    protected $privileges = [];

    public function __construct(array $roles, array $resources, array $privileges)
    {
        $this->roles = $roles;
        $this->resources = $resources;
        $this->privileges = $privileges;
    }

    protected function loadRoles(){

        foreach ($this->roles as $role){
            if($role->getParent())
                $this->addRole(new Role($role->getName()), new Role($role->getParent()->getName()));
            else
                $this->addRole(new Role($role->getName()));

            if($role->getDeveloper())
                $this->allow($role->getName(), [], []);
        }

    }

    /**
     * Load Resources from factory
     * @return $this
     */
    protected function loadResources()
    {
        foreach($this->resources as $resource)
            $this->addResource(new Resource($resource->getName()));

        return $this;
    }

    /**
     * Load Privileges from factory
     * @return $this
     */
    protected function loadPrivileges()
    {
        foreach($this->privileges as $privilege) {
            /* All actions from resource or just the actions that are allowed to the role */
            if($privilege->getPermissions() === 'All') {
                $this->allow($privilege->getRole()->getName(), $privilege->getResource()->getName(), array());
            } else {
                $actions = json_decode($privilege->getPermissions(), true);
                $this->allow($privilege->getRole()->getName(), $privilege->getResource()->getName(), $actions);
            }
        }

        return $this;
    }

    /**
     * @param  RoleInterface|string $role
     * @param  ResourceInterface|string $resource
     * @param  string $privilege
     * @return bool
     */
    public function isAllowed($role = null, $resource = null, $privilege = null)
    {
        if (!$this->hasRole($role)) {
            return false;
        }

        if (!$this->hasResource($resource)) {
            return false;
        }

        return parent::isAllowed($role, $resource, $privilege);
    }

}