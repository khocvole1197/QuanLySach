<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateBook;
use App\Repositories\Author\AuthorRepository;
use App\Repositories\Book\BookRepository;
use App\Repositories\User\UserRepository;
use Illuminate\Http\Request;

class BookController extends Controller
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

    public function index()
    {
        //
        $datas = $this->bookModel->quanLySach();
        $onlyDangMuon = $this->bookModel->dangMuonSach();
        $onlyDangXem = $this->bookModel->dangXemSach();

        return view('sach/quan_ly_sach', compact('datas', 'onlyDangMuon', 'onlyDangXem'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    //thêm mới sách
    public function store(CreateBook $request)
    {
        $namebook = $request->name_book;
        $name = $request->authors;
        $datas = $this->bookModel->createSach($name, $namebook);

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
     * update sach
     */
    public function update(CreateBook $request)
    {
        $id = $request->id;
        $name = $request->name_book;
        $authors = $request->authors;

        $this->bookModel->updateSach($id, $name, $authors);


//        $update->update([
//            'name_book' => $name,
//            'authors' => $request->authors,
//        ]);
//        $update->name_book = $name;
//        $update->authors = $request->authors;
//
//        $update->save();
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

        $this->bookModel->deleteSach($sachId);
    }
}
