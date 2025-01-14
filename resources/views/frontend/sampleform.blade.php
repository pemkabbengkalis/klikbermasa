{{$data->nama}}
@foreach($data->formulir_active as $row)
@php
$j = $row->jenis_input;
@endphp
{{$row->$j}}
@endforeach
