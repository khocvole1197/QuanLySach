<form class="form-horizontal" id="form_edit" method="post">
    <table class="table table-striped" style="border: 2px solid black;margin-top: 10px;
    font-family: 'Nunito', sans-serif;font-size: small  ">
        <thead>
        <tr>
            <th style="border-left:2px solid black">STT</th>
            <th style="border-left:2px solid black">Tên</th>
            <th style="border-left:2px solid black">Email</th>
            <th style="border-left:2px solid black">Status</th>
            <th style="border-left:2px solid black">Hành động</th>
        </tr>
        </thead>
        <tbody>
        @foreach($datas as $data)
            <tr>
                <td style="border-left:2px solid black">{{$data->id}}</td>
                <td style="border-left:2px solid black">
                    <p class="name_user_{{ $data->id }}">{{$data->name}}</p>
                    <input type="text" value="{{$data->name}}" id="user-{{ $data->id }}" hidden>
                </td>
                <td style="border-left:2px solid black">
                    <p class="email_{{ $data->id }}">{{$data->email}}</p>
                </td>
                @if($data->status == 1 ||$data->status == null)
                    <td style="border-left:2px solid black"
                        id="author">{{config('constants.options.CHUA_DOC')}}</td>
                @elseif($data->status==3)
                    <td style="border-left:2px solid black">{{config('constants.options.DANG_DOC')}}</td>
                @elseif($data->status==2)
                    <td style="border-left:2px solid black">{{config('constants.options.DA_MUON')}}</td>
                @endif
                <td style="border-left:2px solid black">
                    <button data-id="{{$data->id}}" class="sua_user btn btn-sm btn-primary">sửa</button>
                    |
                    <button data-id="{{$data->id}}" id="Remote" class="thungrac_user btn btn-sm btn-danger ">xóa
                    </button>
                    <button data-id="{{$data->id}}" class="btnEdit btn btn-sm btn-success" style="display: none">lưu
                    </button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</form>
{{--{!! $datas->render() !!}--}}
