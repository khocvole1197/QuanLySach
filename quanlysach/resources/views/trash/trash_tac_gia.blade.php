<table class="table table-striped" style="border: 2px solid black;margin-top: 10px;
    font-family: 'Nunito', sans-serif;font-size: small  ">
    <thead>
    <tr>
        <th style="border-left:2px solid black">STT</th>
        <th style="border-left:2px solid black">Tên tác giả</th>
        <th style="border-left:2px solid black">Hành động</th>
    </tr>
    </thead>
    <tbody>
    @foreach($dataTacGia as $data)
        <tr>
            <td style="border-left:2px solid black">{{$data->id}}</td>
            <td style="border-left:2px solid black"
                id="author">{{$data->name_authors}}</td>
            <td style="border-left:2px solid black">
                <button data-id="{{$data->id}}"
                        class="phucHoiTacGia btn btn-sm btn-outline-dark">
                    phục hồi
                </button>
                |
                <button data-id="{{$data->id}}" class="xoaTacGia btn btn-sm btn-outline-success">xoa
                </button>
            </td>
        </tr>
        <form class="form-horizontal" id="form_author" method="post">
            @csrf
            <input type="hidden" name="authorname"
                   value="{{$data->name_authors}}">
        </form>
    @endforeach
    </tbody>
</table>
{!! $datas->render() !!}
