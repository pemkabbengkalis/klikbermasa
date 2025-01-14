<script type="text/javascript">
    window.addEventListener('DOMContentLoaded', function() {
        var table = $('#datatable').DataTable({
            responsive: false,
            processing: true,
            serverSide: true,
            aaSorting: [],

            ajax: {
                type: "POST",
                url: "{{ route(get_module().'.datatable') }}",
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
                    data: 'foto',
                    name: 'foto',
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


