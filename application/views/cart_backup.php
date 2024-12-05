<div class="content">
    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            Keranjang
        </h2>
        <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
            <a href="<?= site_url('dashboard/clear') ?>" class="btn btn-danger shadow-md mr-2">Bersihkan Keranjang</a>
            <a href="<?= site_url('dashboard') ?>" class="btn btn-primary shadow-md mr-2">Lanjut Berbelanja</a>
        </div>
    </div>
    <!-- BEGIN: Transaction Details -->
    <div class="intro-y grid grid-cols-11 gap-5 mt-5">

        <div class="col-span-12 lg:col-span-12 2xl:col-span-8">
            <div class="box p-5 rounded-md">
                <div class="flex items-center border-b border-slate-200/60 dark:border-darkmode-400 pb-5 mb-5">
                    <div class="font-medium text-base truncate">Daftar Keranjang</div>
                    <a href="<?= site_url('dashboard/checkout') ?>" class="flex items-center ml-auto btn btn-primary shadow-md mr-2"><i data-lucide="activity" class="w-4 h-4 mr-2"></i>&nbsp;BAYAR SEKARANG </a>
                </div>
                <div class="overflow-auto lg:overflow-visible -mt-3">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th class="whitespace-nowrap">
                                    <input class="form-check-input" type="checkbox">
                                </th>
                                <th class="whitespace-nowrap !py-5">Produk</th>
                                <th class="whitespace-nowrap text-right">Harga</th>
                                <th class="whitespace-nowrap text-right">Jumlah</th>
                                <th class="whitespace-nowrap text-right">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $no = 1;
                                $total_price = [];
                            foreach ($cartItems as $items) : ?>
                                <?php
                                    $options = json_decode($items->options);
                                    $subtotal = $items->price * $items->quantity;
                                    $total_price[] = $subtotal;
                                ?>
                                <tr>
                                    <td><a href=""><i data-lucide="trash-2" class="w-4 h-4"></i></a></td>
                                    <td class="!py-4">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 image-fit zoom-in">
                                                <img class="rounded-lg border-2 border-white shadow-md tooltip" src="<?= base_url() . '/uploads/' . $options->gambar; ?>">
                                            </div>
                                            <a href="" class="font-medium whitespace-nowrap ml-4"><?= $items->name; ?></a>
                                        </div>
                                    </td>
                                    <td class="text-right">Rp. <?= number_format($items->price, 0, ',', '.') ?></td>
                                    <td class="text-right">
                                        <form action="<?= base_url('cart/updateQuantity/' . $items->id) ?>" method="POST" class="d-inline">
                                            <button type="submit" name="action" value="decrease" class="btn btn-sm btn-danger">-</button>
                                            <input type="text" class="form-control d-inline-block text-center" name="quantity" value="<?= $items->quantity ?>" style="width: 60px;">
                                            <button type="submit" name="action" value="increase" class="btn btn-sm btn-success">+</button>
                                        </form>
                                    </td>
                                    <td class="text-right">Rp. <?= number_format($subtotal, 0, ',', '.') ?></td>
                                </tr>
                            <?php endforeach; ?>
                            <tr>
                                <td colspan="4"></td>
                                <td class="text-right"><strong>Rp. <?= number_format(array_sum($total_price), 0, ',', '.') ?>,-</strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Transaction Details -->
</div>