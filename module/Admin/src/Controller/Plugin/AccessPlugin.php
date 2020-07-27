<?php


namespace Admin\Controller\Plugin;

use Admin\Service\AclService;
use Laminas\Mvc\Controller\Plugin\AbstractPlugin;

class AccessPlugin extends AbstractPlugin
{
    private $aclService;

    public function __construct(AclService $aclService)
    {
        $this->aclService = $aclService;
    }

    public function __invoke($role, $matchedController, $matchedAction)
    {
        return $this->aclService->isAllowed($role, $matchedController, $matchedAction);
    }
}