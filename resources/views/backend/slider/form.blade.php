@extends('backend.layout.app')
@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="tile">
        <h6 class="tile-title mb-3"><span  style="font-size:18px">{{config('module.page.form_title')}}</span></h6>
        <form class="form-horizontal border-top" action="{{ $data ? route(get_module().'.update',$data->id) : route(get_module().'.store')}}" method="post" enctype="multipart/form-data">
            @csrf
            @if($data)
            @method('PUT')
            @endif
          <div class="tile-body pt-3">
            <div class="mb-3 row">
              <label class="form-label col-md-3">Judul</label>
              <div class="col-md-9">
                <input class="form-control" name="nama" type="text" placeholder="Masukkan Nama Instansi" value="{{$data?->nama}}">
              </div>
            </div>
            <div class="mb-3 row">
              <label class="form-label col-md-3">Foto Slider</label>
              <div class="col-md-9">
                <input class="form-control" name="file" type="file">
              </div>
            </div>
          </div>
          <div class="tile-footer text-end">
            <div class="row">
              <div class="col-md-12 ">
                <div class="btn-group"><button class="btn btn-primary btn-sm" type="submit"><i class="bi bi-check-circle-fill me-2"></i> Simpan</button><a href="{{route(get_module())}} " class="btn btn-sm btn-danger"> <i class="bi bi-arrow-counterclockwise"></i> Batal</a></div>
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
