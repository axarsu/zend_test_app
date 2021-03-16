<?php

namespace Products\Model;

class Thriller extends Book
{

    public $book_id;
    public $excitement_factor;

    public function exchangeArray(array $data)
    {
        parent::exchangeArray($data);

        $this->book_id = !empty($data['book_id']) ? $data['book_id'] : null;
        $this->excitement_factor = !empty($data['excitement_factor']) ? $data['excitement_factor'] : null;
    }

    public function getArrayCopy()
    {
        $array = parent::getArrayCopy();

        $array['excitement_factor'] = $this->excitement_factor;
        $array['book_id'] = $this->book_id;
        return $array;
    }

}
