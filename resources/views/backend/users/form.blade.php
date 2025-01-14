@extends('backend.layout.app')
@section('content')
<div class="row">
    <div class="col-md-12">

        <div class="tile pt-3">
            <h6 class="tile-title mb-3 mt-0"><span  style="font-size:18px">{{config('module.page.form_title')}}</span> </h6>
            <form class="form-horizontal border-top" action="{{ $data ? route(get_module().'.update',$data->id) : route(get_module().'.store')}}" method="post">
                @csrf
                @if($data)
                @method('PUT')
                @endif
            <div class="tile-body pt-3">
            @if(!$data)

            <div class="mb-3 row">
                    <label class="form-label col-md-2">Instansi</label>
                    <div class="col-md-10">
                      <select name="instansi_id" id="" class="form-control form-control-select">
                        <option value="">--pilih instansi--</option>
                        @foreach(\App\Models\Instansi::doesntHave('user')->get() as $row)
                        <option value="{{$row->id}}"> {{$row->nama}}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  @endif
                <div class="mb-3 row">
                    <label class="form-label col-md-2">Nama User</label>
                    <div class="col-md-10">
                      <input class="form-control" type="text" name="name" value="{{$data?->name}}" placeholder="Masukkan Nama User">
                    </div>
                  </div>
                  <div class="mb-3 row">
                    <label class="form-label col-md-2">Email</label>
                    <div class="col-md-10">
                      <input class="form-control" type="email" name="email" value="{{$data?->email}}" placeholder="Masukkan Email">
                    </div>
                  </div>
                  <div class="mb-3 row">
                    <label class="form-label col-md-2">Status</label>
                    <div class="col-md-10">
                        @foreach(['1'=>'Aktif','0'=>'Nonaktif'] as $k=>$row)
                      <input type="radio" name="status" value="{{$k}}" {{$data && $data->status==$k ? 'checked':''}}> {{$row}}
                      @endforeach
                    </div>
                  </div>
                  <div class="mb-3 row">
                    <label class="form-label col-md-2">Username</label>
                    <div class="col-md-10">
                      <input class="form-control" type="text" name="username" value="{{$data?->username}}" placeholder="Masukkan Username">
                    </div>
                  </div>
                  <div class="mb-3 row">
                    <label class="form-label col-md-2">Password</label>
                    <div class="col-md-10">
                      <input class="form-control" type="password" name="password" placeholder="Masukkan Password">
                    </div>
                  </div>
            </div>
            <div class="tile-footer border-top-none text-end">
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

@endsection
