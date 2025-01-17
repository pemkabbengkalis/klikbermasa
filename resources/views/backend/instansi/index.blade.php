@extends('backend.layout.app')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="tile-title mb-3 text-end"><a href="{{route('instansi.create')}}" class="btn btn-sm btn-primary"> <i class="bi bi-plus"></i> Tambah</a> </div>

            <table class="table table-hover table-striped table-bordered" id="datatable">
              <thead>
                <tr>
                  <th width="20px">No</th>
                  <th>Nama Instansi</th>
                  <th>Singkatan</th>
                  <th>Alamat</th>
                  <th>Logo</th>
                  <th width="60px">Aksi</th>
                </tr>
            </thead>
            </table>
    </div>
  </div>
@include('backend.instansi.datatable')
@push('scripts')
<script>
    function deldata(id) {
        const url = `{{ route('instansi.destroy', ':id') }}`.replace(':id', id);
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
@endpush
@endsection
