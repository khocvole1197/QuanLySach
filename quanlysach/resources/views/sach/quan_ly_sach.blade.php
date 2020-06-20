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
                                <p><b> Sách </b></p>
                                <div style="padding-top: 30px">
                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                            data-target="#exampleModal">
                                        Tạo mới sách
                                    </button>
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
                                    <div class="container">
                                        <div id="tag_container">
                                            <br>
                                            <!-- Nav tabs -->
                                            <ul class="nav nav-tabs" role="tablist">
                                                <li class="nav-item">
                                                    <a class="btnAll nav-link active" data-toggle="tab" href="#home">Tất
                                                        cả</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="da_muon nav-link" data-toggle="tab" href="#menu1">Đã
                                                        mượn</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class=" nav-link" data-toggle="tab" href="#menu2">Đang xem</a>
                                                </li>
                                            </ul>
                                            <!-- Tab panes -->
                                            <div class="tab-content">
                                                <div id="home" class="homeSach container tab-pane active"><br>
                                                    <form method="post" action="{{route('onlyTacGia')}}">
                                                        @csrf
                                                        <select style="width: 180px " name="author" required>
                                                            @foreach(\App\Author::all() as $author)
                                                                <option
                                                                    value=" {{$author->name_authors}}">{{$author->name_authors}}</option>
                                                            @endforeach
                                                        </select>
                                                        <button class="btnOk">ok</button>
                                                    </form>
                                                    <div class="container">
                                                        <div id="tag_container">
                                                            @include('sach/sach_pagination')
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="menu1" class="homeDamuon container tab-pane fade"><br>
                                                    <div class="container">
                                                        <div id="tag_container">
                                                            @include('sach/da_muon')
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="menu2" class="homeDangXem container tab-pane fade"><br>
                                                    <div class="container">
                                                        <div id="tag_container">
                                                            @include('sach/dang_xem')
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
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tạo mới sách</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="form-horizontal" id="form_input" method="post">
                    @csrf
                    <div class="modal-body">
                        Tên sách:
                        <input type="text" value="" name="name_book">
                        <select style="width: 180px " name="authors" required>
                            @foreach(\App\Author::all() as $author)
                                <option value=" {{$author->name_authors}}">{{$author->name_authors}}</option>
                            @endforeach
                        </select>
                        <div id="content">
                        </div>
                    </div>
                    <span class="ceateBookError">
                            </span>
                    <div class="modal-footer">
                        <button class="btnCreate" type="submit" class="btn btn-primary">Lưu
                        </button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Thoát</button>
                    </div>
                </form>
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
            //edit thong tin.
            $(document).on('click', '.sua_sach', function () {
                var btnSach = $(this);
                let id = $(this).data('id');
                // . an nut xoa hien nut luu
                var btnXoa = btnSach.next();
                btnXoa.hide();
                var btnLuu = btnXoa.next();
                btnLuu.show();
                // hien thong tin o input
                $(`#book-${id}`).removeAttr("hidden");
                // an thong tin
                $(`.name_book_${id}`).attr("hidden", "hidden");

                $(`#author-${id}`).removeAttr("hidden");
                // an thong tin
                $(`.author_${id}`).attr("hidden", "hidden");
                return false;
            });
            $(document).on('click', '.btnEdit', function () {
                var btnEidt = $(this);
                let id = $(this).data('id');
                btnEidt.hide();
                var btnXoa = btnEidt.prev();
                btnXoa.show();
                $(`#book-${id}`).attr("hidden", "hidden");
                // an thong tin
                $(`.name_book_${id}`).removeAttr("hidden");
                $(`#author-${id}`).attr("hidden", "hidden");
                // an thong tin
                $(`.author_${id}`).removeAttr("hidden");
                let nameBook = $(`#book-${id}`).val();
                let nameAuthor = $(`#author-${id}`).val();
                $.ajax({
                    type: 'put',
                    url: '/book/{book}',
                    data: {
                        name_book: nameBook,
                        id: id,
                        authors: nameAuthor
                    },
                    success: function (response) {
                        $(`.name_book_${id}`).html(nameBook);
                        $(`.author_${id}`).html(nameAuthor);
                        $.notify("sửa thành công", "success");
                    },
                    error: function (error) {
                        if (error.status === 422) {
                            $.notify("sửa thất bại", "error");
                        } else {
                            alert('lỗi server');
                        }
                    }
                });
                return false;
            });
            //phan trang
            $(document).on('click', '.pagination a', function (event) {
                event.preventDefault();

                $('li').removeClass('active');
                $(this).parent('li').addClass('active');

                var myurl = $(this).attr('href');
                var page = $(this).attr('href').split('page=')[1];

                getData(page);
            });
            // them sua xoa
            $(document).on('click', '.thungrac_sach', function () {
                var confirmation = confirm("xóa sách?");
                var idSach = $(this).data("id");
                var btnUser = $(this);
                if(confirmation){
                    $.ajax({
                        type: 'delete',
                        url: '/book/{book}',
                        data: {idSach: idSach},
                        success: function (response) {
                            $(btnUser).closest('tr').remove();
                            $.notify("xóa thành công", "success");
                        }
                    });
                    return false;
                }

            });
            $(document).on('click', '.btnCreate', function () {
                $.ajax({
                    type: 'post',
                    url: '/book',
                    data: $('form#form_input').serialize(),
                    success: function (response) {
                        if (response == 'false') {
                            alert('Không có người dùng');
                        } else {
                            let html = ``;
                            $.each(response, function (key, item) {
                                if (item.active == 1) {
                                    var active = 'CHƯA ĐỌC';
                                }
                                if (item.active == 2) {
                                    var active = 'ĐÃ MƯỢN';
                                }
                                if (item.active == 3) {
                                    var active = 'ĐANG ĐỌC';
                                }
                                if (item.user_r == 1) {
                                    var user_r = '';
                                }
                                if (item.user_r != 1) {
                                    var user_r = item.user_r;
                                }
                                html += `<tr>
                                <td style="border-left:2px solid black">${item.id}</td>
                                <td style="border-left:2px solid black">
                                <p class=" name_book_${item.id}">${item.name_book}</p>
                                    <input type="text" value="${item.name_book}" id="book-${item.id}" hidden>
                                </td>
                                <td style="border-left:2px solid black">
                                    <p class="author_${item.id}"> ${item.authors}</p>
                                    <select id="author-${item.id}" hidden>
                                        @foreach(\App\Author::all() as $author)
                                <option value=" {{$author->name_authors}}">{{$author->name_authors}}</option>
                                        @endforeach
                                </select>
                            </td>
                            <td style="border-left:2px solid black">${active}</td>
                                <td style="border-left:2px solid black">${user_r}</td>
                                <td style="border-left:2px solid black">
                                    <button data-id="${item.id}" class="sua_sach btn btn-sm btn-primary">sửa</button>
                                    |
                                    <button data-id="${item.id}" class="thungrac_sach sua btn btn-sm btn-danger ">xóa</button>
                                    <button data-id="${item.id}" class="btnEdit luu btn btn-sm btn-success" style="display: none">lưu
                                    </button>
                                </td>
                             </tr>`
                            });
                            $('.table tbody').html(html);
                            $.notify("Thêm thành công", "success");
                        }
                    },
                    error: function (error) {
                        if (error.status == 422) {
                            // console.log(error.responseJSON.message);
                            $('.ceateBookError').html(error.responseJSON.message);
                            $.notify("Thêm thất bại", "error");
                        } else {
                            alert('lỗi server');
                        }
                    }
                });
                return false;
            });
        });

        //getdataphantrang
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
@endpush

