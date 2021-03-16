<?php

namespace Products\Controller;

use Zend\View\Model\ViewModel;
use Products\Model\AlbumTable;

class ProductsController extends BaseController
{
    public function indexAction()
    {
        return new ViewModel([
            'albums' => $this->service->fetchAllAlbums(),
            'books' => $this->service->fetchAllBooks(),
        ]);
    }
}
