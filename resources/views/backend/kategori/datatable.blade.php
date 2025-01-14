<script type="text/javascript">
    window.addEventListener('DOMContentLoaded', function() {
        var table = $('#datatable').DataTable({

            responsive: true,
    //         rowReorder: {
    //     selector: 'td:nth-child(2)'
    // },

            processing: true,
            serverSide: true,
            aaSorting: [],
            language: {
        searchPlaceholder: 'Cari...'
    },
            ajax: {
                type: "GET",
                url: "{{ route('kategori.index') }}",
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
                    data: 'slug',
                    name: 'slug',
                    orderable: false,
                    searchable: true
                },
                {
                    data: 'url',
                    name: 'url',
                    orderable: false,
                    searchable: true
                },
                {
                    data: 'sort',
                    name: 'sort',
                    className:'text-center',
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


