@extends('backend.layout.app')
@section('content')
<div class="row">
    <div class="col-md-12">

        <div class="tile">
            <h6 class="tile-title mb-3 ">{{ config('menu.active.title') }}</h6>
            <form class="form-horizontal border-top" action="{{ $data ? route('layanan.update',$data?->id) : route('layanan.store')}}" method="post" enctype="multipart/form-data">
                @csrf
                @if($data)
                @method('PUT')
                @endif
            <div class="tile-body pt-3">
                @if(request()->user()->isAdmin())
                <div class="mb-3 row">
                    <label class="form-label col-md-2">Status Layanan</label>
                    <div class="col-md-10">
                    @foreach(['pending','published'] as $k=> $row)
                      <input {{$data && $data->status_layanan == $row ? 'checked':''}}  name="status_layanan" type="radio" value="{{$row}}"> {{str($row)->headline()}} &nbsp;&nbsp;&nbsp;
                      @endforeach
                    </div>
                  </div>
            <div class="mb-3 row">
                    <label class="form-label col-md-2">Instansi</label>
                    <div class="col-md-10">
                        @if( !$data)
                      <select name="instansi_id" id="" class="form-control form-control-select">
                        <option value="">--pilih instansi--</option>
                        @foreach(\App\Models\Instansi::get() as $row)
                        <option value="{{$row->id}}"> {{$row->nama}}</option>
                        @endforeach
                      </select>
                      @else
                      <input type="text" class="form-control" value="{{$data->instansi->nama}}" disabled id="">
                      @endif
                    </div>
                  </div>
                  @endif
                  <div class="mb-3 row">
                    <label class="form-label col-md-2">Nama Layanan</label>
                    <div class="col-md-10">
                      <input class="form-control"  name="nama" type="text" placeholder="Masukkan Nama Layanan" value="{{$data?->nama}}">
                    </div>
                  </div>
                  <div class="mb-3 row">

                    <label class="form-label col-md-2">Keterangan</label>
                    <div class="col-md-10">
                        <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-bs5.min.css" rel="stylesheet">
                      <textarea id="summernote" class="form-control"  name="deskripsi" placeholder="Masukkan Deskripsi Layanan">{{$data?->deskripsi}}</textarea>
<!-- Include Bootstrap Bundle JS -->

<!-- Include Summernote JS -->
<!-- include summernote css/js -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.js"></script>
<script>
  $('#summernote').summernote({
    height: 300,
  });
</script>
                    </div>
                  </div>

                  <div class="mb-3 row">
                    <label class="form-label col-md-2">Icon</label>
                    <div class="col-md-10">
                        @if($data && $data->icon && media_exists($data->icon))
                        <img src="{{ $data->icon }}" height="80" alt="" class="src">
                        <br>
                        <br>
                        @endif
                      <input accept="image/png,image/jpeg" type="file" class="form-control form-control-file" name="file" >
                    </div>
                  </div>

                  <div class="mb-3 row">
                    <label class="form-label col-md-2">Jenis Layanan</label>
                    <div class="col-md-10">
                        @foreach(config('master.jenis_layanan') as $row)
                      <input {{$data && $data->jenis == $row ? 'checked':''}}  name="jenis" type="radio" value="{{$row}}"> {{$row}} &nbsp;&nbsp;&nbsp;
                      @endforeach
                    </div>
                  </div>
                @if($data)
                @if($data->jenis=='APLIKASI')
                <div class="mb-3 row">
                    <label class="form-label col-md-2">Link Aplikasi</label>
                    <div class="col-md-10">
                      <input class="form-control"  name="link" type="text" placeholder="Masukkan Url Aplikasi" value="{{$data?->link}}">
                    </div>
                  </div>
                  <div class="mb-3 row">
                    <label class="form-label col-md-2">Tampil Dihalaman Utama</label>
                    <div class="col-md-10">
                    @foreach(['Tidak','Ya'] as $k=> $row)
                      <input {{$data && $data->display_to_home == $k ? 'checked':''}}  name="display_to_home" type="radio" value="{{$k}}"> {{$row}} &nbsp;&nbsp;&nbsp;
                      @endforeach
                    </div>
                  </div>
                @elseif($data->jenis=='API' || $data->jenis=='FORM')
                <div class="mb-3 row">
                    <label class="form-label col-md-2">Daftar API</label>
                    <div class="col-md-12">
                    @include('backend.'.get_module().'.api')
                    <h5>Paramater Store Data :</h5>
                    @include('backend.'.get_module().'.formulir')

                    </div>
                  </div>
                @else
                @endif

                @endif
            </div>
            <div class="tile-footer text-end">
                <div class="row">
                    <div class="col-md-12 ">
                      <div class="btn-group"><button class="btn btn-primary btn-sm" type="submit" name="updatelayanan" value="true"><i class="bi bi-check-circle-fill me-2"></i> Simpan</button><a href="{{ route('layanan.index') }}" class="btn btn-sm btn-danger"> <i class="bi bi-arrow-counterclockwise"></i> Batal</a></div>
                    </div>
                  </div>
            </div>
        </form>

          </div>
    </div>

  </div>

@endsection
