@extends('backend.layout.app')
@section('content')
<div class="row">

    <div class="col-md-12">

        <div class="tile">
            <h6 class="tile-title mb-3 "><span  style="font-size:18px">{{config('module.page.form_title')}}</span>  <div class="btn-group float-end"><a href="{{route(get_module())}} " class="btn btn-sm btn-danger"> <i class="bi bi-arrow-counterclockwise"></i> Kembali</a></div></h6>

            <div class="tile-body pt-3 border-top">
                <div class="row">
                    <div class="col-md-4 mb-4">
                    <h5 class=" pb-3 mb-2">Kartu</h5>

                    <img  src="{{img_kartu($data->penduduk->nik_penduduk)}}" style="width:100%;border-radius:5px" alt="">
                    <table style="width:100%" class="mt-3">
                        <tr>
                            <td>Status Kartu</td>
                            <td class="fw-bold " align="right">{!!$data->blokir=='0' ? '<b class="badge bg-success">Aktif</b>' : '<b class="badge bg-danger">Tidak Aktif</b>'!!}</td>
                        </tr>
                    </table>
                    </div>
                    <div class="col-md-8">
                        <h5 class=" pb-3 mb-2">Detail Penerima</h5>
            <div class="mb-3 row border-bottom">
                    <label class="form-label col-md-2 ">NIK Penerima</label>
                    <div class="col-md-10 fw-bold">
                      {{$data->penduduk->nik_penduduk}}
                    </div>
                  </div>
                <div class="mb-3 row border-bottom">
                    <label class="form-label col-md-2">Nama Penerima</label>
                    <div class="col-md-10  fw-bold">
                      {{$data->penduduk->nama_lengkap}}
                    </div>
                </div>
                <div class="mb-3 row border-bottom">
                    <label class="form-label col-md-2">Alamat</label>
                    <div class="col-md-10  fw-bold">
                      {{$data->penduduk->alamat_jalan}}
                    </div>
                </div>
                <div class="mb-3 row border-bottom">
                    <label class="form-label col-md-2">Kelurahan/Desa</label>
                    <div class="col-md-10 fw-bold">
                      {{$data->penduduk->desa->nama}}
                    </div>
                </div>
                <div class="mb-3 row border-bottom">
                    <label class="form-label col-md-2">Kecamatan</label>
                    <div class="col-md-10 fw-bold">
                      {{$data->penduduk->desa->kecamatan->nama_kecamatan}}
                    </div>
                </div>
                <div class="mb-3 row border-bottom">
                    <label class="form-label col-md-2">Program </label>
                    <div class="col-md-10 fw-bold">
                      {{$data->program->nama}}
                    </div>
                </div>
                <div class="mb-3 row border-bottom">
                    <label class="form-label col-md-2">Tahun Penetapan </label>
                    <div class="col-md-10 fw-bold">
                      {{$data->tahun}}
                    </div>
                </div>
                <div class="mb-3 row border-bottom">
                    <label class="form-label col-md-2">Status Penerima </label>
                    <div class="col-md-10 fw-bold">
                      {{$data->status_penerima}}
                    </div>
                </div>
                </div>
                </div>
                <div class="mb-3 row">
                    <div class="col-mg-12">
                        <h5>Riwayat Penyaluran </h5>
                    </div>
                    <div class="col-lg-12 table-responsive">

                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                <th>No</th>
                                <th>Periode</th>
                                <th>Nominal</th>
                                <th>Agen</th>
                                <th>Jml Transaksi</th>
                                <th>Waktu</th>
                                <th>Status Periode</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($riwayat_transaksi as $k=>$row)
                                <tr>
                                    <td>{{$k+1}}</td>
                                    <td>{{$row->periode}}</td>
                                    <td>{{$row->jumlah_penyaluran}}</td>
                                    <td>{{$row->agen}}</td>
                                    <td>{{$row->jumlah_transaksi}}</td>
                                    <td>{{$row->waktu_transaksi ? date('d/m/Y H:i:s T',strtotime($row->waktu_transaksi)) : 'Belum Transaksi'}}</td>
                                    <td>{{$row->status_periode}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
          </div>
    </div>

  </div>

@endsection
