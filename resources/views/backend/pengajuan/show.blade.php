@extends('backend.layout.app')
@section('content')
<div class="row">

    <div class="col-md-12">

        <div class="tile">
            <h6 class="tile-title mb-3 "><span  style="font-size:18px">{{config('module.page.form_title')}}</span>  <div class="btn-group float-end"><a href="{{route(get_module())}} " class="btn btn-sm btn-danger"> <i class="bi bi-arrow-counterclockwise"></i> Kembali</a></div></h6>

            <div class="tile-body pt-3 border-top">
                <div class="row">
                    <div class="col-md-12">
            <div class="mb-3 row border-bottom">
                    <label class="form-label col-md-2 ">NIK Pemohon</label>
                    <div class="col-md-10 fw-bold">
                        {{ $data->user->nik }}
                    </div>
                  </div>
                <div class="mb-3 row border-bottom">
                    <label class="form-label col-md-2">Nama Pemohon</label>
                    <div class="col-md-10  fw-bold">
                        {{ $data->user->name }}
                    </div>
                </div>
                <div class="mb-3 row border-bottom">
                    <label class="form-label col-md-2">No HP</label>
                    <div class="col-md-10  fw-bold">
                        {{ $data->user->nohp }}
                    </div>
                </div>
                <div class="mb-3 row border-bottom">
                    <label class="form-label col-md-2">Alamat</label>
                    <div class="col-md-10  fw-bold">
                        {{ $data->user->alamat ?? '-' }}
                    </div>
                </div>
                <div class="mb-3 row border-bottom">
                    <label class="form-label col-md-2">Kelurahan / Desa</label>
                    <div class="col-md-10 fw-bold">
                        {{ $data->user->desa ?? '-' }}
                    </div>
                </div>
                </div>
                <div class="mb-3 row border-bottom">
                    <label class="form-label col-md-2">Kecamatan</label>
                    <div class="col-md-10 fw-bold">
                        {{ $data->user->kecamatan ?? '-' }}
                    </div>
                </div>
                </div>
                <h3>Data Permohonan : </h3>
                <div class="mb-3 row border-bottom">
                    <label class="form-label col-md-2">Nama Layanan </label>
                    <div class="col-md-10 fw-bold">
                        {{ $data->layanan->nama }}

                    </div>
                </div>
                <div class="mb-3 row border-bottom">
                    <label class="form-label col-md-2">Waktu Pengajuan</label>
                    <div class="col-md-10 fw-bold">  {{ $data->created_at }}
                        <sup class="badge bg-info">{{ $data->created_at->diffForHumans() }}</sup>
                    </div>
                </div>
                @foreach ($data->pengajuan as $item)
                <div class="mb-3 row border-bottom">
                    <label class="form-label col-md-2">{{ $item['title'] }}</label>
                    <div class="col-md-10 fw-bold">
                    @if (!in_array($item['type'],['image','file_pdf']))
                    {{ $item['value'] }}
                    @else
                    <a href="{{ stream_file($data->id,$item['id']) }}" class="btn btn-primary btn-sm mb-2">Lihat</a>
                    @endif
                    </div>
                </div>
                @endforeach

                </div>
                </div>

            </div>
          </div>
    </div>

  </div>

@endsection
