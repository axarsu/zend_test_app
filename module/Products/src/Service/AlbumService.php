<?php

namespace Products\Service;

use Products\Form\AlbumForm;
use Products\Model\Album;
use RuntimeException;
use Zend\Db\Sql\Sql;
use Zend\Stdlib\RequestInterface as Request;

class AlbumService extends ProductService
{
    protected $form;

    public function __construct(Sql $sql)
    {
        parent::__construct($sql);

        $this->form = new AlbumForm();

        $artists = array_merge(['0' => ''], $this->fetchAllArtists());
        $this->form->get('artist_id')->setValueOptions($artists);
    }

    protected function fetchAllArtists()
    {
        $select = $this->sql->select()
            ->from('artist')
            ->order('id');

        $selectString = $this->sql->buildSqlString($select);

        $artists = [];
        $rows = $this->adapter->query($selectString, $this->adapter::QUERY_MODE_EXECUTE);
        foreach ($rows as $row) {
            $artists[$row->id] = $row->name;
        }

        return $artists;
    }

    /**
     * @param Request $request
     * @return AlbumForm[]|bool
     */
    public function add($request)
    {
        $this->form->get('submit')->setValue('Add');

        if (!$request->isPost()) {
            return ['form' => $this->form];
        }

        $album = new Album();
        $this->form->setData($request->getPost());

        if (!$this->form->isValid()) {
            return ['form' => $this->form];
        }

        $album->exchangeArray($this->form->getData());

        return $this->saveAlbum($album);
    }

    public function saveAlbum(Album $album)
    {
        $this->adapter->getDriver()->getConnection()->beginTransaction();

        try {
            $product_id = (int)$album->product_id;
            if ($product_id === 0) {
                $insert = $this->sql->insert('product')
                    ->columns(['id']);
                $sql_string = $this->sql->buildSqlString($insert);
                $query = $this->adapter->query($sql_string, $this->adapter::QUERY_MODE_EXECUTE);
                $product_id = $query->getGeneratedValue();
            }

            $data = [
                'product_id' => $product_id,
                'artist_id' => $album->artist_id,
                'title' => $album->title,
            ];

            $id = (int)$album->id;
            if ($id === 0) {
                $insert = $this->sql->insert('album')
                    ->columns(['product_id', 'artist_id', 'title'])
                    ->values($data);
                $sql_string = $this->sql->buildSqlString($insert);
                $this->adapter->query($sql_string, $this->adapter::QUERY_MODE_EXECUTE);
            } else {
                $update = $this->sql->update('album')
                    ->set($data)
                    ->where('id = ' . $id);
                $sql_string = $this->sql->buildSqlString($update);
                $this->adapter->query($sql_string, $this->adapter::QUERY_MODE_EXECUTE);
            }

            $this->adapter->getDriver()->getConnection()->commit();

            return true;
        } catch (RuntimeException $e) {
            $this->adapter->getDriver()->getConnection()->rollback();

            return [
                'id' => $id,
                'form' => $this->form
            ];
        }
    }

    public function edit($id, $request)
    {
        // Retrieve the album with the specified id. Doing so raises
        // an exception if the album is not found, which should result
        // in redirecting to the landing page.
        try {
            $album = $this->getAlbum($id);
        } catch (\Exception $e) {
            return false;
        }

        $this->form->bind($album);
        $this->form->get('submit')->setAttribute('value', 'Edit');

        $viewData = [
            'id' => $id,
            'form' => $this->form
        ];

        if (!$request->isPost()) {
            return $viewData;
        }

        $this->form->setData($request->getPost());

        if (!$this->form->isValid()) {
            return $viewData;
        }

        return $this->saveAlbum($album);
    }

    public function getAlbum($id)
    {
        $id = (int)$id;

        $select = $this->sql->select()
            ->columns(['*', 'artist.name as artist'], false)
            ->from('album')
            ->join('artist', 'artist.id = album.artist_id')
            ->where('album.id = ' . $id);

        $selectString = $this->sql->buildSqlString($select);
        $rows = $this->adapter->query($selectString, $this->adapter::QUERY_MODE_EXECUTE);
        $row = $rows->current()->getArrayCopy();

        if (!$row) {
            throw new RuntimeException(sprintf(
                'Could not find row with identifier %d',
                $id
            ));
        }

        $album = new Album();
        $album->exchangeArray($row);

        return $album;
    }

    public function deleteAlbum($id)
    {
        $delete = $this->sql->delete()
            ->from('album')
            ->where('id = ' . $id);

        $delete_string = $this->sql->buildSqlString($delete);
        $this->adapter->query($delete_string, $this->adapter::QUERY_MODE_EXECUTE);
    }
}