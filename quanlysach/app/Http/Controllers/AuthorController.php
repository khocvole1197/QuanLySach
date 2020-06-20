<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatAuthor;
use App\Repositories\Author\AuthorRepository;
use App\Repositories\Book\BookRepository;
use App\Repositories\User\UserRepository;
use Illuminate\Http\Request;

class AuthorController extends Controller
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
        $datas = $this->authorModel->quanLyTacGia();
        if ($request->ajax()) {

            return view('tacgia/tac_gia_pagination', compact('datas'));
        }

        return view('tacgia/quan_ly_tac_gia', compact('datas'));
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
    //thêm mới tác giả
    public function store(CreatAuthor $request)
    {
        $name = $request->name_authors;
        $datas = $this->authorModel->createTacGia($name);

        return $datas;
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
     */
    //sửa tác giả
    public function update(CreatAuthor $request)
    {
        $name = $request->name_authors;
        $id = $request->id;
        $data = $this->authorModel->updateTacGia($name, $id);

        return $data;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $authorId = $request->idAu;
        $datas = $this->authorModel->deleteTacGia($authorId);

        return $datas;
    }
}
