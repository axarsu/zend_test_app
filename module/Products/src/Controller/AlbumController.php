<?php

namespace Products\Controller;

use Zend\View\Model\ViewModel;
use Products\Model\AlbumTable;

class AlbumController extends BaseController
{
    public function indexAction()
    {
        return new ViewModel([
            'albums' => $this->service->fetchAllAlbums(),
        ]);
    }

    public function addAction()
    {
        $request = $this->getRequest();
        $result = $this->service->add($request);
        if ($result === true) {
            return $this->redirect()->toRoute('album');
        } else {
            return $result;
        }
    }

    public function editAction()
    {
        $id = (int)$this->params()->fromRoute('id', 0);
        if (0 === $id) {
            return $this->redirect()->toRoute('album');
        }

        $request = $this->getRequest();
        $result = $this->service->edit($id, $request);
        if ($result === true) {
            return $this->redirect()->toRoute('album');
        } elseif ($result === false) {
            return $this->redirect()->toRoute('album');
        } else {
            return $result;
        }
    }

    public function deleteAction()
    {
        $id = (int)$this->params()->fromRoute('id', 0);
        if (0 === $id) {
            return $this->redirect()->toRoute('album');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int)$request->getPost('id');
                $this->service->deleteAlbum($id);
            }

            // Redirect to list of albums
            return $this->redirect()->toRoute('album');
        }

        return [
            'id' => $id,
            'album' => $this->service->getAlbum($id),
        ];
    }
}
