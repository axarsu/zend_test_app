<?php

namespace Products\Service;

use Products\Form\ThrillerForm;
use Products\Model\Thriller;
use RuntimeException;
use Zend\Db\Sql\Sql;
use Zend\Stdlib\RequestInterface as Request;

class ThrillerService extends ProductService
{
    protected $form;

    public function __construct(Sql $sql)
    {
        parent::__construct($sql);

        $this->form = new ThrillerForm();

        $authors = array_merge(['0' => ''], $this->fetchAllAuthors());
        $this->form->get('author_id')->setValueOptions($authors);
    }

    protected function fetchAllAuthors()
    {
        $select = $this->sql->select()
            ->from('author')
            ->order('id');

        $selectString = $this->sql->buildSqlString($select);

        $authors = [];
        $rows = $this->adapter->query($selectString, $this->adapter::QUERY_MODE_EXECUTE);
        foreach ($rows as $row) {
            $authors[$row->id] = $row->name;
        }

        return $authors;
    }

    /**
     * @param Request $request
     * @return ThrillerForm[]|bool
     */
    public function add($request)
    {
        $this->form->get('submit')->setValue('Add');

        if (!$request->isPost()) {
            return ['form' => $this->form];
        }

        $this->form->setData($request->getPost());
        if (!$this->form->isValid()) {
            return ['form' => $this->form];
        }

        $thriller = new Thriller();
        $thriller->exchangeArray($this->form->getData());

        return $this->saveThriller($thriller);
    }

    public function saveThriller(Thriller $thriller)
    {
        $this->adapter->getDriver()->getConnection()->beginTransaction();

        try {
            $product_id = (int)$thriller->product_id;
            if ($product_id === 0) {
                $insert = $this->sql->insert('product')
                    ->columns(['id']);
                $sql_string = $this->sql->buildSqlString($insert);
                $query = $this->adapter->query($sql_string, $this->adapter::QUERY_MODE_EXECUTE);
                $product_id = $query->getGeneratedValue();
            }

            $data = [
                'product_id' => $product_id,
                'author_id' => $thriller->author_id,
                'title' => $thriller->title,
                'isbn' => $thriller->isbn,
            ];

            $book_id = (int)$thriller->book_id;
            if ($book_id === 0) {
                $insert = $this->sql->insert('book')
                    ->columns(['product_id', 'author_id', 'title', 'isbn'])
                    ->values($data);
                $sql_string = $this->sql->buildSqlString($insert);
                $query = $this->adapter->query($sql_string, $this->adapter::QUERY_MODE_EXECUTE);
                $book_id = $query->getGeneratedValue();
            } else {
                $update = $this->sql->update('book')
                    ->set($data)
                    ->where('id = ' . $book_id);
                $sql_string = $this->sql->buildSqlString($update);
                $this->adapter->query($sql_string, $this->adapter::QUERY_MODE_EXECUTE);
            }

            $data = [
                'book_id' => $book_id,
                'excitement_factor' => $thriller->excitement_factor,
            ];

            $id = (int)$thriller->id;
            if ($id === 0) {
                $insert = $this->sql->insert('thriller')
                    ->columns(['book_id', 'excitement_factor',])
                    ->values($data);
                $sql_string = $this->sql->buildSqlString($insert);
                $this->adapter->query($sql_string, $this->adapter::QUERY_MODE_EXECUTE);
            } else {
                $update = $this->sql->update('thriller')
                    ->set($data)
                    ->where('id = ' . $id);
                $sql_string = $this->sql->buildSqlString($update);
                $this->adapter->query($sql_string, $this->adapter::QUERY_MODE_EXECUTE);
            }

            $this->adapter->getDriver()->getConnection()->commit();

            return true;
        } catch (RuntimeException $e) {
            var_dump($e);
            exit;
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
            $thriller = $this->getThriller($id);
        } catch (\Exception $e) {
            return false;
        }

        $this->form->bind($thriller);
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

        return $this->saveThriller($thriller);
    }

    public function getThriller($id)
    {
        $id = (int)$id;

        $select = $this->sql->select()
            ->columns([
                'thriller.id as id',
                'thriller.excitement_factor as excitement_factor',
                'thriller.book_id as book_id',
                'book.author_id as author_id',
                'book.title as title',
                'book.isbn as isbn',
                'book.product_id as product_id',
                'author.name as author',
            ], false)
            ->from('thriller')
            ->join('book', 'book.id = thriller.book_id', [])
            ->join('author', 'author.id = book.author_id', [])
            ->where('thriller.id = ' . $id);

        $selectString = $this->sql->buildSqlString($select);
        $rows = $this->adapter->query($selectString, $this->adapter::QUERY_MODE_EXECUTE);
        $row = $rows->current()->getArrayCopy();

        if (!$row) {
            throw new RuntimeException(sprintf(
                'Could not find row with identifier %d',
                $id
            ));
        }

        $book = new Thriller();
        $book->exchangeArray($row);

        return $book;
    }

    public function deleteThriller($id)
    {
        try {
            $thriller = $this->getThriller($id);
        } catch (\Exception $e) {
            return false;
        }

        $delete = $this->sql->delete()
            ->from('product')
            ->where('id = ' . $thriller->product_id);

        $delete_string = $this->sql->buildSqlString($delete);
        $this->adapter->query($delete_string, $this->adapter::QUERY_MODE_EXECUTE);
    }

    public function fetchAllThrillers()
    {
        $select = $this->sql->select()
            ->columns(['thriller.id as ID', 'thriller.excitement_factor as excitement_factor'], false)
            ->from('thriller')
            ->join('book', 'book.id = thriller.book_id')
            ->join('author', 'author.id = book.author_id')
            ->order('thriller.id');

        $selectString = $this->sql->buildSqlString($select);

        $rows = $this->adapter->query($selectString, $this->adapter::QUERY_MODE_EXECUTE);

        return $rows;
    }
}