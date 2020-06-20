
    <table class="table table-striped" style="border: 2px solid black;
    font-family: 'Nunito', sans-serif;font-size: small  ">
        <thead>
        <tr>
            <th style="border-left:2px solid black">STT</th>
            <th style="border-left:2px solid black">Tên tác giả</th>
            <th style="border-left:2px solid black">Hành động</th>
        </tr>
        </thead>
        <tbody>
        @foreach($datas as $data)
            <tr>
                <td style="border-left:2px solid black">{{$data->id}}</td>
                <td style="border-left:2px solid black">
                    <p class=" name_author_{{ $data->id }}">{{$data->name_authors}}</p>
                    <input type="text" value="{{$data->name_authors}}" id="author-{{ $data->id }}" hidden>
                </td>
                <td style="border-left:2px solid black">
                    <button data-id="{{$data->id}}" class="sua_tacgia btn btn-sm btn-primary">sửa</button>
                    |
                    <button data-id="{{$data->id}}" id="Remote" class="thungrac_tacgia sua btn btn-sm btn-danger ">xóa
                    </button>
                    <button data-id="{{$data->id}}" class="btnEdit luu btn btn-sm btn-success" style="display: none">
                        lưu
                    </button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
{!! $datas->render() !!}
