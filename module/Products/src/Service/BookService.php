<?php

namespace Products\Service;

use Products\Model\Book;
use RuntimeException;

class BookService extends ProductService
{
    public function fetchAll()
    {
        return $this->tableGateway->select();
    }

    public function saveItem(Product $product)
    {
        $data = [
            'artist' => $product->artist,
            'title' => $product->title,
        ];

        $id = (int)$product->id;

        if ($id === 0) {
            $this->tableGateway->insert($data);
            return;
        }

        try {
            $this->getProduct($id);
        } catch (RuntimeException $e) {
            throw new RuntimeException(sprintf(
                'Cannot update album with identifier %d; does not exist',
                $id
            ));
        }

        $this->tableGateway->update($data, ['id' => $id]);
    }

    public function getProduct($id)
    {
        $id = (int)$id;
        $rowset = $this->tableGateway->select(['id' => $id]);
        $row = $rowset->current();
        if (!$row) {
            throw new RuntimeException(sprintf(
                'Could not find row with identifier %d',
                $id
            ));
        }

        return $row;
    }

    public function deleteProduct($id)
    {
        $this->tableGateway->delete(['id' => (int)$id]);
    }
}