<?php

namespace App\Repositories\User;

use App\Book;
use App\Jobs\CheckTimeDelay;
use Carbon\Carbon;
use Illuminate\Container\Container as Application;
use Illuminate\Support\Facades\Auth;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\User;

/**
 * Class UserRepositoryEloquent.
 *
 * @package namespace App\Repositories\User;
 */
class UserRepositoryEloquent extends BaseRepository implements UserRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return User::class;
    }

    protected $bookModel;
    protected $userModel;

    public function __construct(Application $app, Book $bookModel, User $userModel)
    {
        $this->userModel = $userModel;
        $this->bookModel = $bookModel;
        parent::__construct($app);
    }

    public function getData()
    {
        $update = $this->bookModel->all()->where('active', 3)->where('user_r', Auth::user()->name)->first();
        if ($update != null) {
            $update->update([
                'user_r' => null,
                'active' => null
            ]);
        }
        //lay tat ca du lieu tru nhung thang da muon sach

        return $this->bookModel->all()->whereNotIn('active', 2);
    }

    public function getUser()
    {
        // TODO: Implement getUser() method.
        return $this->userModel->all()->whereNotIn('lever', 2);
    }

    public function kiemTraMuon()
    {
        return $this->bookModel->all()->where('user_r', Auth::user()->name)->where('active', 2)->first();
    }

    public function muonSach($idSach)
    {
        return $this->bookModel->find($idSach);
    }

    public function khachMuonSach($idb, $dayfrom, $dayto)
    {
        $update = $this->bookModel->find($idb);
        $update->active = 2;
        $update->user_r = Auth::user()->name;
        $update->day_form = $dayfrom;
        $update->day_to = $dayto;
        $update->save();
        $id = Auth::user()->id;
        $up = User::find($id);
        $up->status = 2;
        $up->save();
    }

    public function traSach()
    {
        $id = Auth::user()->id;
        $up = User::find($id);
        $up->status = 1;
        $up->save();
        return $this->bookModel->all()->where('user_r', Auth::user()->name)->where('active', 2)->first();
    }

    public function khachTra($id)
    {
        $update = $this->bookModel->find($id);
        $update->active = null;
        $update->user_r = null;
        $update->day_form = null;
        $update->day_to = null;
        $update->save();
    }

    public function xemChiTiet($id)
    {
        $update = $this->bookModel->find($id);
        $update->active = 3;
        $update->user_r = Auth::user()->name;
        $update->save();
        return $this->bookModel->find($id);
    }

    public function deleteUser($user_id)
    {
        $delete = $this->userModel->find($user_id);
        $delete->delete();
    }

    public function CheckTime()
    {

        $name = Auth::user()->name;
        $book = $this->bookModel->all()->where('user_r',Auth::user()->name)->where('active',3)->first();
        if($book == null){
            $checkTime = (new CheckTimeDelay($name))->delay(Carbon::now()->addSeconds(2205));
            dispatch($checkTime);
        }
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
