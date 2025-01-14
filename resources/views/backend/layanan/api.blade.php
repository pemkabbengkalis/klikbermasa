<table class="table">
<thead>
    <tr>
        <th>Method</th>
        <th>Tipe</th>
        <th>URL</th>
        <th>Ketarangan</th>
    </tr>
</thead>
<tbody>
    @foreach($data->api as $row)
    @if(!$api || $api && $api->id != $row->id)
    <tr>
<td>{{$row->method}}</td>
<td>{{$row->type}}</td>
<td>{{$row->url}}</td>
<td>{{$row->keterangan}}
<div class="float-end">
        <a  href="{{url()->current().'?api_id='.$row->id}}" class="text-warning bi bi-pencil "></a>
        <a  href="{{url()->full().'?delete_api_id='.$row->id}}" onclick="return confirm('Hapus field ini ?')" class="text-danger bi bi-trash "></a>
</div>
</td>
    </tr>
    @endif
    @endforeach

    <tr>
        <td><input value="{{$api?->method}}" type="text" name="method" id="" class="form-control form-control-sm"></td>
        <td><input value="{{$api?->type}}" type="text" name="type" id="" class="form-control form-control-sm"></td>
        <td><input  value="{{$api?->url}}" type="text" name="url" id="" class="form-control form-control-sm"></td>
        <td><textarea type="text" name="keterangan" id="" class="form-control form-control-sm">{{$api?->keterangan}}</textarea>

    </td>
    </tr>
    <tr>
        <td colspan="4" class="text-end">
            @if(request('api_id'))
            <button class="btn btn-sm btn-warning" type="submit" name="updateapi" value="{{request('api_id')}}">
            Update
           </button>
           <a class="btn btn-sm btn-danger" href="{{url()->current()}}">
            Batal
           </a>
           @else
           <button class="btn btn-sm btn-warning" type="submit" name="createapi" value="true">
            Tambah API
           </button>
            @endif
        </td>
    </tr>
</tbody>
</table>
