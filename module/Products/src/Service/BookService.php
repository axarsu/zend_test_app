<?php

namespace Products\Service;

use Products\Form\BookForm;
use Products\Model\Book;
use RuntimeException;
use Zend\Db\Sql\Sql;
use Zend\Stdlib\RequestInterface as Request;

class BookService extends ProductService
{
    protected $form;

    public function __construct(Sql $sql)
    {
        parent::__construct($sql);

        $this->form = new BookForm();

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
     * @return BookForm[]|bool
     */
    public function add($request)
    {
        $this->form->get('submit')->setValue('Add');

        if (!$request->isPost()) {
            return ['form' => $this->form];
        }

        $book = new Book();
        $this->form->setData($request->getPost());

        if (!$this->form->isValid()) {
            return ['form' => $this->form];
        }

        $book->exchangeArray($this->form->getData());

        return $this->saveBook($book);
    }

    public function saveBook(Book $book)
    {
        $this->adapter->getDriver()->getConnection()->beginTransaction();

        try {
            $product_id = (int)$book->product_id;
            if ($product_id === 0) {
                $insert = $this->sql->insert('product')
                    ->columns(['id']);
                $sql_string = $this->sql->buildSqlString($insert);
                $query = $this->adapter->query($sql_string, $this->adapter::QUERY_MODE_EXECUTE);
                $product_id = $query->getGeneratedValue();
            }

            $data = [
                'product_id' => $product_id,
                'author_id' => $book->author_id,
                'title' => $book->title,
                'isbn' => $book->isbn,
            ];

            $id = (int)$book->id;
            if ($id === 0) {
                $insert = $this->sql->insert('book')
                    ->columns(['product_id', 'author_id', 'title', 'isbn'])
                    ->values($data);
                $sql_string = $this->sql->buildSqlString($insert);
                $this->adapter->query($sql_string, $this->adapter::QUERY_MODE_EXECUTE);
            } else {
                $update = $this->sql->update('book')
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
            $book = $this->getBook($id);
        } catch (\Exception $e) {
            return false;
        }

        $this->form->bind($book);
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

        return $this->saveBook($book);
    }

    public function getBook($id)
    {
        $id = (int)$id;

        $select = $this->sql->select()
            ->columns(['*', 'author.name as author'], false)
            ->from('book')
            ->join('author', 'author.id = book.author_id')
            ->where('book.id = ' . $id);

        $selectString = $this->sql->buildSqlString($select);
        $rows = $this->adapter->query($selectString, $this->adapter::QUERY_MODE_EXECUTE);
        $row = $rows->current()->getArrayCopy();

        if (!$row) {
            throw new RuntimeException(sprintf(
                'Could not find row with identifier %d',
                $id
            ));
        }

        $book = new Book();
        $book->exchangeArray($row);

        return $book;
    }

    public function deleteBook($id)
    {
        try {
            $book = $this->getBook($id);
        } catch (\Exception $e) {
            return false;
        }

        $delete = $this->sql->delete()
            ->from('product')
            ->where('id = ' . $book->product_id);

        $delete_string = $this->sql->buildSqlString($delete);
        $this->adapter->query($delete_string, $this->adapter::QUERY_MODE_EXECUTE);
    }
}