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
                                <p><b> User </b></p>
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
                                    <div id="content">
                                    </div>
                                    <div class="container">
                                        <div id="tag_container">
                                            @include('user/user_paginate')
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
            // them sua xoa
            $(document).on('click', '.thungrac_user', function () {
                var idUser = $(this).data("id");
                var btnUser = $(this);
                $.ajax({
                    type: 'get',
                    url: '/deleteUser',
                    data: {idUser: idUser},
                    success: function (response) {
                        $(btnUser).closest('tr').remove();
                        $.notify("xóa thành công", "success");
                    }
                });
                return false;
            });
            //edit thong tin.
            $(document).on('click', '.sua_user', function () {
                var btnUser = $(this);
                let id = $(this).data('id');
                // . an nut xoa hien nut luu
                var btnXoa = btnUser.next();
                btnXoa.hide();
                var btnLuu = btnXoa.next();
                btnLuu.show();
                // hien thong tin o input
                $(`#user-${id}`).removeAttr("hidden");
                // an thong tin
                $(`.name_user_${id}`).attr("hidden", "hidden");
                return false;
            });
            $(document).on('click', '.btnEdit', function () {
                var btnEidt = $(this);
                let id = $(this).data('id');
                btnEidt.hide();
                var btnXoa = btnEidt.prev();
                btnXoa.show();
                $(`#user-${id}`).attr("hidden", "hidden");
                // an thong tin
                $(`.name_user_${id}`).removeAttr("hidden");
                let nameUser = $(`#user-${id}`).val();
                $.ajax({
                    type: 'post',
                    url: '/updateUser',
                    data: {
                        nameuser: nameUser,
                        id: id,
                    },
                    success: function (response) {
                        $(`.name_user_${id}`).html(nameUser);
                        $.notify("sửa thành công", "success");
                    }
                });
                return false;
            });
        });
    </script>
@endpush
