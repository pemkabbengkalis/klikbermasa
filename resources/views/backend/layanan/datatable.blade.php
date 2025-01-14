<script type="text/javascript">
    window.addEventListener('DOMContentLoaded', function() {
        var table = $('#datatable').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            aaSorting: [],
            language: {
        searchPlaceholder: 'Cari...'
    },
            ajax: {
                type: "GET",
                url: "{{ route('layanan.index') }}",
                data:{_token : "{{csrf_token()}}"}
            },
            lengthMenu: [10, 50, 100, 200, 500],
            deferRender: true,
            columns: [
                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'icon',
                    name: 'icon',
                    orderable: false,
                    searchable: true
                },
                {
                    data: 'nama',
                    name: 'nama',
                    orderable: false,
                    searchable: true
                },
                {
                    data: 'kategori',
                    name: 'kategori',
                    orderable: false,
                    searchable: true
                },
                {
                    data: 'jenis',
                    name: 'jenis',
                    orderable: false,
                    searchable: true
                },

                {
                    data: 'data_pengajuan_layanan_count',
                    name: 'data_pengajuan_layanan_count',
                    className:'text-center',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'hits',
                    name: 'hits',
                    className:'text-center',
                    orderable: false,
                    searchable: true
                },
                {
                    data: 'status',
                    className:'text-center',
                    name: 'status',
                    orderable: false,
                    searchable: true
                },
                {
                    data: 'aksi',
                    name: 'aksi',
                    className:'text-center',
                    orderable: false,
                    searchable: false
                },
            ],

        });


    });
</script>


