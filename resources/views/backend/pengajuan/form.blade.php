@extends('backend.layout.app')
@section('content')
<div class="row">
    <div class="col-md-12">

        <div class="tile">
            <h6 class="tile-title mb-3 "><span  style="font-size:18px">{{config('module.page.form_title')}}</span></h6>
            <form class="form-horizontal border-top" action="{{ $data ? route(get_module().'.update',$penerima->id) : route(get_module().'.store')}}" method="post">
                @csrf
                @if($data)
                @method('PUT')
                @endif
            <div class="tile-body pt-3">
            <div class="mb-3 row">
                    <label class="form-label col-md-3">NIK Penduduk</label>
                    <div class="col-md-9">
                      <input maxlength="16" class="form-control" name="nik_penduduk" type="text" placeholder="Masukkan NIK Penduduk" value="{{$data?->nik_penduduk}}">
                    </div>
                  </div>
                <div class="mb-3 row">
                    <label class="form-label col-md-3">Nama Lengkap</label>
                    <div class="col-md-9">
                      <input class="form-control" name="nama_lengkap" type="text" placeholder="Masukkan Nama Lengkap" value="{{$data?->nama_lengkap}}">
                    </div>
                  </div>



                  <div class="mb-3 row">
                    <label class="form-label col-md-3">Alamat</label>
                    <div class="col-md-9">
                      <input class="form-control" name="alamat_jalan" type="text" placeholder="Masukkan Alamat Jalan" value="{{$data?->alamat_jalan}}">
                    </div>
                  </div>

                  <div class="mb-3 row">
                  <label class="form-label col-md-3">Kecamatan</label>
                  <div class="col-md-9">
                  <select class="form-control kecamatan" onchange="$('.kecamatan option[value='+this.value+']').attr('selected','selected');$('.agen > option').hide();$('.desa > option').hide();$('.desa > option').removeAttr('selected');$('.agen > option[kec-id='+this.value+']').show();$('.desa > option[kec-id='+this.value+']').show();$('.agen > option').removeAttr('selected');$('.agen')[0].selectedIndex = 0;">
                  <option value="">--pilih--</option>
                    @foreach(\App\Models\Kecamatan::get() as $r)
                    <option @if($data && $data->desa->kecamatan->id==$r->id) selected @endif value="{{$r->id}}">{{$r->nama_kecamatan}}</option>
                    @endforeach
                    </select>
                  </div>
                </div>
                <div class="mb-3 row">
                  <label class="form-label col-md-3">Desa</label>
                  <div class="col-md-9">
                  <select onchange="" name="desa_id" class="form-control desa" @if($data) onmouseover="$('.desa > option').hide();$('.desa > option').removeAttr('selected');$('.desa > option[kec-id={{$data->desa->kecamatan->id}}]').show();$('.desa > option[value={{$data->desa_id}}]').attr('selected','selected')" @else onmouseover="if($('.kecamatan option[selected=selected]').length == 0) {$('.desa > option').hide();}" @endif>
                    <option value="" kec-id="0">--pilih--</option>
                    @foreach(\App\Models\Desa::get() as $r)
                    <option @if($data && $data->desa->id==$r->id) selected @endif value="{{$r->id}}" kec-id="{{$r->kecamatan_id}}">{{$r->nama}}</option>
                    @endforeach
                    </select>
                  </div>
                </div>
                @if(!$data)

                <h5>Program yang diberikan :</h5>
                <div class="mb-3 row">
                  <label class="form-label col-md-3">Nama Program</label>
                  <div class="col-md-9">
                  <select required name="program_id"  class="form-control form-control-sm program" onchange="$('.program option[value='+this.value+']').attr('selected','selected');$('.periode > option').hide();$('.periode > option').removeAttr('selected');$('.periode > option[program-id='+this.value+']').show();$('.periode > option').removeAttr('selected');$('.periode')[0].selectedIndex = 0;">
                    <option value="">--pilih program--</option>
                    @foreach(request()->user()->program as $r)
                    <option value="{{$r->id}}">{{$r->nama}}</option>
                    @endforeach
                  </select>
                  </div>
                </div>
                <div class="mb-3 row">
                  <label class="form-label col-md-3">Periode Tahun</label>
                  <div class="col-md-9">
                  <select name="tahun" class="form-control form-control-sm" >
                    <option value="">--pilih tahun--</option>
                    @foreach(\App\Models\Periode::latest()->limit(1)->get() as $r)
                    <option value="{{$r->tahun}}">{{$r->tahun}}</option>
                    @endforeach
                  </select>
                  </div>
                </div>
                <h5>Agen Penyaluran :</h5>
                <div class="mb-3 row">
                  <label class="form-label col-md-3">Nama Agen</label>
                  <div class="col-md-9">
                  <select required name="agen_id"  class="form-control form-control-sm agen" @if($data) onmouseover="$('.agen > option').hide();$('.agen > option[kec-id={{$data->desa->kecamatan->id}}]').show();$('.agen > option[value={{$agen}}]').attr('selected','selected')" @else onmouseover="if($('.kecamatan option[selected=selected]').length == 0) {$('.agen > option').hide();}" @endif>
                    <option value="">--pilih agen--</option>
                    @foreach(\App\Models\Agen::with('desa.kecamatan')->get() as $r)
                    <option value="{{$r->id}}" kec-id="{{$r->desa->kecamatan->id}}" @if(isset($agen) && $agen==$r->id) selected @endif>{{$r->nama_agen}} milik {{$r->nama_pemilik}} | {{$r->alamat_agen}} | {{$r->desa->nama}} KECAMATAN {{$r->desa->kecamatan->nama_kecamatan}}</option>
                    @endforeach
                  </select>
                  </div>
                </div>
                <div class="mb-3 row">
                  <label class="form-label col-md-3">Periode Penyaluran</label>
                  <div class="col-md-9">
                  <select required name="periode_id"  class="form-control form-control-sm periode" @if($data) onmouseover="$('.periode > option').hide();$('.periode > option[program-id={{$penerima->program_id}}]').show().attr('selected','selected');" @else onmouseover="if($('.program option[selected=selected]').length == 0) {$('.periode > option').hide();}" @endif>
                    <option value="">--pilih periode--</option>
                    @foreach(\App\Models\Periode::with('program')->whereNotIn('status_periode',['selesai'])->get() as $r)
                    <option value="{{$r->id}}" program-id="{{$r->program_id}}" @if(isset($penerima) && $penerima->program_id==$r->program_id) selected @endif>{{$r->program->nama}} {{$r->nama_periode}}</option>
                    @endforeach
                  </select>
                  </div>
                </div>
                @endif

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

@endsection
