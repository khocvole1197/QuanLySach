@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="row  justify-content-center">
            @include('layouts.menu_bar')
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
                                <p><b> Quản lý rác </b></p>
                                <div class="row">
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
                                    <div class="container">
                                        <br>
                                        <!-- Nav tabs -->
                                        <ul class="nav nav-tabs" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" data-toggle="tab" href="#home">Sách</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#menu1">Tác giả</a>
                                            </li>
                                        </ul>
                                        <!-- Tab panes -->
                                        <div class="tab-content">
                                            <div id="home" class="homeSach container tab-pane active"><br>
                                                <button class="xoaAllSach btn-outline-dark"> xóa tất cả sách</button>
                                                <div class="container">
                                                    <div id="tag_container">
                                                        @include('trash/trash_sach')
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="menu1" class="homeTacGia container tab-pane fade"><br>
                                                <button class="xoaAllTacGia  btn-outline-dark"> xóa tất cả tác giả
                                                </button>
                                                <div class="container">
                                                    <div id="tag_container">
                                                        @include('trash/trash_tac_gia')
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
@push('scripts')
    <script type="text/javascript">
        $(function () {
            $(window).on('hashchange', function () {
                if (window.location.hash) {
                    var page = window.location.hash.replace('#', '');
                    if (page == Number.NaN || page <= 0) {
                        return false;
                    } else {
                        getData(page);
                    }
                }
            });
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        })
        $(document).ready(function () {
            $(document).on('click', '.xoaAllSach', function () {
                var confirmation = confirm("xóa tất cả?");
                let btnSach = $(this);
                let table = btnSach.next();
                if (confirmation) {
                    $.ajax({
                        type: 'delete',
                        url: '/trash/{trash}',
                        data: {all: 'book'},
                        success: function (response) {
                            $(table).remove();
                            $.notify("xóa thành công", "success");
                        }
                    });
                    return false;
                }
            })
            $(document).on('click', '.xoaAllTacGia', function () {
                var confirmation = confirm("xóa tất cả?");
                let btnTacGia = $(this);
                let table = btnTacGia.next();
                if (confirmation) {
                    $.ajax({
                        type: 'delete',
                        url: '/trash/{trash}',
                        data: {all: 'author'},
                        success: function (response) {
                            $(table).remove();
                            $.notify("xóa thành công", "success");
                        }
                    });
                    return false;
                }
            })
            //phan trang
            $(document).on('click', '.pagination a', function (event) {
                event.preventDefault();
                $('li').removeClass('active');
                $(this).parent('li').addClass('active');
                var myurl = $(this).attr('href');
                var page = $(this).attr('href').split('page=')[1];
                getData(page);
            });
            $(document).on('click', '.phucHoiSach', function () {
                var idSach = $(this).data("id");
                let btnSach = $(this);
                $.ajax({
                    type: 'PUT',
                    url: '/trash/{trash}',
                    data: {idSach: idSach},
                    success: function (response) {
                        $(btnSach).closest('tr').remove();
                        $.notify("phục hồi thành công", "success");
                    }
                });
                return false;
            });
            $(document).on('click', '.xoaSach', function () {
                var confirmation = confirm("xóa sách?");
                var idSach = $(this).data("id");
                let btnSach = $(this);
                if (confirmation) {
                    $.ajax({
                        type: 'delete',
                        url: '/trash/{trash}',
                        data: {idSach: idSach},
                        success: function (response) {
                            $(btnSach).closest('tr').remove();
                            $.notify("xóa thành công", "success");
                        }
                    });
                    return false;
                }
            });
            $(document).on('click', '.phucHoiTacGia', function () {
                var idTacGia = $(this).data("id");
                let btnTacGia = $(this);
                $.ajax({
                    type: 'PUT',
                    url: '/trash/{trash}',
                    data: {idTacGia: idTacGia},
                    success: function (response) {
                        $(btnTacGia).closest('tr').remove();
                        $.notify("phục hồi thành công", "success");
                    }
                });
                return false;
            });
            $(document).on('click', '.xoaTacGia', function () {
                var confirmation = confirm("xóa tác giả?");
                var idTacGia = $(this).data("id");
                let btnTacGia = $(this);
                if (confirmation) {
                    $.ajax({
                        type: 'delete',
                        url: '/trash/{trash}',
                        data: {idTacGia: idTacGia},
                        success: function (response) {
                            $(btnTacGia).closest('tr').remove();
                            $.notify("xóa thành công", "success");
                        }
                    });
                    return false;
                }
            });
        })

        function getData(page) {
            $.ajax(
                {
                    url: '?page=' + page,
                    type: "get",
                    datatype: "html"
                }).done(function (data) {
                $("#tag_container").empty().html(data);
                location.hash = page;
            }).fail(function (jqXHR, ajaxOptions, thrownError) {
            });
        }
    </script>

@endpush('scripts')
