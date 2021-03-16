<?php

namespace Products\Model;

class Album extends Product
{
    public $product_id;
    public $artist_id;
    public $title;
    public $artist;

    public function exchangeArray(array $data)
    {
        $this->id = !empty($data['id']) ? $data['id'] : null;
        $this->product_id = !empty($data['product_id']) ? $data['product_id'] : null;
        $this->artist_id = !empty($data['artist_id']) ? $data['artist_id'] : null;
        $this->title = !empty($data['title']) ? $data['title'] : null;
        $this->artist = !empty($data['artist']) ? $data['artist'] : null;
    }

    public function getArrayCopy()
    {
        return [
            'id' => $this->id,
            'product_id' => $this->product_id,
            'artist_id' => $this->artist_id,
            'title' => $this->title,
            'artist' => $this->artist,
        ];
    }

}
