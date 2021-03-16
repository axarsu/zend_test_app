<?php

namespace Products\Service;

use Zend\Db\Sql\Sql;

class ProductService
{
    /**
     * @var Sql
     */
    protected $sql;
    /**
     * @var \Zend\Db\Adapter\AdapterInterface|null
     */
    protected $adapter;

    public function __construct(Sql $sql)
    {
        $this->sql = $sql;
        $this->adapter = $sql->getAdapter();
    }

    public function fetchAllBooks()
    {
        $select = $this->sql->select()
            ->columns(['*', 'author.name as author'], false)
            ->from('book')
            ->join('author', 'author.id = book.author_id')
            ->order('book.id');

        $selectString = $this->sql->buildSqlString($select);

        return $this->adapter->query($selectString, $this->adapter::QUERY_MODE_EXECUTE);
    }

    public function fetchAllAlbums()
    {
        $select = $this->sql->select()
            ->columns(['*', 'artist.name as artist'], false)
            ->from('album')
            ->join('artist', 'artist.id = album.artist_id')
            ->order('album.id');

        $selectString = $this->sql->buildSqlString($select);

        return $this->adapter->query($selectString, $this->adapter::QUERY_MODE_EXECUTE);
    }
}
