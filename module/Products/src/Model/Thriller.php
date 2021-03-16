<?php

namespace Products\Model;

class Thriller extends Book
{

    public $book_id;
    public $excitement_factor;

    public function exchangeArray(array $data)
    {
        $this->id = !empty($data['id']) ? $data['id'] : null;
        $this->product_id = !empty($data['product_id']) ? $data['product_id'] : null;
        $this->author_id = !empty($data['author_id']) ? $data['author_id'] : null;
        $this->title = !empty($data['title']) ? $data['title'] : null;
        $this->isbn = !empty($data['isbn']) ? $data['isbn'] : null;
        $this->book_id = !empty($data['book_id']) ? $data['book_id'] : null;
        $this->excitement_factor = !empty($data['excitement_factor']) ? $data['excitement_factor'] : null;
    }

    public function getArrayCopy()
    {
        return [
            'id' => $this->id,
            'product_id' => $this->product_id,
            'author_id' => $this->author_id,
            'title' => $this->title,
            'isbn' => $this->isbn,
            'book_id' => $this->book_id,
            'excitement_factor' => $this->excitement_factor,
        ];
    }

}
