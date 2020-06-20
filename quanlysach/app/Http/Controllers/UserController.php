<?php

namespace App\Http\Controllers;


use App\Console\Commands\SendMail;
use App\Http\Requests\UpdateInfo;
use App\Jobs\CheckTimeDelay;
use App\Repositories\Book\BookRepository;
use App\Repositories\User\UserRepository;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    protected $bookModel;
    protected $userModel;

    public function __construct(BookRepository $repository, UserRepository $userModel)
    {
        $this->userModel = $userModel;
        $this->bookModel = $repository;
    }

    public function traSach()
    {
        $data = $this->userModel->traSach();
        if ($data == null) {

            return redirect()->route('customer.index')->with('error', __('bạn chưa mượn sách nào, xin cảm ơn'));
        }

        return view('user/tra_sach', compact('data'));
    }

    public function khachTra(Request $request)
    {
        $this->userModel->khachTra($request->id);

        return redirect()->route('customer.index')->with('success', 'Trả sách thành công!');
    }

    //info
    public function profile()
    {
        return view('profile');
    }

    //thay doi thong tin user
    public function updateInfo(UpdateInfo $request)
    {
        $userName = $request->name;
        $pass = $request->password;
        // mã hóa password
        $passWord = Hash::make($pass);
        $user = Auth::user();
        $user->name = $userName;
        $user->password = $passWord;
        $user->save();
    }

    //
    public function updateUser(Request $request)
    {
        $name = $request->nameuser;
        $update = $this->userModel->find($request->id);
        $update->name = $name;
        $update->save();
    }

    //quan ly user
    public function quanLyUser(Request $request)
    {
        $datas = $this->userModel->getUser();

        return view('user/quan_ly_user', compact('datas'));
    }

    public function deleteUser(Request $request)
    {
        $userId = $request->idUser;
        $this->userModel->deleteUser($userId);
    }
}
