<?php

namespace App\Http\Controllers;

use App\Http\Requests\DateTime;
use App\Jobs\CheckTimeDelay;
use App\Jobs\SendWelcomeEmail;
use App\Mail\SendEmail;
use App\Mail\SendEmailUser;
use App\Repositories\Author\AuthorRepository;
use App\Repositories\Book\BookRepository;
use App\Repositories\User\UserRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
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

    // hien thi view cua khach hang
    public function index(Request $request)
    {
        //
        if (Auth::user()->lever != 1) {

            return redirect()->route('home');

        } else {
            $datas = $this->userModel->getData();
            if ($request->ajax()) {

                return view('user/home_paginate', compact('datas'));
            }

            return view('user/home', compact('datas'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    //luu thong tin muon sach cua khach hang
    public function create(DateTime $request)
    {
        //
        $test = $this->userModel->kiemTraMuon();
        if ($test == null) {
            $idb = $request->id;
            $dayfrom = $request->dayform;
            $dayto = $request->dayto;
            $this->userModel->khachMuonSach($idb, $dayfrom, $dayto);
//            $this->processQueue();

            return redirect()->route('customer.index')->with('success', 'mượn sách thành công');

        } else {

            return redirect("http://quanlysach.itu/customer/{customer}?idSach=$request->id")
                ->with('error', __('sách bạn đang mượn hiện chưa trả nên không thể tiếp tục mượn. xin cảm ơn'));
        }
    }

//    public function processQueue()
//    {
//        $time = Carbon::now()->addMinutes(2);
//        dispatch(new SendWelcomeEmail())->delay($time);
//    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    //show view muon sach
    public function show(Request $request)
    {
        //
        $findSach = $this->bookModel->findByID($request->idSach);
        if ($findSach->active == 3) {
            if ($findSach->user_r != Auth::user()->name) {

                return redirect()->route('customer.index')->with('error',
                    __('đang có người xem sách này. xin cảm ơn '));
            }
        }
        $idSach = $request->idSach;
        $this->userModel->xemChiTiet($idSach);
        $data = $this->userModel->muonSach($idSach);

        return view('user/muon_sach', compact('data'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    //show chi tiet sach de xem
    public function edit(Request $request)
    {
        $findSach = $this->bookModel->findByID($request->id);
        if ($findSach->active == 3) {
            if ($findSach->user_r != Auth::user()->name) {

                return redirect()->route('customer.index')->with('error', __('đang có người xem. xin cảm ơn '));
            }
        }
        $id = $request->id;
        $this->userModel->CheckTime();
        $data = $this->userModel->xemChiTiet($id);

        return view('user/chi_tiet_sach', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    //hien thi view tra sach
    public function update(Request $request, $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    }
}
