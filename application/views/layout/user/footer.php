<!-- BEGIN: JS Assets-->
<script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=[" your-google-map-api"]&libraries=places"></script>
<script src="<?= site_url('asset') ?>/admin/dist/js/app.js"></script>
<script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css" />
<script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://js.pusher.com/7.2/pusher.min.js"></script>

<script>
  $(document).ready( function () {
    $('.datatables').DataTable();
  });

  if (!userId || userId != '') {
    let currentFriendId = null; // Menyimpan ID teman yang sedang dipilih
    const userId = `<?= $user_id; ?>`; // Ambil ID pengguna dari server-side

    Pusher.logToConsole = false;

    var pusher = new Pusher('1195c945bd85e10d0c5b', {
      cluster: 'ap1'
    });

    var channel = pusher.subscribe(`chat-channel-${userId}`);
    channel.bind(`new-message`, function(data) {
      const messageText = data.message || '';

      $('#unread-msg-badge').show();
      if (data.sender_name) {
        toastr.info(data.message, `Message from ${data.sender_name}`, {
          positionClass: 'toast-top-right',
          timeOut: 5000,
        });
      }
    });
  }
</script>