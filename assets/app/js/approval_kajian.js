(function($) {

  // fungsi dijalankan setelah seluruh dokumen ditampilkan
  $(document).ready(function() {

    var oTable = $('#dataTables-example').dataTable({
      "responsive": true,
      "processing": true,
      "serverSide": true,
      "ajax": {
        url: $("#link_list_kajian").attr("href"), // json datasource                
        type: "post", // method  , by default get
      }
    });

    // click datatables
    $('#dataTables-example').on('click', 'tbody td a', function(e) {

      e.preventDefault();

      var id = $(this).attr('href'); // id kajian
      var attr_class = $(this).attr('class'); // attribute class
      var attr_href = $(this).attr('href'); // attribute class
      var link = $("#link_action_kajian").attr("href");

      if (attr_class == 'view') {

        $.ajax({
          type: "GET",
          url: attr_href,
          dataType: "json",
          beforeSend: function() {

            // show progress bar
            $("#div_progress_bar_kajian_detail").show();

            // display modal form edit kajian
            var options = {
              "backdrop": "static"
            }

            $('#modalDetailKajian').modal(options);

          },
          success: function(result) {
            if (result.status) {

              // hide progress bar
              $("#div_progress_bar_kajian_detail").hide();

              // set content
              $("#kajianTitle").val(result.content.title);
              $("#kajianTanggal").val(result.content.tanggal);
              $("#kajianStarttime").val(result.content.starttime);
              $("#kajianEndtime").val(result.content.endtime);
              $("#kajianPlace").val(result.content.place);
              $("#kajianAddress").val(result.content.address);
              $("#kajianLatitude").val(result.content.latitude);
              $("#kajianLongitude").val(result.content.longitude);
              $("#kajianUstadz").val(result.content.ustadz);

            } else {

              // status false
              swal("Failed", result.message, "error");
            }

          }
        });

        e.stopImmediatePropagation();

      } else {

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
            approvedKajian(id, link);

          } else {

            // reject 
            rejectKajian(id, link);

          }
        });

        e.stopImmediatePropagation();

      }

    });

    // close modal kajin detail
    $('#btnCloseModalKajianDetail').click(function() {

      $('#form_kajian_detail')[0].reset();
    });

    // approved content kajian
    function approvedKajian(id, link) {

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

    // reject content kajian
    function rejectKajian(id, link) {

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