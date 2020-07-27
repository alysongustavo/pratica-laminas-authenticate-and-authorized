<?php


namespace Admin\Controller;

use Admin\Entity\Privilege;
use Admin\Form\PrivilegeForm;
use Admin\Service\Exception\ServiceException;
use Admin\Service\PrivilegeService;
use Admin\Service\ResourceService;
use Admin\Service\RoleService;
use Admin\Service\ServiceInterface;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class PrivilegeController extends AbstractActionController
{

    /**
     * @var PrivilegeService
     */
    private $privilegeService;
    /**
     * @var PrivilegeForm
     */
    private $privilegeForm;
    /**
     * @var RoleService
     */
    private $roleService;
    /**
     * @var ResourceService
     */
    private $resourceService;

    public function __construct(ServiceInterface $privilegeService,
                                PrivilegeForm $privilegeForm, RoleService $roleService, ResourceService $resourceService)
    {
        $this->privilegeService = $privilegeService;
        $this->privilegeForm = $privilegeForm;
        $this->roleService = $roleService;
        $this->resourceService = $resourceService;
    }

    public function indexAction()
    {
        $privileges = $this->privilegeService->findAll();

        return new ViewModel([
            'privileges' => $privileges
        ]);
    }

    public function showAction()
    {
        $id = (int) $this->params('id',0);

        if($id < 1){
            $this->getResponse()->setStatusCode(404);
            return;
        }

        $privilege = $this->privilegeService->find($id);

        if($privilege == null){
            $this->getResponse()->setStatusCode(404);
            return;
        }

        return new ViewModel([
            'privilege' => $privilege
        ]);
    }

    public function createAction()
    {
        $formPrivilege = $this->privilegeForm;

        $request = $this->getRequest();

        if($request->isPost()){

            $data = $request->getPost();

            $formPrivilege->setData($data);

            if($formPrivilege->isValid()){

                $privilege = new Privilege($formPrivilege->getData());

                $role = $this->roleService->find($data['role']);
                $privilege->setRole($role);

                $resource = $this->resourceService->find($data['resource']);
                $privilege->setResource($resource);

                try{
                    $this->privilegeService->save($privilege);
                }catch (ServiceException $exception){

                } finally {
                    return $this->redirect()->toRoute('admin/privilege', ['action' => 'index']);
                }


            }

        }

        return new ViewModel([
            'privilegeForm' => $formPrivilege
        ]);
    }

    public function updateAction()
    {
        return new ViewModel();
    }

    public function destroyAction()
    {
        $privilegeId = $this->params()->fromRoute('id', -1);

        if($privilegeId<1){
            $this->getResponse()->setStatusCode(404);
            return;
        }

        $privilege = $this->privilegeService->find($privilegeId);

        if($privilege == null){
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
                $this->privilegeService->destroy($data['id']);

                $this->flashMessenger()->addSuccessMessage('Privilegios excluido com sucesso.');

            }catch (ServiceException $serviceException){
                $this->flashMessenger()->addErrorMessage($serviceException->getMessage());

            } finally {
                return $this->redirect()->toRoute('admin/privilege', ['action' => 'index']);
            }

        }

        return new ViewModel([
            'privilege' => $privilege
        ]);
    }


}