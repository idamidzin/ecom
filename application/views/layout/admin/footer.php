 <!-- BEGIN: JS Assets-->
 <script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"></script>
 <script src="https://maps.googleapis.com/maps/api/js?key=[" your-google-map-api"]&libraries=places"></script>
 <script src="<?= site_url('asset') ?>/admin/dist/js/app.js"></script>
 <!-- Resources -->

 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.js"></script>


 <!-- alert -->
 <?php if (@$_SESSION['sukses']) { ?>
     <script>
         swal("Good job!", "<?php echo $_SESSION['sukses']; ?>", "success");
     </script>
     <!-- jangan lupa untuk menambahkan unset agar sweet alert tidak muncul lagi saat di refresh -->
 <?php unset($_SESSION['sukses']);
    } ?>

 </body>

 </html>