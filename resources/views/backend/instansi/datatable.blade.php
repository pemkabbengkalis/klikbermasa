<script type="text/javascript">
    window.addEventListener('DOMContentLoaded', function() {
        var table = $('#datatable').DataTable({
            responsive: false,
            processing: true,
            serverSide: true,
            aaSorting: [],

            ajax: {
                type: "GET",
                url: "{{ route('instansi.index') }}",
                data: { _token: "{{csrf_token()}}"},

            },
            lengthMenu: [10, 20, 50, 100, 200, 500],
            deferRender: true,
            columns: [
                {
                    className: 'text-center',
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },

                {
                    data: 'nama',
                    name: 'nama',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'singkatan',
                    name: 'singkatan',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'alamat',
                    name: 'alamat',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'logo',
                    name: 'logo',
                    orderable: true,
                    searchable: true
                },
                {
                    className: 'text-center',
                    data: 'aksi',
                    name: 'aksi',
                    orderable: false,
                    searchable: false
                },
            ],

        });


    });
</script>


