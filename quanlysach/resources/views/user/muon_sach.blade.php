@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row  justify-content-center">
           @include('layouts.menu_customer')
            <div class="col-md-9">
                <div class="card">
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-sm-12">
                                <p><b> Mượn sách </b></p>
                                @if (session('error'))
                                    <div class="alert alert-danger" role="alert">
                                        {{ session('error') }}
                                    </div>
                                @endif
                                <div style="padding-top: 30px">
                                </div>
                                <div class="row" style="padding-top: 10px;padding-bottom: 30px;">
                                    <div class="col-sm-9 ">
                                        <div class="row">
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                    </div>
                                </div>
                                <div class="row col-sm-12">
                                    <div class="col-sm-3">
                                    </div>
                                    <div class="col-sm-9">
                                        <form action="" method="post">
                                            @csrf
                                            <div class="row">
                                            </div>
                                        </form>
                                    </div>
                                    <div class=" container">
                                        <form action="{{route('customer.create')}}" method="get">
                                            <div class="row col-sm-12">
                                                <input name="id" value="{{$data->id}}" hidden>
                                                <div class="col-sm-2">
                                                    Tên sách:
                                                </div>
                                                <div class="col-sm-3">
                                                    <td> {{$data->name_book}} </td>
                                                </div>
                                            </div>
                                            <div class="row col-sm-12">
                                                <div class="col-sm-2">
                                                    Tác giả:
                                                </div>
                                                <div class="col-sm-3">
                                                    <td>{{$data->authors}}</td>
                                                </div>
                                            </div>
                                            <div class="row col-sm-12">
                                                <div class="col-sm-2">
                                                    Ngày mượn:
                                                </div>
                                                <div class="col-sm-3">
                                                    <?php use Carbon\Carbon;
                                                    $dt = Carbon::now();
                                                    ?>
                                                    <input type="date" name="dayform" value="{{ $dt->toDateString()}}"
                                                           readonly>
                                                </div>
                                            </div>
                                            <div class="row col-sm-12">
                                                <div class="col-sm-2">
                                                    Ngày trả:
                                                </div>
                                                <div class="col-sm-3">
                                                    <input type="date" name="dayto" value="{{ $dt->toDateString()}}">
                                                    @if ($errors->has('dayto'))
                                                        <span class="help-block">
                                                    <strong>{{ $errors->first('dayto') }}</strong>
                                                </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="row col-sm-12">
                                                <div class="col-sm-2">
                                                    <button class="btnMuon" type="submit">mượn</button>
                                                    <button>hủy</button>
                                                </div>
                                                <div class="col-sm-2">
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


