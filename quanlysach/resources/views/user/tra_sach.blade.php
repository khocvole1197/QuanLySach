<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js">

</script>
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
                                <p><b> trả sách </b></p>
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
                                        <form action="{{'muonsacho'}}" method="post">
                                            @csrf
                                            <div class="row col-sm-12">
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
                                                    <td>{{ date('Y-m-d')}}</td>
                                                </div>
                                            </div>
                                            <div class="row col-sm-12">
                                                <div class="col-sm-2">
                                                    Ngày trả:
                                                </div>
                                                <div class="col-sm-3">
                                                    {{$data->day_to}}
                                                </div>
                                            </div>
                                            <div class="row col-sm-12">
                                                <div class="col-sm-2">
                                                    <button class="btnMuon" type="submit"><a
                                                            href="khachtra?id={{$data->id}}">Trả</a></button>
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


