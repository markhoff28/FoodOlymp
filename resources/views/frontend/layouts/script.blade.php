{{-- ------------ Wishlist Add Start ----------- --}}
  <script type="text/javascript">
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    function addWishList(id) {
      //alert(id)
      $.ajax({
        type: "POST",
        dataType: "json",
        url: "/add-wish-list/" + id,
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(data) {
          // Start Message 
          const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',

            showConfirmButton: false,
            timer: 3000
          })
          if ($.isEmptyObject(data.error)) {

            Toast.fire({
              type: 'success',
              icon: 'success',
              title: data.success,
            })
          } else {

            Toast.fire({
              type: 'error',
              icon: 'error',
              title: data.error,
            })
          }
          // End Message  
        }
      })
    }
  </script>

{{-- /// End Wishlist Add Option // --}}