@extends('backend.layout.app')
@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="tile">
        <h6 class="tile-title mb-3"><span  style="font-size:18px">{{config('menu.active.name')}}</span></h6>
        <form class="form-horizontal border-top" action="{{ $data ? route('instansi.update',$data->id) : route('instansi.store')}}" method="post" enctype="multipart/form-data">
            @csrf
            @if($data)
            @method('PUT')
            @endif
          <div class="tile-body pt-3">
            <div class="mb-3 row">
              <label class="form-label col-md-3">Nama Instansi</label>
              <div class="col-md-9">
                <input class="form-control" name="nama" type="text" placeholder="Masukkan Nama Instansi" value="{{$data?->nama}}">
              </div>
            </div>
            <div class="mb-3 row">
              <label class="form-label col-md-3">Singkatan</label>
              <div class="col-md-9">
                <input class="form-control" name="singkatan" type="text" placeholder="Masukkan Singkatan" value="{{$data?->singkatan}}">
              </div>
            </div>
            <div class="mb-3 row">
              <label class="form-label col-md-3">Alamat</label>
              <div class="col-md-9">
                <input class="form-control" name="alamat" type="text" placeholder="Masukkan Alamat" value="{{$data?->alamat}}">
              </div>
            </div>
            <div class="mb-3 row">
              <label class="form-label col-md-3">Logo Instansi</label>
              <div class="col-md-9">
                @if($data && $data->icon && media_exists($data->icon))
                <img src="{{ $data->icon }}" height="80" alt="" class="src">
                <br>
                <br>
                @endif
                <input class="form-control" name="file" type="file">
              </div>
            </div>
          </div>
          <div class="tile-footer text-end">
            <div class="row">
              <div class="col-md-12 ">
                <div class="btn-group"><button class="btn btn-primary btn-sm" type="submit"><i class="bi bi-check-circle-fill me-2"></i> Simpan</button><a href="{{route('instansi.index')}} " class="btn btn-sm btn-danger"> <i class="bi bi-arrow-counterclockwise"></i> Batal</a></div>
              </div>
              </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  @push('scripts')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  @endpush
@endsection
