<?php

namespace Products\Model;

class Book extends Product
{

    public $product_id;
    public $author_id;
    public $title;
    public $isbn;

    public function exchangeArray(array $data)
    {
        $this->id = !empty($data['id']) ? $data['id'] : null;
        $this->product_id = !empty($data['product_id']) ? $data['product_id'] : null;
        $this->author_id = !empty($data['author_id']) ? $data['author_id'] : null;
        $this->title = !empty($data['title']) ? $data['title'] : null;
        $this->isbn = !empty($data['isbn']) ? $data['isbn'] : null;
    }

    public function getArrayCopy()
    {
        return [
            'id' => $this->id,
            'product_id' => $this->product_id,
            'author_id' => $this->author_id,
            'title' => $this->title,
            'isbn' => $this->isbn,
        ];
    }

}
