<?php

namespace Products\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Products\Service\ProductService;

class BaseController extends AbstractActionController
{
    protected $service;

    public function __construct(ProductService $service)
    {
        $this->service = $service;
    }

}
