<div class="content">
    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            Checkout Form
        </h2>
    </div>
    <div class=" pos intro-y grid grid-cols-12 gap-5 mt-5">
        <div class="intro-y col-span-12 lg:col-span-8">
            <div class="alert alert-primary show mb-2" role="alert">Jumlah Transaksi Yang Harus Dibayar : <b id="total-bayar-title">Rp. 0</b></div>
            <div class="post intro-y overflow-hidden box mt-5">
                <ul class="post__tabs nav nav-tabs flex-col sm:flex-row bg-slate-200 dark:bg-darkmode-800" role="tablist">
                    <li class="nav-item">
                        <button title="Silahkan isi detail pengiriman ini dengan benar" data-tw-toggle="tab" data-tw-target="#content" class="nav-link tooltip w-full sm:w-200 py-4 active" id="content-tab" role="tab" aria-controls="content" aria-selected="true"> <i data-lucide="file-text" class="w-4 h-4 mr-2"></i> Detail Pengiriman </button>
                    </li>
                </ul>
                <div class="post__content tab-content">
                    <form id="payment-form" action="<?= site_url('dashboard/checkout_proccess') ?>" method="post">
                        <div id="content" class="tab-pane p-5 active" role="tabpanel" aria-labelledby="content-tab">
                            <div class="border border-slate-200/60 dark:border-darkmode-400 rounded-md p-5">
                                <div class="font-medium flex items-center border-b border-slate-200/60 dark:border-darkmode-400 pb-5"> <i data-lucide="chevron-down" class="w-4 h-4 mr-2"></i> Informasi Penerima </div>
                                <div class="mt-5">
                                    <div class="mb-5">
                                        <label for="post-form-7" class="form-label">Nama <small class="text-danger">*</small></label>
                                        <input type="hidden" id="order_id" name="order_id" value="INV-<?= mt_rand(000000000, 111111111) ?>" maxlength="8" autocomplete="off" required>
                                        <input type="hidden" id="tracking_id" name="tracking_id" value="<?= mt_rand(0000000000000, 1111111111111) ?>" maxlength="12" autocomplete="off" required>
                                        <input type="hidden" name="payment_method" value="Direct Bank Transfer">
                                        <input type="hidden" name="id_user" id="id_user" value="<?php echo $this->session->userdata('id_user') ?>">
                                        <input type="hidden" name="status" id="status" value="0">
                                        <input type="hidden" name="ongkir" id="form-ongkir" value="0">
                                        <input type="hidden" name="subtotal" id="form-subtotal" value="0">
                                        <input type="hidden" name="total" id="form-total" value="0">
                                        <input type="text" class="form-control" id="name" name="name" value="<?php echo $this->session->userdata('nama_user') ?>" autocomplete="off" readonly>
                                    </div>

                                    <div class="mb-5">
                                        <label for="post-form-7" class="form-label">Email<small class="text-danger">*</small></label>
                                        <input type="email" id="email" name="email" class="form-control" value="<?php echo $this->session->userdata('email') ?>" autocomplete="off" readonly>
                                    </div>

                                    <div class="mb-5">
                                        <label for="post-form-7" class="form-label">Nomor Handphone <small class="text-danger">*</small></label>
                                        <input 
                                            type="text" 
                                            id="mobile_phone" 
                                            name="mobile_phone" 
                                            class="form-control" 
                                            placeholder="Nomor handphone" 
                                            autocomplete="off" 
                                            required 
                                            inputmode="numeric" 
                                            oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                                    </div>
                                </div>
                            </div>
                            <div class="border border-slate-200/60 dark:border-darkmode-400 rounded-md p-5 mt-5">
                                <div class="font-medium flex items-center border-b border-slate-200/60 dark:border-darkmode-400 pb-5"> <i data-lucide="chevron-down" class="w-4 h-4 mr-2"></i> Informasi Alamat Tujuan Pengiriman </div>
                                <div class="mt-5">
                                    <div class="mb-5 form-group">
                                        <label for="post-form-7" class="form-label">Provinsi <small class="text-danger">*</small></label>
                                        <select name="provinsi" id="provinsi" class="form-control" required>
                                            <option value="">-- Pilih Provinsi --</option>
                                        </select>
                                        <div id="spinner-provinsi" class="spinner-container">
                                            <div class="spinner"></div>
                                        </div>
                                    </div>

                                    <div class="mb-5 form-group">
                                        <label for="post-form-7" class="form-label">Kota <small class="text-danger">*</small></label>
                                        <select name="kota" id="kota" class="form-control" required>
                                            <option value="">-- Pilih Kota --</option>
                                        </select>
                                        <div id="spinner-city" class="spinner-container" style="display: none;">
                                            <div class="spinner"></div>
                                        </div>
                                    </div>

                                    <div class="mb-5">
                                        <label for="post-form-7" class="form-label">Kode Pos <small class="text-danger">*</small></label>
                                        <input type="text" class="form-control" id="kode_pos" name="kode_pos" placeholder="Kode Pos" autocomplete="off" required>
                                    </div>

                                    <div class="mb-5 form-group">
                                        <label for="post-form-7" class="form-label">Alamat Lengkap Kamu <small class="text-danger">*</small></label>
                                        <textarea name="alamat" id="alamat" class="form-control" placeholder="Silahkan tulis alamat lengkapmu disini" autocomplete="off" required></textarea>
                                    </div>

                                    <div class="mb-5 form-group">
                                        <label for="post-form-7" class="form-label">Pengiriman <small class="text-danger">*</small></label>
                                        <select name="ekspedisi" id="ekspedisi" class="form-control" required>
                                            <option value="">-- Pilih Jasa Pengiriman --</option>
                                        </select>
                                        <div id="spinner-expedisi" class="spinner-container" style="display: none;">
                                            <div class="spinner"></div>
                                        </div>
                                    </div>

                                    <div class="mb-5 form-group">
                                        <label for="post-form-7" class="form-label">Layanan Ongkos Kirim <small class="text-danger">*</small></label>
                                        <select name="service" id="service" class="form-control mt-2" required>
                                            <option value="">-- Pilih Layanan Ongkos Kirim --</option>
                                        </select>
                                        <div id="spinner-ongkir" class="spinner-container" style="display: none;">
                                            <div class="spinner"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex mt-5">
                                <a href="<?= site_url('dashboard/detail_cart') ?>" class="btn w-32 border-slate-300 dark:border-darkmode-400 text-slate-500">Keranjang</a>
                                <button type="submit" class="btn btn-primary w-32 shadow-md ml-auto">Bayar Sekarang</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- END: Post Content -->
        <!-- BEGIN: Post Info -->
        <div class="col-span-12 lg:col-span-4">
            <div class="intro-y pr-1">
                <div class="alert alert-primary show mb-2" role="alert">Informasi Pembayaran</div>
            </div>
            <div id="ticket" class="tab-pane active" role="tabpanel" aria-labelledby="ticket-tab">
                <div class="box p-2 mt-5">
                    <a href="javascript:;" data-tw-toggle="modal" data-tw-target="#add-item-modal" class="flex items-center p-3 cursor-pointer transition duration-300 ease-in-out bg-white dark:bg-darkmode-600 hover:bg-slate-100 dark:hover:bg-darkmode-400 rounded-md">
                        <div class="max-w-[50%] truncate mr-1">
                            <img class="mt-2" src="<?= site_url('asset') ?>/bca.png" width="60">
                        </div>
                        <div class="text-slate-500"></div>
                        <div class="ml-auto font-medium">6750527090 / KING VAPEZONE</div>
                    </a>
                    <a href="javascript:;" data-tw-toggle="modal" data-tw-target="#add-item-modal" class="flex items-center p-3 cursor-pointer transition duration-300 ease-in-out bg-white dark:bg-darkmode-600 hover:bg-slate-100 dark:hover:bg-darkmode-400 rounded-md">
                        <div class="max-w-[50%] truncate mr-1">
                            <img class="mt-2" src="<?= site_url('asset') ?>/mandiri.png" width="80">
                        </div>
                        <div class="text-slate-500"></div>
                        <div class="ml-auto font-medium">1918009817 / KING VAPEZONE</div>
                    </a>
                    <a href="javascript:;" data-tw-toggle="modal" data-tw-target="#add-item-modal" class="flex items-center p-3 cursor-pointer transition duration-300 ease-in-out bg-white dark:bg-darkmode-600 hover:bg-slate-100 dark:hover:bg-darkmode-400 rounded-md">
                        <div class="max-w-[50%] truncate mr-1">
                            <img class="mt-2" src="<?= site_url('asset') ?>/bni.png" width="60">
                        </div>
                        <div class="text-slate-500"></div>
                        <div class="ml-auto font-medium">6721598021 / KING VAPEZONE</div>
                    </a>
                    <a href="javascript:;" data-tw-toggle="modal" data-tw-target="#add-item-modal" class="flex items-center p-3 cursor-pointer transition duration-300 ease-in-out bg-white dark:bg-darkmode-600 hover:bg-slate-100 dark:hover:bg-darkmode-400 rounded-md">
                        <div class="max-w-[50%] truncate mr-1">
                            <img class="mt-2" src="<?= site_url('asset') ?>/bri.png" width="50">
                        </div>
                        <div class="text-slate-500"></div>
                        <div class="ml-auto font-medium">6750527090 / KING VAPEZONE</div>
                    </a>
                    <a href="javascript:;" data-tw-toggle="modal" data-tw-target="#add-item-modal" class="flex items-center p-3 cursor-pointer transition duration-300 ease-in-out bg-white dark:bg-darkmode-600 hover:bg-slate-100 dark:hover:bg-darkmode-400 rounded-md">
                        <div class="max-w-[50%] truncate mr-1">
                            <img class="mt-2" src="<?= site_url('asset') ?>/btpn.png" width="50">
                        </div>
                        <div class="text-slate-500"></div>
                        <div class="ml-auto font-medium">6750527090 / KING VAPEZONE</div>
                    </a>
                </div>

                <div class="box p-5 mt-5">
                    <div class="flex">
                        <div class="mr-auto">Subtotal</div>
                        <div class="font-medium" id="subtotal">Rp. 0</div>
                    </div>
                    <div class="flex mt-4">
                        <div class="mr-auto">Ongkos Kirim</div>
                        <div class="font-medium" id="ongkir">Rp. 0</div>
                    </div>
                    <div class="flex mt-4 pt-4 border-t border-slate-200/60 dark:border-darkmode-400">
                        <div class="mr-auto font-medium text-base">Total Pembayaran</div>
                        <div class="font-medium text-base"><strong id="total-bayar">Rp. 0</strong></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END: Post Info -->
    </div>
