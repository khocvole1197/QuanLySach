@extends('layouts.app')

@section('content')

    <div class="container-fluid">

        <div class="row  justify-content-center">
            @include('layouts.menu_bar')
            <div class="col-md-9">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <p><b> Tac Gia </b></p>
                                <div style="padding-top: 30px">
                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                            data-target="#exampleModal">
                                        Tạo mới tác giả
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
                                    <div id="content">

                                    </div>
                                    <div class="container">
                                        <div id="tag_container">
                                            @include('tacgia/tac_gia_pagination')
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
                    <h5 class="modal-title " id="exampleModalLabel">Tạo mới tác giả</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="form-horizontal" id="form_input" method="get">

                    <div class="modal-body">
                        tác giả:
                        <input type="text" value="" name="name_authors">

                        <div>
                             <span class="userNameError">
                            </span>
                        </div>
                    </div>
                    <div class="modal-footer">

                        <button class="btn btn-success btnCreate">Lưu
                        </button>
                        <button class="btn btn-secondary" data-dismiss="modal">Thoát</button>
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
        $(document).on('click', ".btnCreate", function () {
            $.ajax({
                type: 'post',
                url: '/author',
                data: $('form#form_input').serialize(),
                success: function (response) {
                    if (response != null) {
                        let html = ``;
                        $.each(response, function (key, item) {
                            html +=
                                `<tr>
                                    <td style="border-left:2px solid black">${item.id}</td>
                                    <td style="border-left:2px solid black">
                                        <p class=" name_author_${item.id}">${item.name_authors}</p>
                                        <input type="text" value="${item.name_authors}" name="author" id="author-${item.id}" hidden>
                                    </td>
                                    <td style="border-left:2px solid black">
                                        <button data-id="${item.id}" class="sua_tacgia btn btn-sm btn-primary">sửa</button>
                                        |
                                        <button data-id="${item.id}" class="thungrac_tacgia sua btn btn-sm btn-danger">xoa</button>

                                        <button data-id="${item.id}"  class="btnEdit luu btn btn-sm btn-success" style="display: none">lưu</button>
                                    </td>
                                 </tr>`;
                        });
                        $('.table tbody').html(html);
                        $.notify("Thêm thành công", "success");
                    }
                },
                error: function (error) {
                    if (error.status === 422) {
                        // console.log(error.responseJSON.message);
                        $('.userNameError').html(error.responseJSON.errors.name_authors);
                        $.notify("Thêm thất bại", "error");
                    } else {
                        alert('lỗi server');
                    }
                }
            });
            return false;
        });
        $(document).ready(function () {
            $(document).on('click', '.sua_tacgia', function () {

                var btnTacGia = $(this);
                // hiện thông tin ở ô input . tìm cha của button là td gần nhất sau đó tìm em của td.
                let id = $(this).data('id');
                //hien o input
                $(`#author-${id}`).removeAttr("hidden");
                // an thong tin
                $(`.name_author_${id}`).attr("hidden", "hidden");
                // ẩn nút xóa, hiện nút sửa.
                var btnXoa = btnTacGia.next();
                btnXoa.hide();
                var btnLuu = btnXoa.next();
                btnLuu.show();
                return false;
            });

            $(document).on('click', '.btnEdit', function () {
                var btnEidt = $(this);
                btnEidt.hide();
                var btnXoa = btnEidt.prev();
                btnXoa.show();
                // ẩn ô input, hiện lại thông tin
                let id = $(this).data('id');
                //an o input
                $(`#author-${id}`).attr("hidden", "hidden");
                //hien lai thong tin
                $(`.name_author_${id}`).removeAttr("hidden");
                let nameAuthor = $(`#author-${id}`).val();
                $.ajax({
                    type: 'PUT',
                    url: '/author/{author}',
                    data: {
                        name_authors: nameAuthor,
                        id: id
                    },
                    success: function (response) {
                        $(`.name_author_${id}`).html(nameAuthor);
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
            //phantrang
            //phan trang
            $(document).on('click', '.pagination a', function (event) {
                event.preventDefault();
                $('li').removeClass('active');
                $(this).parent('li').addClass('active');
                var myurl = $(this).attr('href');
                var page = $(this).attr('href').split('page=')[1];
                getData(page);
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
                    alert('No response from server');
                });
            }

            //khai báo biến submit form lấy đối tượng nút submit
            $(document).on('click', '.thungrac_tacgia', function () {
                var confirmation = confirm("xóa tác giả?");
                var idAu = $(this).data("id");
                var btnTacGia = $(this);
                if(confirmation){
                    $.ajax({
                        type: 'DELETE',
                        url: '/author/{author}',
                        data: {idAu: idAu},
                        success: function (response) {
                            $(btnTacGia).closest('tr').remove();
                            $.notify("xóa thành công", "success");
                        }
                    });
                    return false;
                }

            });
        });
    </script>
@endpush
