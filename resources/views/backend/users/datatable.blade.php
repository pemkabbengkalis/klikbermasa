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
                    data: 'instansi.nama',
                    name: 'instansi.nama',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'name',
                    name: 'name',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'email',
                    name: 'email',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'username',
                    name: 'username',
                    orderable: true,
                    searchable: true
                },

                {
                    data: 'last_login_ip',
                    name: 'last_login_ip',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'last_login_time',
                    name: 'last_login_time',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'status',
                    name: 'status',
                    className: 'text-center',
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


