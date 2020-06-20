@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-2">
                <div class="w3-sidebar w3-light-grey w3-bar-block">
                    @if(Auth::user()->lever ==1)
                        <div>
                            <a href="customer" class="w3-bar-item w3-button">Mượn sách</a>
                        </div>
                        <div>
                            <a href="trasach" class="w3-bar-item w3-button">Trả sách</a>
                        </div>
                        <div>
                            <a href="{{route('profile')}}" class="w3-bar-item w3-button">Profile</a>
                        </div>
                    @elseif(Auth::user()->lever ==2)
                        <div>
                            <a href="{{route('author.index')}}" class="w3-bar-item w3-button">Quản lý tác giả</a>
                        </div>
                        <div>
                            <a href="{{route('book.index')}}" class="w3-bar-item w3-button">Quản lý sách</a>
                        </div>
                        <div>
                            <a href="{{route('quanlytaikhoan')}}" class="w3-bar-item w3-button">Quản lý tài khoản</a>
                        </div>
                        <div>
                            <a href="{{route('profile')}}" class="w3-bar-item w3-button">Profile</a>
                        </div>
                        <div>
                            <a href="{{route('trash.index')}}" class="w3-bar-item w3-button">Thùng rác</a>
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">Profile</div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif
                    </div>
                    <div class="container">
                        <div class="row justify-content-center">
                            <form action="{{route('UpdateInfo')}}" id="form_input" method="POST">
                                @csrf
                                <div class="form-group row">
                                    <label for="name" class="col-md-5 col-form-label text-sm-left"
                                           style="text-align: left">{{ __('Name') }}</label>
                                    <div class="col-md-7">
                                        <input type="text" class="form-control" name="name"
                                               value="{{Auth::user()->name}}">
                                        <span class="userNameError"></span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="name" class="col-md-5 col-form-label text-sm-left"
                                           style="text-align: left">{{ __('Password:') }}</label>
                                    <div class="col-md-7">
                                        <input type="password" class="form-control" name="password">
                                        <span class="passError"></span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="pwd" class="col-md-5 col-form-label text-sm-left">Re-Password:</label>
                                    <div class="col-md-7">
                                        <input type="password" class="form-control" name="repassword">
                                        <span class="repassError"></span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md text-sm-right">
                                        <button class="btn btn-primary btnEdit">Update</button>
                                    </div>
                                </div>
                            </form>
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

        $(document).on('click', '.btnEdit', function () {
            var btnEdit = $(this);
            let name = $("input[name='name']").val();
            let password = $("input[name='password']").val();
            $.ajax({
                type: 'post',
                url: '/editInfo',
                data: $('form#form_input').serialize(),
                success: function (response) {
                    $.notify("sửa thành công", "success");
                },
                error: function (error) {
                    if (error.status === 422) {
                        $('.userNameError').html(error.responseJSON.errors.name);
                        $('.passError').html(error.responseJSON.errors.password);
                        $('.repassError').html(error.responseJSON.errors.repassword);
                        $.notify("Thêm thất bại", "error");
                    } else {
                        alert('lỗi server');
                    }
                }
            });
            return false;
        });
    </script>
@endpush
