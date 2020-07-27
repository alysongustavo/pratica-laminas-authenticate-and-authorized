<?php


namespace Admin\Controller;

use Admin\Entity\Resource;
use Admin\Form\ResourceForm;
use Admin\Service\Exception\ServiceException;
use Admin\Service\RoleService;
use Admin\Service\ServiceInterface;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class ResourceController extends AbstractActionController
{

    /**
     * @var RoleService
     */
    private $resourceService;

    public function __construct(ServiceInterface $resourceService)
    {
        $this->resourceService = $resourceService;
    }

    public function indexAction()
    {
        $resources = $this->resourceService->findAll();

        return new ViewModel([
            'resources' => $resources
        ]);
    }

    public function showAction()
    {
        $id = (int) $this->params('id',0);

        if($id < 1){
            $this->getResponse()->setStatusCode(404);
            return;
        }

        $resource = $this->resourceService->find($id);

        if($resource == null){
            $this->getResponse()->setStatusCode(404);
            return;
        }

        return new ViewModel([
            'resource' => $resource
        ]);
    }

    public function createAction()
    {
        $resourceForm = new ResourceForm();

        $request = $this->getRequest();

        if($request->isPost()){

            $data = $request->getPost();

            $resourceForm->setData($data);

            if($resourceForm->isValid()){

                $resource = new Resource($resourceForm->getData());

                try{
                    $this->resourceService->save($resource);
                }catch (ServiceException $exception){

                } finally {
                    return $this->redirect()->toRoute('admin/resource', ['action' => 'index']);
                }


            }

        }

        return new ViewModel([
            'resourceForm' => $resourceForm
        ]);
    }

    public function updateAction()
    {
        return new ViewModel();
    }

    public function destroyAction()
    {
        $resourceId = $this->params()->fromRoute('id', -1);

        if($resourceId<1){
            $this->getResponse()->setStatusCode(404);
            return;
        }

        $resource = $this->resourceService->find($resourceId);

        if($resource == null){
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
                $this->resourceService->destroy($data['id']);

                $this->flashMessenger()->addSuccessMessage('Resource excluido com sucesso.');

            }catch (ServiceException $serviceException){
                $this->flashMessenger()->addErrorMessage($serviceException->getMessage());

            } finally {
                return $this->redirect()->toRoute('admin/resource', ['action' => 'index']);
            }

        }

        return new ViewModel([
            'resource' => $resource
        ]);
    }


}