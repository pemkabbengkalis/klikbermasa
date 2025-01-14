<table class="table">
<thead>
    <tr>
        <th>Label</th>
        <th>Nama Kolom</th>
        <th>Jenis Input</th>
        <th>Keterangan</th>
        <th>Wajib Isi</th>
        <th>Status</th>
        <th>Urutan</th>
        <th>Petunjuk</th>
    </tr>
</thead>
<tbody>
    @foreach($data->formulir as $row)
    @if(!$field || $field && $field->id != $row->id)
    <tr>
        <td>{{$row->judul_kolom}}</td>
        <td>{{$row->nama_kolom}}</td>
        <td>{{$row->jenis_input}}</td>
        <td>{{$row->keterangan}}</td>
        <td>{{$row->wajib}}</td>
        <td>{{$row->status}}</td>
        <td>{{$row->urutan}}</td>
        <td>{{$row->petunjuk}}
        <div class="float-end">
        <a  href="{{url()->current().'?field_id='.$row->id}}" class="text-warning bi bi-pencil "></a>
        <a  href="{{url()->current().'?delete_field_id='.$row->id}}" onclick="return confirm('Hapus field ini ?')" class="text-danger bi bi-trash "></a>
</div>
    </td>
    </tr>
    @endif
    @endforeach
    <tr>
    <td><input type="text" value="{{$field?->judul_kolom}}" name="judul_kolom" id="" class="form-control form-control-sm"></td>
    <td><input type="text" value="{{$field?->nama_kolom}}" name="nama_kolom" id="" class=" form-control form-control-sm"></td>
    <td>
        <select name="jenis_input" id="" class="form-control form-control-sm">
        <option value="">--jenis--</option>
        @foreach(config('master.formulir.jenis_input') as $row)
        <option {{$field && $field->jenis_input==$row ? 'selected':''}} value="{{$row}}">{{str($row)->headline()}}</option>
        @endforeach
        </select>
    </td>
    <td><input value="{{$field?->keterangan}}" type="text" name="keterangan_form" id="" class="form-control form-control-sm"></td>
    <td>
        <select name="wajib" id="" class="form-control form-control-sm">
        <option value="">--wajib--</option>
        @foreach(config('master.formulir.wajib') as $row)
        <option {{$field && $field->wajib==$row ? 'selected':''}} value="{{$row}}">{{str($row)->headline()}}</option>
        @endforeach
        </select>
    </td>
    <td>
        <select name="status" id="" class="form-control form-control-sm">
        <option value="">--status--</option>
        @foreach(config('master.formulir.status') as $row)
        <option {{$field && $field->status==$row ? 'selected':''}} value="{{$row}}">{{str($row)->headline()}}</option>
        @endforeach
        </select>
    </td>
    <td><input value="{{$field?->urutan}}" type="number" name="urutan" id="" class="form-control form-control-sm"></td>
    <td><input value="{{$field?->petunjuk}}" type="text" name="petunjuk" id="" class="form-control form-control-sm"></td>
    </tr>
    <tr>
        <td colspan="8" class="text-end">
           @if(request('field_id'))
           <button class="btn btn-sm btn-warning" type="submit" name="updatefield" value="{{request('field_id')}}">
            Update
           </button>
           <a class="btn btn-sm btn-danger" href="{{url()->current()}}">
            Batal
           </a>
           @else
           <button class="btn btn-sm btn-warning" type="submit" name="createfield" value="true">
            Tambah Field
           </button>
           @endif
        </td>
    </tr>
</tbody>
</table>
