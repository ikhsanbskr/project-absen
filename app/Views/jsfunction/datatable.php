<script>
    var minDate, maxDate;

    // Filter Tanggal
    $.fn.dataTable.ext.search.push(
        function(settings, data, dataIndex) {
            var min = minDate.val();
            var max = maxDate.val();
            var date = new Date(data[3]);

            if (
                (min === null && max === null) ||
                (min === null && date <= max) ||
                (min <= date && max === null) ||
                (min <= date && date <= max)
            ) {
                return true;
            }
            return false;
        }
    );

    $(function() {
        // Format Input Tanggal
        minDate = new DateTime($('#min'), {
            format: 'YYYY-MM-DD'
        });
        maxDate = new DateTime($('#max'), {
            format: 'YYYY-MM-DD'
        });

        var table = $("#tb_absen, #tb_karyawan, #tb_kelola_absen, #tb_dashboard, #tb_lap_activity").DataTable({
            columnDefs: [{
                searchable: false,
                orderable: false,
                targets: 0,
            }],
            order: [
                [3, 'asc']
            ],
            "responsive": true,
            "language": {
                "info": "Menampilkan _START_ s/d _END_ dari _TOTAL_ entry data",
                "infoEmpty": "Menampilan 0 - 0 dari 0 entry data",
                "emptyTable": "Tidak ada data yang tersedia",
                "search": "Search :"
            },
            "bLengthChange": false,
            // "dom": 'Bfrtip',
            // "buttons": [{
            //     extend: "pdf",
            //     text: "<i class='fas fa-print'></i> Export PDF"
            // }]
        });

        table.on('order.dt search.dt', function() {
            let i = 1;

            table.cells(null, 0, {
                search: 'applied',
                order: 'applied'
            }).every(function(cell) {
                this.data(i++);
            });
        }).draw();

        $('a.toggle-vis').on('click', function(e) {
            e.preventDefault();

            // Get the column API object
            var column = table.column($(this).attr('data-column'));

            // Toggle the visibility
            column.visible(!column.visible());
        });

        // .buttons().container().appendTo('#tb_absen_wrapper .col-md-6:eq(0)');

        // Function yang tidak jadi terpakai (Filter melalui datatable)

        // $('#min, #max, #select-nama').on('change', function() {
        //   table.draw();
        // });

        // $('#filter').on('click', function() {
        //     table.column(1).search($('#select-nama').val())
        //     table.draw();
        // });

    });
</script>