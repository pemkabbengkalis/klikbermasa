@extends('backend.layout.app')
@section('content')
<div class="row">
    <div class="col-md-12">

        <div class="tile pt-3">
            <h6 class="tile-title mb-3 mt-0"><span  style="font-size:18px">{{config('menu.active.title')}}</span> </h6>
            <form class="form-horizontal border-top" action="{{ $data ? route('user.update',$data->id) : route('user.store')}}" method="post">
                @csrf
                @if($data)
                @method('PUT')
                @endif
            <div class="tile-body pt-3">
                @foreach(json_decode(json_encode(config('master.user_data'))) as $row)
                <div class="mb-3 row">
                    <label class="form-label col-md-2">{{ str($row->field)->upper() }}</label>
                    <div class="col-md-10">
                        @if($row->type=='file')
                        @if($data)
                        <img src="{{ isset(json_decode(json_encode($data->user_data),true)[$row->field]) ? json_decode(json_encode($data->user_data),true)[$row->field] : '/noimage.webp' }}" height="100" alt="">
                        @endif
                        @else
                      <input class="form-control" type="text" name="name" value="{{$data?->name}}" placeholder="Masukkan {{ str($row->field)->headline() }}">
                        @endif
                    </div>
                </div>
                @endforeach
                <div class="mb-3 row">
                    <label class="form-label col-md-2">Nama Lengkap</label>
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
                  <div class="btn-group"><button class="btn btn-primary btn-sm" type="submit"><i class="bi bi-check-circle-fill me-2"></i> Simpan</button><a href="{{route('user.index')}} " class="btn btn-sm btn-danger"> <i class="bi bi-arrow-counterclockwise"></i> Batal</a></div>
                </div>
              </div>
            </div>
        </form>

          </div>
    </div>

  </div>

@endsection
