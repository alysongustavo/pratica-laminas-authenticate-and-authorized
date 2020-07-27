<?php


namespace Admin\ViewHelper;


use Admin\Service\AclService;
use Laminas\View\Helper\AbstractHelper;

class Access extends AbstractHelper
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