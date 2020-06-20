<?php

namespace App\Repositories\Author;

use App\Book;
use App\User;
use Illuminate\Container\Container as Application;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Author;
use App\Validators\Author\AuthorValidator;

/**
 * Class AuthorRepositoryEloquent.
 *
 * @package namespace App\Repositories\Author;
 */
class AuthorRepositoryEloquent extends BaseRepository implements AuthorRepository
{
    protected $authorModel;
    protected $bookModel;
    protected $userModel;

    public function __construct(Application $app, Author $authorModel, Book $bookModel, User $userModel)
    {
        $this->userModel = $userModel;
        $this->bookModel = $bookModel;
        $this->authorModel = $authorModel;
        parent::__construct($app);
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Author::class;
    }

    public function trash()
    {
        // TODO: Implement trash() method.
        return $this->authorModel->onlyTrashed()->get();
    }

    public function quanLyTacGia()
    {
        return $this->authorModel->paginate(5);
    }

    public function createTacGia($name)
    {
        $this->authorModel->create([
            'name_authors' => $name,
        ]);
        return $this->authorModel->all();
    }

    public function onlyAuthor($name)
    {
        return $this->bookModel->where('authors', $name)->get();
    }

    public function deleteTacGia($author_id)
    {
        $delete = $this->authorModel->find($author_id);
        $delete->books()->delete();
        $delete->delete();
        return $this->authorModel->all();
    }

    public function updateTacGia($name, $id)
    {
        $update = $this->authorModel->find($id);
        $update->name_authors = $name;
        $update->save();
        $data = $this->bookModel->withTrashed()->where('book_id', $id)->get();
        foreach ($data as $k) {
            $k->authors = $name;
            $k->save();
        }
        return $data;
    }

    public function deleteAllTacGia()
    {
        $delete = $this->authorModel->onlyTrashed()->get();
        foreach ($delete as $del) {
            $del->forceDelete();
        }
    }

    public function destroyTacGia($tacGiaId)
    {
        $delete = $this->authorModel->withTrashed()->find($tacGiaId);
        $delete->forceDelete();
    }

    public function phucHoiTacGia($tacGiaId)
    {
        $restore = $this->authorModel->withTrashed()->find($tacGiaId);
        $restore->restore();
    }

    /**
     * Boot up the repository, pushing criteria
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
