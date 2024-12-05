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
                    <table class="table table-striped" id="cart-table">
                        <thead>
                            <tr>
                                <th class="whitespace-nowrap">
                                    #
                                </th>
                                <th class="whitespace-nowrap !py-5">Produk</th>
                                <th class="whitespace-nowrap text-right">Harga</th>
                                <th class="whitespace-nowrap text-right">Jumlah</th>
                                <th class="whitespace-nowrap text-right">Total</th>
                            </tr>
                        </thead>
                        <tbody id="cart-items-body">
                            <!-- Daftar item keranjang akan dimuat di sini -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Transaction Details -->
</div>
<script>
function formatRupiah(amount) {
    return amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
}

function loadCartItems() {
    $.ajax({
        url: '<?= site_url("CartController/getCarts") ?>',
        method: "GET",
        success: function(response) {
            const { success, cartItems } = JSON.parse(response);
            var cartItemsHtml = '';
            let totalPrice = 0;

            // Loop melalui item keranjang dan buat HTML untuk tabel
            cartItems.forEach(function(item) {
                totalPrice += item.subtotal;
                cartItemsHtml += `
                    <tr>
                        <td>
                            <a onclick="deleteCart(${item.id})" class="btn btn-danger btn-sm">Hapus</a>
                        </td>
                        <td class="!py-4">
                            <div class="flex items-center">
                                <div class="w-10 h-10 image-fit zoom-in">
                                    <img class="rounded-lg border-2 border-white shadow-md tooltip" src="${item.image}">
                                </div>
                                <a href="" class="font-medium whitespace-nowrap ml-4">${item.name}</a>
                            </div>
                        </td>
                        <td class="text-right">Rp. ${formatRupiah(parseInt(item.price))}</td>
                        <td class="text-right">
                            <form class="update-quantity-form" data-item-id="${item.id}" data-original-quantity="${item.quantity}" method="POST">
                                <button type="button" class="btn btn-sm btn-danger decrease-quantity">-</button>
                                <input type="text" class="form-control d-inline-block text-center quantity-input" id="quantity-input-${item.id}" name="quantity" value="${item.quantity}" style="width: 60px;">
                                <button type="button" class="btn btn-sm btn-success increase-quantity">+</button>
                            </form>
                        </td>
                        <td class="text-right" id="subtotal-${item.id}">Rp. ${formatRupiah(parseInt(item.subtotal))}</td>
                    </tr>
                `;
            });

            cartItemsHtml += `
                <tr>
                    <td colspan="4"></td>
                    <td class="text-right"><strong id="total-price">Rp. ${formatRupiah(totalPrice)}</strong></td>
                </tr>
            `;

            // Menambahkan HTML item keranjang ke dalam tbody
            $('#cart-items-body').html(cartItemsHtml);
        },
        error: function() {
            alert("Terjadi kesalahan saat memuat keranjang.");
        }
    });
}

$(document).ready(function() {
    loadCartItems();
});

$(document).on("click", ".increase-quantity", function() {
    var $form = $(this).closest("form");
    var currentQuantity = parseInt($form.find(".quantity-input").val());
    var newQuantity = currentQuantity + 1;
    $form.find(".quantity-input").val(newQuantity);
    updateCartItemQuantity($form, newQuantity);
});

$(document).on("click", ".decrease-quantity", function() {
    var $form = $(this).closest("form");
    var currentQuantity = parseInt($form.find(".quantity-input").val());
    var newQuantity = currentQuantity - 1;

    if (newQuantity < 1) {
        return;
    }

    $form.find(".quantity-input").val(newQuantity);
    updateCartItemQuantity($form, newQuantity);
});

$(document).on("input", ".quantity-input", function () {
    var $form = $(this).closest("form");
    var newQuantity = parseInt($(this).val() || '0');
    updateCartItemQuantity($form, newQuantity);
});

function updateCartItemQuantity($form, newQuantity) {
    var itemId = $form.data("item-id");

    $.ajax({
        url: '<?= site_url('CartController/updateQuantity') ?>/' + itemId,
        method: "POST",
        data: {
            quantity: newQuantity,
        },
        success: function(response) {
            const { status, newSubtotal, newTotalPrice } = JSON.parse(response);
            if (status === 'success') {
                $(`#subtotal-${itemId}`).html("Rp. " + formatRupiah(newSubtotal));
                $("#total-price").text("Rp. " + formatRupiah(newTotalPrice));
            }
        },
        error: function() {
            alert("Terjadi kesalahan saat memperbarui keranjang.");
        }
    });
}

function deleteCart(itemId) {
    Swal.fire({
        title: "Apakah Anda yakin?",
        text: "Item ini akan dihapus dari keranjang!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: "Jangan, kembali!",
        confirmButtonText: "Ya, Hapus!"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '<?= site_url('CartController/deleteItem') ?>',
                type: 'POST',
                data: {
                    id: itemId,
                },
                success: function (response) {
                    const { status } = JSON.parse(response);
                    if (status === "success") {
                        Swal.fire({
                            title: "Berhasil!",
                            text: "Item telah dihapus dari keranjang.",
                            icon: "success",
                            confirmButtonColor: "#3085d6",
                        }).then(() => {
                            loadCartItems();
                        });
                    } else {
                        Swal.fire({
                            title: "Gagal!",
                            text: "Terjadi kesalahan saat menghapus item.",
                            icon: "error",
                            confirmButtonColor: "#3085d6",
                        });
                    }
                },
                error: function () {
                    Swal.fire({
                        title: "Oops!",
                        text: "Terjadi kesalahan. Silakan coba lagi.",
                        icon: "error",
                        confirmButtonColor: "#3085d6",
                    });
                }
            });
        }
    });
}


</script>