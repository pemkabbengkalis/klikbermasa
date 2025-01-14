 <!-- Essential javascripts for application to work-->


     @push('scripts')
         <link rel="stylesheet" href="https://cdn.datatables.net/v/bs5/dt-1.13.4/datatables.min.css">
         <!-- Data table plugin-->
         <script type="text/javascript" src="{{ url('backend/js/plugins/jquery.dataTables.min.js') }}"></script>
         <script type="text/javascript">
             $('#sampleTable').DataTable();
         </script>
     @endpush
     <script>
         function sw_delete(id) {
             Swal.fire({
                 title: "Yakin hapus data ?",
                 text: "Semua data yang terkait akan hilang!",
                 icon: "warning",
                 showCancelButton: true,
                 confirmButtonColor: "#3085d6",
                 cancelButtonColor: "#d33",
                 confirmButtonText: "Ya, Hapus!"
             }).then((result) => {
                 if (result.isConfirmed) {
                     $.ajax({
                         type: "POST",
                         url: "",
                         data: {
                             _token: "{{ csrf_token() }}",
                             _method: "delete"
                         },
                         success: function(response) {
                             if ($('#datatable').length) {
                                 $('#datatable').DataTable().ajax.reload();
                             } else {
                                 location.reload();
                             }
                         },
                         error: function(error) {
                            console.log("Error : ", error);
                            Swal.fire('Terjadi kesalahan...', 'Gagal!', 'error')
                             //...

                         }

                     });

                     Swal.fire({
                         title: "Terhapus!",
                         text: "Data kamu berhasil dihapus!",
                         icon: "success"
                     });
                 }
             });
         }
     </script>

 <script src="{{ url('backend/js/jquery-3.7.0.min.js') }}"></script>
 <script src="{{ url('backend/js/bootstrap.min.js') }}"></script>
 <script src="{{ url('backend/js/main.js') }}"></script>
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<script>
    $("#select2").select2({
    placeholder: "Pilih ",
});
</script>
 <script src=" https://cdn.jsdelivr.net/npm/sweetalert2@11.10.4/dist/sweetalert2.all.min.js "></script>
 @stack('scripts')
 <!-- Page specific javascripts-->
 <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/echarts@5.4.3/dist/echarts.min.js"></script>
 <script type="text/javascript">
     $('.copy').click(function() {
         var $temp = $("<input>");
         $("body").append($temp);
         $temp.val($(this).attr('data-copy')).select();
         document.execCommand("copy");
         alert('copied');
         $temp.remove();
     });

     const salesData = {
         xAxis: {
             type: 'category',
             data: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'ee','M55on', '7', 'ii', 'iiii', 'kk', 'oo', 'yy']
         },
         yAxis: {
             type: 'value',
             axisLabel: {
                 formatter: '${value}'
             }
         },
         series: [{
             data: [150, 230, 224, 218, 135, 147, 260,150, 230, 224, 218, 135, 147, 260],
             type: 'line',
             smooth: true
         }],
         tooltip: {
             trigger: 'axis',
             formatter: "<b>{b0}:</b> ${c0}"
         }
     }

     const supportRequests = {
         tooltip: {
             trigger: 'item'
         },
         legend: {
             orient: 'vertical',
             left: 'left'
         },
         series: [{
             name: 'Statistik Surat',
             type: 'pie',
             radius: '50%',
             data: [{
                     value: 300,
                     name: 'Surat Masuk'
                 },
                 {
                     value: 1000,
                     name: 'Surat Keluar'
                 },
                 {
                     value: 1000,
                     name: 'Surat Disposisi'
                 },
                 {
                     value: 1000,
                     name: 'Surat Ditugasi'
                 }
             ],
             emphasis: {
                 itemStyle: {
                     shadowBlur: 10,
                     shadowOffsetX: 0,
                     shadowColor: 'rgba(0, 0, 0, 0.5)'
                 }
             }
         }]
     };

     const salesChartElement = document.getElementById('salesChart');
     const salesChart = echarts.init(salesChartElement, null, {
         renderer: 'svg'
     });
     salesChart.setOption(salesData);
     new ResizeObserver(() => salesChart.resize()).observe(salesChartElement);

     const supportChartElement = document.getElementById("supportRequestChart")
     const supportChart = echarts.init(supportChartElement, null, {
         renderer: 'svg'
     });
     supportChart.setOption(supportRequests);
     new ResizeObserver(() => supportChart.resize()).observe(supportChartElement);
     const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
     const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
 </script>
 <!-- Google analytics script-->
 <script type="text/javascript">
     if (document.location.hostname == 'pratikborsadiya.in') {
         (function(i, s, o, g, r, a, m) {
             i['GoogleAnalyticsObject'] = r;
             i[r] = i[r] || function() {
                 (i[r].q = i[r].q || []).push(arguments)
             }, i[r].l = 1 * new Date();
             a = s.createElement(o),
                 m = s.getElementsByTagName(o)[0];
             a.async = 1;
             a.src = g;
             m.parentNode.insertBefore(a, m)
         })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');
         ga('create', 'UA-72504830-1', 'auto');
         ga('send', 'pageview');
     }
 </script>
 </body>

 </html>
