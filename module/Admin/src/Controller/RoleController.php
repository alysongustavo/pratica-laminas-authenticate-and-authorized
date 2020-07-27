<?php


namespace Admin\Controller;

use Admin\Entity\Role;
use Admin\Entity\User;
use Admin\Form\ResourceForm;
use Admin\Form\RoleForm;
use Admin\Service\Exception\ServiceException;
use Admin\Service\RoleService;
use Admin\Service\ServiceInterface;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class RoleController extends AbstractActionController
{

    /**
     * @var RoleService
     */
    private $roleService;

    private $roleForm;

    public function __construct(ServiceInterface $roleService, RoleForm $roleForm)
    {
        $this->roleService = $roleService;
        $this->roleForm = $roleForm;
    }

    public function indexAction()
    {
        $roles = $this->roleService->findAll();

        $role = 'Gerente';

        if (!$this->access($role, 'Admin\Controller\RoleController', 'index')) {
            return $this->redirect()->toRoute('admin/login');
        }

        return new ViewModel([
            'roles' => $roles,
            'auditoria' => ['role' => $role, 'resource' => 'Admin\Controller\RoleController', 'action' => 'index']
        ]);
    }

    public function showAction()
    {
        $id = (int) $this->params('id',0);

        if($id < 1){
            $this->getResponse()->setStatusCode(404);
            return;
        }

        $role = $this->roleService->find($id);

        if($role == null){
            $this->getResponse()->setStatusCode(404);
            return;
        }

        $role = 'Gerente';

        return new ViewModel([
            'role' => $role,
            'auditoria' => ['role' => $role, 'resource' => 'Admin\Controller\RoleController', 'action' => 'show']
        ]);
    }

    public function createAction()
    {
        $formRole = $this->roleForm;

        $request = $this->getRequest();

        if($request->isPost()){

            $data = $request->getPost();

            $formRole->setData($data);

            if($formRole->isValid()){

                $role = new Role($formRole->getData());

                if(isset($data['parent']) && $data['parent'] != 0){
                    $roleParent = $this->roleService->find($data['parent']);
                    $role->setParent($roleParent);
                }else{
                    $role->setParent(null);
                }

                try{
                    $this->roleService->save($role);
                }catch (ServiceException $exception){

                } finally {
                    return $this->redirect()->toRoute('admin/role', ['action' => 'index']);
                }


            }

        }

        $role = 'Gerente';

        return new ViewModel([
            'roleForm' => $formRole,
            'auditoria' => ['role' => $role, 'resource' => 'Admin\Controller\RoleController', 'action' => 'create']
        ]);
    }

    public function updateAction()
    {
        return new ViewModel();
    }

    public function destroyAction()
    {
        $roleId = $this->params()->fromRoute('id', -1);

        if($roleId<1){
            $this->getResponse()->setStatusCode(404);
            return;
        }

        $role = $this->roleService->find($roleId);

        if($role == null){
            $this->getResponse()->setStatusCode(404);
            return;
        }

        if($this->getRequest()->isPost()){

            $data = $this->params()->fromPost();

            if($data['id']<1){
                $this->getResponse()->setStatusCode(404);
                return;
            }

            try{
                $this->roleService->destroy($data['id']);

                $this->flashMessenger()->addSuccessMessage('Role excluido com sucesso.');

            }catch (ServiceException $serviceException){
                $this->flashMessenger()->addErrorMessage($serviceException->getMessage());

            } finally {
                return $this->redirect()->toRoute('admin/role', ['action' => 'index']);
            }

        }

        $role = 'Gerente';

        return new ViewModel([
            'role' => $role,
            'auditoria' => ['role' => $role, 'resource' => 'Admin\Controller\RoleController', 'action' => 'destroy']
        ]);
    }


}