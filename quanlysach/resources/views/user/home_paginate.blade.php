<table class="table table-striped"
       style="border: 2px solid black;margin-top: 10px; font-family: 'Nunito', sans-serif;font-size: small  ">
    <thead>
    <tr>
        <th style="border-left:2px solid black">STT</th>
        <th style="border-left:2px solid black">Tên sách</th>
        <th style="border-left:2px solid black">Tác giả</th>
        <th style="border-left:2px solid black">Hành động</th>
    </tr>
    </thead>
    <tbody>
    @foreach($datas as $data)
        <tr>
            <td style="border-left:2px solid black">{{$data->id}}</td>
            <td style="border-left:2px solid black"
                id="author">{{$data->name_book}}</td>
            <td style="border-left:2px solid black"
                id="author">{{$data->authors}}</td>

            <td style="border-left:2px solid black">
                <a href="customer/{customer}?idSach={{$data->id}}" class=" btn btn-sm btn-secondary">Mượn</a>
                |
                <a href="customer/{customer}/edit?id={{$data->id}}" class="xem_sach btn btn-sm btn-outline-success">Xem chi
                    tiết
                </a>
            </td>
        </tr>
        <form class="form-horizontal" id="form_author" method="post">
            @csrf
            <input type="hidden" name="authorname" value="{{$data->name_authors}}">
        </form>
    @endforeach
    </tbody>
</table>
