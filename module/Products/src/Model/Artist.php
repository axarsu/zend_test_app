<?php

namespace Products\Model;

class Artist
{
    public $id;
    public $name;

    public function exchangeArray(array $data)
    {
        $this->id = !empty($data['id']) ? $data['id'] : null;
        $this->name = !empty($data['name']) ? $data['name'] : null;
    }

    public function getArrayCopy()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}
