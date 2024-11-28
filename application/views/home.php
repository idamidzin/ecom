<div class="content">
    <h2 class="intro-y text-lg font-medium mt-10">
        Daftar Produk
    </h2>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
            <div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-0">
                <div class="w-56 relative text-slate-500">
                    <input 
                        type="text" 
                        id="search-input" 
                        class="form-control w-56 box pr-10" 
                        placeholder="Search..."
                    >
                    <i class="w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0" data-lucide="search"></i>
                </div>
            </div>
        </div>
    </div>
    <div id="product-container" class="grid grid-cols-12 gap-6 mt-5">
        <?php foreach ($product as $row) : ?>
            <div class="intro-y col-span-12 md:col-span-6 lg:col-span-4 xl:col-span-3">
                <div class="box">
                    <div class="p-5">
                        <div class="h-40 2xl:h-56 image-fit rounded-md overflow-hidden before:block before:absolute before:w-full before:h-full before:top-0 before:left-0 before:z-10 before:bg-gradient-to-t before:from-black before:to-black/10">
                            <img class="rounded-md" src="<?= base_url() . '/uploads/' . $row->gambar ?>">
                            <div class="absolute bottom-0 text-white px-5 pb-6 z-10"> <a href="" class="block font-medium text-base"><?= $row->nama_brg ?></a> <span class="text-white/90 text-xs mt-3"><?= $row->kategori ?></span> </div>
                        </div>
                        <div class="text-slate-600 dark:text-slate-500 mt-5">
                            <div class="flex items-center"> <i data-lucide="link" class="w-4 h-4 mr-2"></i> IDR <?= number_format($row->harga, 0, ',', '.') ?> </div>
                            <div class="flex items-center mt-2"> <i data-lucide="layers" class="w-4 h-4 mr-2"></i> Stok: <?= number_format($row->stok, 0, ',', '.') ?> </div>
                        </div>
                    </div>
                    <div class="flex justify-center lg:justify-end items-center p-5 border-t border-slate-200/60 dark:border-darkmode-400">
                    <a class="btn btn-primary w-full" href="javascript:;" data-tw-toggle="modal" data-tw-target="#checkout-confirmation-modal"> <i data-lucide="shopping-cart" class="w-4 h-4 mr-1"></i> Masukan Keranjang </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<div id="checkout-confirmation-modal" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body p-0">
                <div class="p-5 text-center">
                    <i data-lucide="alert-circle" class="w-16 h-16 text-primary mx-auto mt-3"></i> 
                    <div class="text-3xl mt-5">Please Wait</div>
                    <div class="text-slate-500 mt-2">
                        Anda harus melakukan login terlebih dahulu 
                        <br>
                        Untuk melanjutkan proses checkout item.
                    </div>
                </div>
                <div class="px-5 pb-8 text-center">
                    <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-24 mr-1">Cancel</button>
                    <a href="<?= site_url('welcome')?>" class="btn btn-primary w-24">Login</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function () {
    $('#search-input').on('keyup', function () {
        const keyword = $(this).val();

        $.ajax({
            url: '<?= site_url("ProductController/get_products") ?>',
            type: 'POST',
            data: {
                keyword,
                kategori: null,
            },
            dataType: 'json',
            success: function (data) {
                let html = '';

                if (data.length === 0) {
                    html = '<div class="intro-y col-span-12 text-center"><p class="text-gray-600">Produk tidak ditemukan.</p></div>';
                } else {
                    const siteUrl = "<?= site_url() ?>";
                    data.forEach(row => {
                        html += `
                            <div class="intro-y col-span-12 md:col-span-6 lg:col-span-4 xl:col-span-3">
                                <div class="box">
                                    <div class="p-5">
                                        <div class="h-40 2xl:h-56 image-fit rounded-md overflow-hidden before:block before:absolute before:w-full before:h-full before:top-0 before:left-0 before:z-10 before:bg-gradient-to-t before:from-black before:to-black/10">
                                            <img alt="${row.nama_brg}" class="rounded-md" src="<?= base_url('uploads/') ?>${row.gambar}">
                                            <div class="absolute bottom-0 text-white px-5 pb-6 z-10">
                                                <a href="" class="block font-medium text-base">${row.nama_brg}</a>
                                                <span class="text-white/90 text-xs mt-3">${row.kategori}</span>
                                            </div>
                                        </div>
                                        <div class="text-slate-600 dark:text-slate-500 mt-5">
                                            <div class="flex items-center">Price: IDR ${parseInt(row.harga).toLocaleString('id-ID')}</div>
                                            <div class="flex items-center mt-2">Remaining Stock: ${parseInt(row.stok).toLocaleString('id-ID')}</div>
                                        </div>
                                    </div>
                                    <div class="flex justify-center lg:justify-end items-center p-5 border-t border-slate-200/60 dark:border-darkmode-400">
                                        <a class="btn btn-primary w-full" href="${siteUrl}dashboard/cart/${row.id_brg}"> 
                                            <i data-lucide="shopping-cart" class="w-4 h-4 mr-1"></i> Masukan Keranjang 
                                        </a>
                                    </div>
                                </div>
                            </div>`;
                    });
                }
                $('#product-container').html(html);
            }
        });
    });
});
</script>