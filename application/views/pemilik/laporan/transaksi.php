<style>
.text-end {
    text-align: right;
}
</style>
<div class="content">
    <h2 class="intro-y text-lg font-medium mt-10">
        Laporan Transaksi
    </h2>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 flex flex-wrap xl:flex-nowrap items-center mt-2">
            <div class="flex w-full sm:w-auto">
                <div class="w-48 relative text-slate-500">
                    <input type="date" name="start_date" class="form-control w-48 box" value="<?= date('Y-m-d', strtotime('-1 month')) ?>">
                </div>
                <span style="font-size: 16px; margin-top: 6px; margin-left: 6px;">s/d</span>
                <div class="w-48 relative text-slate-500" style="margin-left: 5px;">
                    <input type="date" name="end_date" class="form-control w-48 box" value="<?= date('Y-m-d') ?>">
                </div>
                <select class="form-select box ml-2" name="status_filter">
                    <option value="all">Semua Status</option>
                    <option value="pending">Pending</option>
                    <option value="done">Selesai</option>
                </select>
            </div>
            <button id="btn-print" class="btn btn-primary ml-2">Cetak PDF</button>
            <div class="hidden xl:block mx-auto text-slate-500"></div>
        </div>
        <div class="intro-y col-span-12 overflow-auto 2xl:overflow-visible">
            <div class="box" style="padding: 20px;">
                <table id="orderTable" class="table table-report -mt-2">
                    <thead>
                        <tr>
                            <th class="whitespace-nowrap">No. Transaksi</th>
                            <th class="whitespace-nowrap">Pelanggan</th>
                            <th class="whitespace-nowrap" style="text-align: center !important;">Waktu Transaksi</th>
                            <th class="whitespace-nowrap" style="text-align: center !important;">Ekspedisi</th>
                            <th class="whitespace-nowrap" style="text-align: right !important;">Ongkir (Rp)</th>
                            <th class="whitespace-nowrap" style="text-align: right !important;">Subtotal (Rp)</th>
                            <th class="whitespace-nowrap" style="text-align: right !important;">Total (Rp)</th>
                            <th class="whitespace-nowrap" style="text-align: center !important;">Status</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function () {
    var table = $('#orderTable').DataTable({
        processing: true,
        serverSide: true,
        lengthChange: false,
        searching: false,
        ajax: {
            url: '<?= site_url("pemilik/laporan/ajaxList") ?>',
            type: 'POST',
            data: function (d) {
                d.status_filter = $('select[name="status_filter"]').val();
                d.start_date = $('input[name="start_date"]').val();
                d.end_date = $('input[name="end_date"]').val();
            }
        },
        columns: [
            { data: 'order_id', orderable: false },
            { data: 'name', orderable: false },
            { data: 'transaction_time', orderable: false, className: 'text-center' },
            { data: 'ekspedisi', orderable: false, className: 'text-center' }, // Align right
            { data: 'total_ongkir', orderable: false, className: 'text-end' }, // Align right
            { data: 'subtotal', orderable: false, className: 'text-end' }, // Align right
            { data: 'total', orderable: false, className: 'text-end' }, // Align right
            { data: 'status', orderable: false, className: 'text-center' },
        ],
        language: {
            zeroRecords: "Tidak ada data yang ditemukan", // Custom text
            infoEmpty: "Tidak ada data yang tersedia"
        },
    });

    // Event untuk filter status
    $('select[name="status_filter"]').on('change', function () {
        table.ajax.reload(); // Reload DataTables setiap kali filter status berubah
    });

    // Validasi input date
    $('input[name="start_date"]').on('change', function () {
        table.ajax.reload();
    });

    $('input[name="end_date"]').on('change', function () {
        table.ajax.reload();
    });

    $('#btn-print').on('click', function () {
        var startDate = $('input[name="start_date"]').val();
        var endDate = $('input[name="end_date"]').val();
        var statusFilter = $('select[name="status_filter"]').val();

        var params = {
            start_date: startDate,
            end_date: endDate,
            status_filter: statusFilter
        };

        var url = '<?= site_url("pemilik/laporan/cetak_pdf") ?>?' + $.param(params);
        // Redirect dengan target blank
        window.open(url, '_blank');
    });

});
</script>
