<div class="content">
    <h2 class="intro-y text-lg font-medium mt-10">
        Riwayat Order
    </h2>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <!-- BEGIN: Data List -->
        <div class="intro-y col-span-12 overflow-auto 2xl:overflow-visible">
            <div class="box" style="padding: 20px;">
                <div class="table-responsive">
                    <table class="table table-report -mt-2 datatables display">
                        <thead>
                            <tr>
                                <th class="whitespace-nowrap">NO. TRANSAKSI</th>
                                <th class="whitespace-nowrap">NAMA PEMBELI</th>
                                <th class="text-left whitespace-nowrap">ALAMAT PENERIMA</th>
                                <th class="whitespace-nowrap">JASA PENGIRIMAN</th>
                                <th class="whitespace-nowrap">WAKTU TRANSAKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($order as $row) : ?>
                            <tr class="intro-x">
                                <td class="w-40 !py-4"> <a href="<?= site_url('order/detail/'.$row->order_id) ?>" class="underline decoration-dotted whitespace-nowrap">#<?= $row->order_id ?></a> </td>
                                <td class="w-40">
                                    <a href="" class="font-medium whitespace-nowrap"><?= $row->name ?></a>
                                </td>
                                <td class="text-left">
                                    <div class="flex items-left justify-left whitespace-nowrap"> <?= $row->alamat ?>, <?= $row->city ?>, <?= $row->kode_pos ?> </div>
                                </td>
                                    <td>
                                    <?php if ($row->ekspedisi == "jne"){ ?>
                                    <div class="flex items-center whitespace-nowrap text-pending text-uppercase"> <i data-lucide="package" class="w-4 h-4 mr-2"></i> <b>JNE</b> </div>
                                    <?php } else if ($row->ekspedisi == "j&t"){ ?>
                                    <div class="flex items-center whitespace-nowrap text-danger text-uppercase"> <i data-lucide="package" class="w-4 h-4 mr-2"></i> <b>J&T Express</b> </div>
                                    <?php } else if ($row->ekspedisi == "tiki"){ ?>
                                    <div class="flex items-center whitespace-nowrap text-danger text-uppercase"> <i data-lucide="package" class="w-4 h-4 mr-2"></i> <b>TIKI</b> </div>
                                    <?php } else if ($row->ekspedisi == "pos"){ ?>
                                    <div class="flex items-center whitespace-nowrap text-danger text-uppercase"> <i data-lucide="package" class="w-4 h-4 mr-2"></i> <b>POS INDONESIA</b> </div>
                                    <?php } else if ($row->ekspedisi == "sicepat"){ ?>
                                    <div class="flex items-center whitespace-nowrap text-danger text-uppercase"> <i data-lucide="package" class="w-4 h-4 mr-2"></i> <b>SICEPAT</b> </div>
                                    <?php } else if ($row->ekspedisi == "anteraja"){ ?>
                                    <div class="flex items-center whitespace-nowrap text-primary text-uppercase"> <i data-lucide="package" class="w-4 h-4 mr-2"></i> <b>ANTERAJA</b> </div>
                                    <?php } else if ($row->ekspedisi == "GO-SEND"){ ?>
                                    <div class="flex items-center whitespace-nowrap text-success text-uppercase"> <i data-lucide="package" class="w-4 h-4 mr-2"></i> <b>GO-SEND</b> </div>
                                    <?php } else if ($row->ekspedisi == "GRAB-SEND"){ ?>
                                    <div class="flex items-center whitespace-nowrap text-success text-uppercase"> <i data-lucide="package" class="w-4 h-4 mr-2"></i> <b>GRAB-SEND</b> </div>
                                    <?php } ?>
                                </td>
                                <td>
                                    <div class="text-slate-500 whitespace-nowrap mt-0.5"><?= $row->transaction_time ?></div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
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