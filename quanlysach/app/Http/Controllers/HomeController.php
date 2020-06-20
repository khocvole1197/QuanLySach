<?php

namespace App\Http\Controllers;

use App\Author;
use App\Book;

use App\Repositories\Author\AuthorRepository;
use App\Repositories\Book\BookRepository;
use App\Repositories\User\UserRepository;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $authorModel;
    protected $bookModel;
    protected $userModel;

    public function __construct(AuthorRepository $authorRepository,
                                BookRepository $bookRepository,
                                UserRepository $userRepository)
    {
        $this->authorModel = $authorRepository;
        $this->bookModel = $bookRepository;
        $this->userModel = $userRepository;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (Auth::user()->lever != 2) {

            return redirect()->route('user');

        }

        return view('home');
    }


    public function onlyTacGia(Request $request)
    {
        $datas = $this->authorModel->onlyAuthor($request->author);
        $onlyDangMuon = $this->bookModel->dangMuonSach();
        $onlyDangXem = $this->bookModel->dangXemSach();

        return view('sach/quan_ly_sach', compact('datas', 'onlyDangMuon', 'onlyDangXem'));
    }
}
