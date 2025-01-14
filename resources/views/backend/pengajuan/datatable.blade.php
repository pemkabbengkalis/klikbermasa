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
                type: "POST",
                url: "{{ route(get_module().'.datatable') }}",
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
                    data: 'layanan.nama',
                    name: 'layanan.nama',
                    orderable: false,
                    searchable: true
                },
                {
                    data: 'tiket.kode',
                    name: 'tiket.kode',
                    orderable: false,
                    searchable: true
                },
                {
                    data: 'nik',
                    name: 'nik',
                    orderable: false,
                    searchable: true
                },
                {
                    data: 'pemohon',
                    name: 'pemohon',
                    orderable: false,
                    searchable: true
                },

                {
                    data: 'created_at',
                    name: 'created_at',
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


