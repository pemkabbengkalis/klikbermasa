@extends('backend.layout.app')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="tile-title mb-3 text-end">
        <div class="btn-group">
        @if(Route::has('layanan.create'))
            <a href="{{route('layanan.create')}}" class="btn btn-sm btn-primary"> <i class="bi bi-plus"></i> Tambah</a>
        @endif
        </div>
        </div>

            <table class="table table-hover table-striped table-bordered" id="datatable">
              <thead>

                <tr>
                  <th width="30px" >No</th>
                  <th width="10px">Icon</th>
                  <th>Nama</th>
                  <th width="10px">Jenis</th>
                  <th width="10px">Pengajuan</th>
                  <th width="10px">Hits</th>
                  <th width="10px">Status</th>
                  <th width="10px">Aksi</th>
                </tr>
            </thead>

            </table>
    </div>
  </div>
@include('backend.layanan.datatable')
@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/rowreorder/1.4.1/css/rowReorder.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
@endpush
@push('scripts')
<script>
    function deldata(id) {
        const url = `{{ route('layanan.destroy', ':id') }}`.replace(':id', id);
        const data = {
            _method: "DELETE",
            _token: "{{ csrf_token() }}"
        };

        $.post(url, data, function(response) {
            $('.alert-success').show();
            $('.alert-success>span').text('Berhasil dihapus');
            $('#datatable').DataTable().ajax.reload()
        }).fail(function(error) {
            $('.alert-danger').show();
            $('.alert-danger>span').text('Gagal dihapus');
        });
    }
</script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/rowreorder/1.4.1/js/dataTables.rowReorder.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
@endpush
@endsection
