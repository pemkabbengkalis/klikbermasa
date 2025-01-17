@extends('backend.layout.app')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="tile-title mb-3 text-end">@if(Route::has('user.create'))<a href="{{route('user.create')}}" class="btn btn-sm btn-primary"> <i class="bi bi-plus"></i> Tambah</a> @endif</div>

            <table class="table table-hover table-striped table-bordered" id="datatable">
              <thead>
                <tr>
                  <th width="20px">No</th>
                  <th>NIK</th>
                  <th>Nama</th>
                  <th>Email</th>
                  <th>Terkahir Masuk</th>
                  <th>Status</th>
                  <th width="10px">Aksi</th>
                </tr>
            </thead>
            </table>
    </div>
  </div>
@include('backend.users.datatable')
@endsection
