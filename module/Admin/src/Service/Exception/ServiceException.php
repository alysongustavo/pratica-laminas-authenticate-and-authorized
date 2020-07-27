<?php


namespace Admin\Service\Exception;


use Throwable;

class ServiceException extends \RuntimeException
{

    public function __construct($message)
    {
        parent::__construct($message);
    }

}