</div>

<script type="text/javascript">
    function formatRupiah(amount) {
        return amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    function getProvinsi(callback) {
        $.ajax({
            type: "POST",
            url: "<?= base_url('rajaongkir/provinsi') ?>",
            beforeSend: () => {
                $("#spinner-provinsi").fadeIn(); // Tampilkan spinner sebelum data dimuat
            },
            complete: () => {
                $("#spinner-provinsi").fadeOut(); // Sembunyikan spinner setelah selesai
            },
            success: (hasil_provinsi) => {
                if (hasil_provinsi) {
                    $("select[name=provinsi]").html(hasil_provinsi); // Isi dropdown dengan data provinsi
                    if (callback) callback(); // Panggil callback jika ada
                } else {
                    console.error("Data provinsi kosong atau tidak valid.");
                }
            },
            error: (xhr, status, error) => {
                console.error("Gagal memuat data provinsi:", error);
                alert("Terjadi kesalahan saat memuat data provinsi. Silakan coba lagi.");
            },
        });
    }

    function getCity(provinsi_id, callback) {
        if (!provinsi_id) {
            console.error("Provinsi ID tidak valid.");
            return;
        }

        $.ajax({
            type: "POST",
            url: "<?= base_url('rajaongkir/kota') ?>",
            data: { id_provinsi: provinsi_id },
            beforeSend: () => {
                $("#spinner-city").fadeIn(); // Tampilkan spinner sebelum data dimuat
            },
            success: (hasil_kota) => {
                if (hasil_kota) {
                    $("select[name=kota]").html(hasil_kota); // Isi dropdown dengan data kota
                    if (callback) callback(); // Panggil callback jika ada
                } else {
                    console.error("Data kota kosong atau tidak valid.");
                }
            },
            complete: () => {
                $("#spinner-city").fadeOut(); // Sembunyikan spinner setelah selesai
            },
            error: (xhr, status, error) => {
                console.error("Gagal memuat data kota:", error);
                alert("Terjadi kesalahan saat memuat data kota. Silakan coba lagi.");
            },
        });
    }

    function getExpedisi() {
        $.ajax({
            type: "POST",
            url: "<?= base_url('rajaongkir/ekspedisi') ?>",
            success: function(hasil_ekspedisi) {
                $("select[name=ekspedisi]").html(hasil_ekspedisi);
            },
            beforeSend: () => {
                $("#spinner-expedisi").fadeIn();
            },
            complete: () => {
                $("#spinner-expedisi").fadeOut();
            },
        });
    }

    function getOngkir() {
        const origin = 211;
        $.ajax({
            url: '<?= site_url('rajaongkir/ongkir') ?>',
            type: 'POST',
            data: {
                origin,
                destination: $('#kota').val(),
                weight: 500,
                courier: $('#ekspedisi').val()
            },
            success: function(data) {
                console.log('Response Data:', JSON.parse(data));
                const ongkirs = JSON.parse(data);
                let options = '<option hidden>-- Pilih Layanan Ongkos Kirim --</option>';
                if (Array.isArray(ongkirs) && ongkirs.length > 0) {
                    ongkirs.forEach(service => {
                        options += `<option ongkir="${service.cost[0].value}" value="${service.service}">${service.description} - IDR ${service.cost[0].value.toLocaleString('id-ID')} (ETD: ${service.cost[0].etd} hari)</option>`;
                    });
                } else {
                    options = '<option hidden>-- Tidak Ada Layanan Tersedia --</option>';
                }
                $("#service").html(options);
            },
            beforeSend: () => {
                $("#spinner-ongkir").fadeIn();
            },
            complete: () => {
                $("#spinner-ongkir").fadeOut();
            },
        });
    }

    function getCarts(ongkir = 0) {
        $.ajax({
            url: '<?= site_url("CartController/getCarts") ?>',
            type: 'GET',
            success: function(response) {
                const { status, totalPrice, cartItems } = JSON.parse(response);

                $('#subtotal').html(`Rp. ${formatRupiah(totalPrice)}`);
                $('#total-bayar-title').html(`Rp. ${formatRupiah(parseInt(totalPrice) + parseInt(ongkir))}`);
                $('#total-bayar').html(`Rp. ${formatRupiah(parseInt(totalPrice) + parseInt(ongkir))}`);

                $('#form-ongkir').val(parseInt(ongkir));
                $('#form-subtotal').val(parseInt(totalPrice));
                $('#form-total').val(parseInt(totalPrice) + parseInt(ongkir));
            },
        });
    }

    $(document).ready(function() {
        getCarts();
        getProvinsi(() => {
            <?php if ($address): ?>
                const prov_default = '<?= htmlspecialchars($address->province_id, ENT_QUOTES, 'UTF-8') ?>';
                const city_default = '<?= htmlspecialchars($address->city_id, ENT_QUOTES, 'UTF-8') ?>';
                const post_code_default = '<?= htmlspecialchars($address->post_code, ENT_QUOTES, 'UTF-8') ?>';
                const address_default = '<?= htmlspecialchars($address->address, ENT_QUOTES, 'UTF-8') ?>';

                $("select[name=provinsi]").val(prov_default);
                $("input[name=kode_pos]").val(post_code_default);
                $("textarea[name=alamat]").val(address_default);
                getCity(prov_default, () => {
                    $("select[name=kota]").val(city_default).trigger('change');
                });
            <?php else: ?>
                getCity($("select[name=provinsi]").val());
            <?php endif; ?>
        });

        $("select[name=provinsi]").on("change", function() {
            const provinsi_id = $("option:selected", this).attr("id_provinsi");
            getCity(provinsi_id);
        });

        $("select[name=kota]").on("change", function() {
            getExpedisi();
        });

        $("select[name=ekspedisi]").on("change", function() {
            getOngkir();
        });

        $("select[name=service]").on("change", function() {
            const ongkir = $("option:selected", this).attr("ongkir");
            $('#ongkir').html(`Rp. ${formatRupiah(ongkir)}`);
            getCarts(ongkir);
        });

        $('#pay-button').click(function(event) {
            event.preventDefault();
            $(this).attr("disabled", "disabled");

            const nama = $("#nama").val();
            const email = $("#email").val();
            const no_hp = $("#no_hp").val();
            const provinsi = $("#provinsi").val();
            const kota = $("#kota").val();
            const id_user = $("#id_user").val();
            const alamat = $("#alamat").val();
            const ekspedisi = $("#ekspedisi").val();
            const kode_pos = $("#kode_pos").val();
            const total = $("#total").val();

            $.ajax({
                type: 'POST',
                url: '<?= site_url() ?>/snap/token',
                data: {
                    nama,
                    email,
                    no_hp,
                    provinsi,
                    kota,
                    alamat,
                    ekspedisi,
                    kode_pos,
                    id_user,
                    total,
                },
                cache: false,
                success: function(data) {
                    const resultType = document.getElementById('result-type');
                    const resultData = document.getElementById('result-data');

                    function changeResult(type, data) {
                        $("#result-type").val(type);
                        $("#result-data").val(JSON.stringify(data));
                    }

                    snap.pay(data, {
                        onSuccess: function(result) {
                            changeResult('success', result);
                            $("#payment-form").submit();
                        },
                        onPending: function(result) {
                            changeResult('pending', result);
                            $("#payment-form").submit();
                        },
                        onError: function(result) {
                            changeResult('error', result);
                            $("#payment-form").submit();
                        },
                    });
                }
            });
        });
    });
 </script>