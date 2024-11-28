<div class="content">
    <h2 class="intro-y text-lg font-medium mt-10">
        Order Selesai
    </h2>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 overflow-auto 2xl:overflow-visible">
            <div class="box p-5">
                <table class="table table-report -mt-2 datatables display">
                    <thead>
                        <tr>
                            <th class="whitespace-nowrap">NO. TRANSAKSI</th>
                            <!-- <th class="whitespace-nowrap">TRACKING NUMBER</th> -->
                            <th class="whitespace-nowrap">METODE PEMBAYARAN</th>
                            <th class="whitespace-nowrap">WAKTU TRANSAKSI</th>
                            <th class="whitespace-nowrap">TRANSAKSI BERAKHIR</th>
                            <th class="whitespace-nowrap">STATUS</th>
                            <th class="whitespace-nowrap">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($bill as $row) : ?>
                            <tr class="intro-x">
                                <td class="w-40 !py-4"> <a href="<?= site_url('bill/detail/' . $row->order_id) ?>" class="underline decoration-dotted whitespace-nowrap">#<?= $row->order_id ?></a> </td>
                                <td class="w-40">
                                    <a href="" class="font-medium text-primary whitespace-nowrap"><?= $row->payment_method ?></a>
                                </td>
                                <td class="w-40">
                                    <a href="" class="font-medium whitespace-nowrap"><?= $row->transaction_time ?></a>
                                </td>
                                <td class="w-40">
                                    <a href="" class="font-medium whitespace-nowrap"><?= $row->payment_limit ?></a>
                                </td>
                                <td>
                                    <div class="flex items-center whitespace-nowrap text-success"> Sukses </div>
                                </td>
                                <td>
                                    <a class="btn btn-sm btn-rounded-success text-white">Terverifikasi</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>