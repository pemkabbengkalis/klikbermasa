@extends('backend.layout.app')
@section('content')
<div class="row">
    <div class="col-md-6 col-lg-4">
      <div class="widget-small primary coloured-icon"><i class="icon bi bi-envelope-check fs-1"></i>
        <div class="info">
          <h4>Jumlah Layanan</h4>
          <p><b>{{ $jumlah_layanan }}</b></p>
        </div>
      </div>
    </div>

    <div class="col-md-6 col-lg-4">
      <div class="widget-small warning coloured-icon"><i class="icon bi bi-truck fs-1"></i>
        <div class="info">
          <h4>Permohonan</h4>
          <p><b>{{ $jumlah_permohonan }}</b></p>
        </div>
      </div>
    </div>
    <div class="col-md-6 col-lg-4">
      <div class="widget-small danger coloured-icon"><i class="icon bi bi-ui-checks fs-1"></i>
        <div class="info">
          <h4>Tugas Disposisi</h4>
          <p><b>500</b></p>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6">
      <div class="tile">
        <h3 class="tile-title">Weekly Sales - Last week</h3>
        <div class="ratio ratio-16x9">
          <div id="salesChart"></div>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="tile">
        <h3 class="tile-title">Support Requests</h3>
        <div class="ratio ratio-16x9">
          <div id="supportRequestChart"></div>
        </div>
      </div>
    </div>
  </div>
@endsection
