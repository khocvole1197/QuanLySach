<?php

namespace App\Http\Controllers;

use App\Repositories\Author\AuthorRepository;
use App\Repositories\Book\BookRepository;
use App\Repositories\User\UserRepository;
use Illuminate\Http\Request;

class TrashController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
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

    public function index(Request $request)
    {
        //
        $datas = $this->bookModel->trash();
        $dataTacGia = $this->authorModel->trash();
        if ($request->ajax()) {

            return view('trash/trash_sach', compact('datas', 'dataTacGia'));
        }

        return view('trash/trash', compact('datas', 'dataTacGia'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     * phục hồi tác giả
     */
    public function update(Request $request)
    {
        $sachId = $request->idSach;
        $tacGiaId = $request->idTacGia;
        if ($tacGiaId) {
            $this->authorModel->phucHoiTacGia($tacGiaId);
        }
        if ($sachId) {
            $this->bookModel->phucHoiSach($sachId);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $sachId = $request->idSach;
        $tacGiaId = $request->idTacGia;
        if ($sachId) {
            $this->bookModel->destroySach($sachId);
        }
        if ($tacGiaId) {
            $this->authorModel->destroyTacGia($tacGiaId);
        }
        $delAll = $request->all;
        if ($delAll == 'book') {
            $this->bookModel->deleteAllSach();
        }
        if ($delAll == 'author') {
            $this->authorModel->deleteAllTacGia();
        }
    }
}
