<?php


namespace Admin\Controller;


use Admin\Entity\Resource;
use Admin\Entity\User;
use Admin\Form\ResourceForm;
use Admin\Form\UserForm;
use Admin\Service\Exception\ServiceException;
use Admin\Service\RoleService;
use Admin\Service\ServiceInterface;
use Admin\Service\UserService;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class UserController extends AbstractActionController
{

    /**
     * @var UserService
     */
    private $userService;

    private $roleService;

    private $userForm;

    public function __construct(ServiceInterface $userService, UserForm $userForm, RoleService $roleService)
    {
        $this->userService = $userService;
        $this->userForm = $userForm;
        $this->roleService = $roleService;
    }

    public function indexAction()
    {
        $users = $this->userService->findAll();

        return new ViewModel([
            'users' => $users
        ]);
    }

    public function showAction()
    {
        $id = (int) $this->params('id',0);

        if($id < 1){
            $this->getResponse()->setStatusCode(404);
            return;
        }

        $user = $this->userService->find($id);

        if($user == null){
            $this->getResponse()->setStatusCode(404);
            return;
        }

        return new ViewModel([
            'user' => $user
        ]);
    }

    public function createAction()
    {
        $formUser = $this->userForm;

        $request = $this->getRequest();

        if($request->isPost()){

            $data = $request->getPost();

            $formUser->setData($data);

            if($formUser->isValid()){

                $user = new User($formUser->getData());

                $role = $this->roleService->find($data['roles']);
                $user->addRole($role);

                try{
                    $this->userService->save($user);
                }catch (ServiceException $exception){

                } finally {
                    return $this->redirect()->toRoute('admin/user', ['action' => 'index']);
                }


            }

        }

        return new ViewModel([
            'userForm' => $formUser
        ]);
    }

    public function updateAction()
    {
        return new ViewModel();
    }

    public function destroyAction()
    {
        $userId = $this->params()->fromRoute('id', -1);

        if($userId<1){
            $this->getResponse()->setStatusCode(404);
            return;
        }

        $user = $this->userService->find($userId);

        if($user == null){
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
                $this->userService->destroy($data['id']);

                $this->flashMessenger()->addSuccessMessage('User excluido com sucesso.');

            }catch (ServiceException $serviceException){
                $this->flashMessenger()->addErrorMessage($serviceException->getMessage());

            } finally {
                return $this->redirect()->toRoute('admin/user', ['action' => 'index']);
            }

        }

        return new ViewModel([
            'user' => $user
        ]);
    }

}