(function($) {

  // fungsi dijalankan setelah seluruh dokumen ditampilkan
  $(document).ready(function() {

    var oTable = $('#dataTables-example').dataTable({
      "responsive": true,
      "processing": true,
      "serverSide": true,
      "ajax": {
        url: $("#link_list_lokasi").attr("href"), // json datasource                
        type: "post", // method  , by default get
      }
    });

    // click datatables
    $('#dataTables-example').on('click', 'tbody td a', function(e) {

      e.preventDefault();

      // id lokasi
      var id = $(this).attr('href');
      var link = $("#link_action_lokasi").attr("href");

      swal({
        title: 'Are you sure?',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Approved',
        cancelButtonText: 'Reject',
        confirmButtonClass: 'confirm-class',
        cancelButtonClass: 'cancel-class',
        closeOnConfirm: false,
        closeOnCancel: false
      },

      function(isConfirm) {
        if (isConfirm) {

          // approved
          approvedLokasi(id, link);

        } else {

          // reject 
          rejectLokasi(id, link);

        }
      });

      e.stopImmediatePropagation();

    });

    // approved content lokasi
    function approvedLokasi(id, link) {

      $.ajax({
        type: "POST",
        data: {
          id: id,
          action: 'approved'
        },
        cache: false,
        url: link,
        dataType: "json",
        success: function(result) {
          if (result.status) {

            swal("Success", result.message, "success");

            // use it instead of fnReloadAjax            
            oTable.api().ajax.reload();

          } else {

            // status false
            swal("Failed", result.message, "error");
          }

        }
      });

    }

    // reject content lokasi
    function rejectLokasi(id, link) {

      $.ajax({
        type: "POST",
        data: {
          id: id,
          action: 'reject'
        },
        cache: false,
        url: link,
        dataType: "json",
        success: function(result) {
          if (result.status) {

            swal("Success", result.message, "success");

            // use it instead of fnReloadAjax            
            oTable.api().ajax.reload();

          } else {

            // status false
            swal("Failed", result.message, "error");
          }

        }
      });

    }

  });

})(jQuery);