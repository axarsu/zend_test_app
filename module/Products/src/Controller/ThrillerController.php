<?php

namespace Products\Controller;

use Zend\View\Model\ViewModel;

class ThrillerController extends BaseController
{
    public function indexAction()
    {
        return new ViewModel([
            'thrillers' => $this->service->fetchAllThrillers(),
        ]);
    }

    public function addAction()
    {
        $request = $this->getRequest();
        $result = $this->service->add($request);
        if ($result === true) {
            return $this->redirect()->toRoute('thriller');
        } else {
            return $result;
        }
    }

    public function editAction()
    {
        $id = (int)$this->params()->fromRoute('id', 0);
        if (0 === $id) {
            return $this->redirect()->toRoute('thriller');
        }

        $request = $this->getRequest();
        $result = $this->service->edit($id, $request);
        if ($result === true) {
            return $this->redirect()->toRoute('thriller');
        } elseif ($result === false) {
            return $this->redirect()->toRoute('thriller');
        } else {
            return $result;
        }
    }

    public function deleteAction()
    {
        $id = (int)$this->params()->fromRoute('id', 0);
        if (0 === $id) {
            return $this->redirect()->toRoute('thriller');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int)$request->getPost('id');
                $this->service->deleteThriller($id);
            }

            // Redirect to list of albums
            return $this->redirect()->toRoute('thriller');
        }

        return [
            'id' => $id,
            'thriller' => $this->service->getThriller($id),
        ];
    }
}
