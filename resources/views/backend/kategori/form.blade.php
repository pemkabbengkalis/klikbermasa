@extends('backend.layout.app')
@section('content')
<div class="row">
    <div class="col-md-12">

        <div class="tile">
            <h6 class="tile-title mb-3 "><span  style="font-size:18px">{{config('menu.active.title')}}</span></h6>
            <form class="form-horizontal border-top" action="{{ $data ? route('kategori.update',$data->id) : route('kategori.store')}}" method="post" enctype="multipart/form-data">
                @csrf
                @if($data)
                @method('PUT')
                @endif
            <div class="tile-body pt-3">
            <div class="mb-3 row">
                    <label class="form-label col-md-3">Instansi Terkait</label>
                    <div class="col-md-9">
                        @if($data && $data->instansi)
                        <input type="text" disabled value="{{$data->instansi->nama}}" id="" class="form-control">
                        @else
                    <select name="instansi_id" id="" class="form-control form-control-select">
                        <option value="">--pilih instansi--</option>
                        @foreach(\App\Models\Instansi::whereDoesntHave('kategori')->get() as $row)
                        <option value="{{$row->id}}" {{$data && $data->instansi_id==$row->id?'selected':''}}> {{$row->nama}}</option>
                        @endforeach
                      </select>
                      @endif
                    </div>
                  </div>
                  <div class="mb-3 row">
                    <label class="form-label col-md-3">Nama Kategori</label>
                    <div class="col-md-9">
                      <input maxlength="16" class="form-control" name="nama" type="text" placeholder="Masukkan Nama Kategori" value="{{$data?->nama}}">
                    </div>
                  </div>
                  <div class="mb-3 row">
                    <label class="form-label col-md-3">Icon</label>
                    <div class="col-md-9">
                        @if($data && $data->icon && media_exists($data->icon))
                        <img src="{{ $data->icon }}" height="80" alt="" class="src">
                        <br>
                        <br>
                        @endif
                      <input accept="image/*" type="file" class="form-control form-control-file" name="file"  placeholder="Masukkan Nama Kategori" >
                    </div>
                  </div>
                  <div class="mb-3 row">
                    <label class="form-label col-md-3">Urutan</label>
                    <div class="col-md-9">
                      <input maxlength="3" class="form-control" name="sort" type="number" placeholder="Masukkan angka" value="{{$data?->sort}}">
                    </div>
                  </div>


            </div>
            <div class="tile-footer text-end">
                <div class="row">
                    <div class="col-md-12 ">
                      <div class="btn-group"><button class="btn btn-primary btn-sm" type="submit"><i class="bi bi-check-circle-fill me-2"></i> Simpan</button><a href="{{route('kategori.index')}} " class="btn btn-sm btn-danger"> <i class="bi bi-arrow-counterclockwise"></i> Batal</a></div>
                    </div>
                  </div>
            </div>
        </form>

          </div>
    </div>

  </div>

@endsection
