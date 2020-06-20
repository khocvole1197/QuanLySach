<?php

namespace App\Repositories\Book;

use App\Author;
use Illuminate\Container\Container as Application;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Book;

/**
 * Class BookRepositoryEloquent.
 *
 * @package namespace App\Repositories\Book;
 */
class BookRepositoryEloquent extends BaseRepository implements BookRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    protected $bookModel;
    protected $authorModel;
    public function __construct(Application $app, Book $bookModel,Author $authorModel)
    {
        $this->bookModel = $bookModel;
        $this->authorModel = $authorModel;
        parent::__construct($app);
    }

    public function model()
    {
        return Book::class;
    }

    public function createSach($name, $namebook)
    {
        $author = Author::all()->where('name_authors', $name)->first();
        $book_id = $author->id;
        // 1 la chua lam gi. 2 la dang doc. 3 la dang muon
        $this->bookModel->create([
            'book_id' => $book_id,
            'name_book' => $namebook,
            'authors' => $name,
            'active' => 1,
            'user_r' => 1,
        ]);
        return $this->bookModel->all();
    }

    public function getBook()
    {
        return $this->bookModel->find(204);
    }

    public function quanLySach()
    {
        return $this->bookModel->all();
    }

    public function dangMuonSach()
    {
        return $this->bookModel->all()->whereNotIn('active', 1)->whereNotIn('active', 3);
    }

    public function dangXemSach()
    {
        return $this->bookModel->all()->whereNotIn('active', 1)->whereNotIn('active', 2);
    }

    /**
     * @param $id
     * @param $name
     * @param $authors
     * @return mixed
     */
    public function updateSach($id, $name, $authors)
    {

        $update = $this->bookModel->find($id);
        $author = Author::all()->where('name_authors', $authors)->first();

        $book_id = $author->id;
        return $update->update([
            'book_id' => $book_id,
            'name_book' => $name,
            'authors' => $authors,
        ]);
    }

    public function deleteSach($sach_id)
    {
        $delete = $this->bookModel->find($sach_id);
        $delete->delete();
    }

    public function destroySach($sach_id)
    {
        $delete = $this->bookModel->withTrashed()->find($sach_id);
        $delete->forceDelete();
    }

    public function deleteAllSach()
    {
        $delete = $this->bookModel->onlyTrashed()->get();
        foreach ($delete as $del) {
            $del->forceDelete();
        }
    }

    public function phucHoiSach($sachId)
    {
        $restore = $this->bookModel->withTrashed()->find($sachId);
        $restore->restore();
    }

    public function trash()
    {
        // TODO: Implement trash() method.
        return $this->bookModel->onlyTrashed()->paginate(5);
    }

    /**
     * Boot up the repository, pushing criteria
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function findByID($id)
    {
        return $this->bookModel->find($id);
    }

    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
