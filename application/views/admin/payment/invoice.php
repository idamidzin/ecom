    <div class="content">
        <h2 class="intro-y text-lg font-medium mt-10">
            Order Transaksi
        </h2>
        <div class="grid grid-cols-12 gap-6 mt-5">
            <div class="intro-y col-span-12 flex flex-wrap xl:flex-nowrap items-center mt-2">
                <div class="flex w-full sm:w-auto">
                    <div class="w-48 relative text-slate-500">
                        <input type="text" name="search" class="form-control w-48 box pr-10" placeholder="Cari disini">
                        <i class="w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0" data-lucide="search"></i> 
                    </div>
                    <select class="form-select box ml-2" name="status_filter">
                        <option value="all">Semua Status</option>
                        <option value="pending">Pending</option>
                        <option value="done">Selesai</option>
                    </select>
                </div>
                <div class="hidden xl:block mx-auto text-slate-500"></div>
            </div>
            <div class="intro-y col-span-12 overflow-auto 2xl:overflow-visible">
                <div class="box" style="padding: 20px;">
                    <table id="orderTable" class="table table-report -mt-2">
                        <thead>
                            <tr>
                                <th class="whitespace-nowrap">ORDER ID</th>
                                <th class="whitespace-nowrap">CUSTOMER NAME</th>
                                <th class="whitespace-nowrap">TRANSACTION TIME</th>
                                <th class="whitespace-nowrap">PROOF OF PAYMENT</th>
                                <th class="whitespace-nowrap">STATUS</th>
                                <th class="text-center whitespace-nowrap">ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div id="delete-confirmation-modal" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <div class="p-5 text-center">
                        <i data-lucide="x-circle" class="w-16 h-16 text-danger mx-auto mt-3"></i> 
                        <div class="text-3xl mt-5">Are you sure?</div>
                        <div class="text-slate-500 mt-2">
                            Do you really want to delete these records? 
                            <br>
                            This process cannot be undone.
                        </div>
                    </div>
                    <div class="px-5 pb-8 text-center">
                        <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-24 mr-1">Cancel</button>
                        <button type="button" class="btn btn-danger w-24">Delete</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function () {
    // Inisialisasi DataTables
    var table = $('#orderTable').DataTable({
        processing: true,
        serverSide: true,
        lengthChange: false,
        searching: false,
        ajax: {
            url: '<?= site_url("admin/invoice/ajaxList") ?>',
            type: 'POST',
            data: function (d) {
                d.search_query = $('input[name="search"]').val(); // Ambil nilai pencarian
                d.status_filter = $('select[name="status_filter"]').val(); // Ambil nilai filter status
            }
        },
        columns: [
            { data: 'order_id' },
            { data: 'name' },
            { data: 'transaction_time' },
            { data: 'proof_of_payment', orderable: false },
            { data: 'status' },
            { data: 'actions', orderable: false }
        ]
    });

    // Event untuk pencarian
    $('input[name="search"]').on('keyup', function () {
        table.ajax.reload(); // Reload DataTables setiap kali input berubah
    });

    // Event untuk filter status
    $('select[name="status_filter"]').on('change', function () {
        table.ajax.reload(); // Reload DataTables setiap kali filter status berubah
    });
});
</script>
