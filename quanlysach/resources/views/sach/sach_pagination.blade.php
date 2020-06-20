<table class="table table-striped"
       style="border: 2px solid black;margin-top: 10px; font-family: 'Nunito', sans-serif;font-size: small  ">
    <thead>
    <tr>
        <th style="border-left:2px solid black">STT</th>
        <th style="border-left:2px solid black">Tên sách</th>
        <th style="border-left:2px solid black">Tác giả</th>
        <th style="border-left:2px solid black">Trạng thái</th>
        <th style="border-left:2px solid black">Người mượn</th>
        <th style="border-left:2px solid black">Hành động</th>
    </tr>
    </thead>
    <tbody>
    @foreach($datas as $data)
        <tr>
            <td style="border-left:2px solid black">{{$data->id}}</td>
            <td style="border-left:2px solid black"
                id="author">
                <p class=" name_book_{{ $data->id }}">{{$data->name_book}}</p>
                <input type="text" value="{{$data->name_book}}" id="book-{{ $data->id }}" hidden>
                <span class="updateBookError"></span>
            </td>
            <td style="border-left:2px solid black">
                <p class="author_{{$data->id}}">
                    {{$data->authors}}


                </p>
                <select id="author-{{$data->id}}" hidden>
                    @foreach(\App\Author::all() as $author)
                        <option value=" {{$author->name_authors}}">{{$author->name_authors}}</option>
                    @endforeach
                </select>
            </td>
            @if($data->active==null || $data->active==1)
                <td style="border-left:2px solid black"
                    id="author">{{config('constants.options.CHUA_DOC')}}</td>
            @elseif($data->active==3)
                <td style="border-left:2px solid black">{{config('constants.options.DANG_DOC')}}</td>
            @elseif($data->active==2)
                <td style="border-left:2px solid black">{{config('constants.options.DA_MUON')}}</td>
            @endif
            <td style="border-left:2px solid black"
                id="author">
                @if($data->user_r!=1)
                    {{$data->user_r}}
                @endif
            </td>
            <td style="border-left:2px solid black">
                <button data-id="{{$data->id}}" class="sua_sach btn btn-sm btn-primary">sửa</button>
                |
                <button data-id="{{$data->id}}" class="thungrac_sach sua btn btn-sm btn-danger ">xóa</button>

                <button data-id="{{$data->id}}" class="btnEdit luu btn btn-sm btn-success" style="display: none">lưu
                </button>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
