@extends('backend.layout.app')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="tile-title mb-3 text-end"><a href="{{route(get_module().'.create')}}" class="btn btn-sm btn-primary"> <i class="bi bi-plus"></i> Tambah</a> </div>

            <table class="table table-hover table-striped table-bordered" id="datatable">
              <thead>
                <tr>
                  <th width="20px">No</th>
                  <th>Judul</th>
                  <th>Foto</th>
                  <th width="60px">Aksi</th>
                </tr>
            </thead>
            </table>
    </div>
  </div>
@include('backend.'.get_module().'.datatable')
@endsection
