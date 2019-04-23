(function($) {

  // fungsi dijalankan setelah seluruh dokumen ditampilkan
  $(document).ready(function() {

    var oTable = $('#dataTables-example').dataTable({
      "responsive": true,
      "processing": true,
      "serverSide": true,
      "ajax": {
        url: $("#link_user_refresh").attr("href"), // json datasource                
        type: "post", // method  , by default get
      }
    });

    // click datatables
    $('#dataTables-example').on('click', 'tbody td a', function(e) {

      e.preventDefault();

      var attr_class = $(this).attr('class');
      var attr_href = $(this).attr('href');

      var username = $(this).closest('tr').find('td').eq(0).text();
      var level = $(this).closest('tr').find('td').eq(1).text();

      if (attr_class == 'edit') {

        // edit
        //var id = attr_href.charAt(attr_href.length - 1);
        var id = attr_href;

        // display div user id
        $('#div_user_id').show();

        $("#username").val(username);
        $("#level").val(level);
        $("#id").val(id);

        // display modal form edit user
        var options = {
          "backdrop": "static"
        }

        $('#modalUser').modal(options);

      } else {

        swal({
          title: "Are you sure?",
          text: "Menghapus data user",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Yes, delete it!",
          closeOnConfirm: false
        },

        function() {

          $.ajax({
            type: "GET",
            url: attr_href,
            dataType: "json",
            success: function(result) {
              if (result.status) {

                swal("Deleted!", result.message, "success");
                // use it instead of fnReloadAjax            
                oTable.api().ajax.reload();

              } else {

                // status false
                swal("Failed", result.message, "error");
              }

            }
          });

        });
        e.stopImmediatePropagation();
      }
    });

    // show modal form user
    $('#btnCallModalUser').click(function() {

      clearFormUser();

      var options = {
        "backdrop": "static"
      }

      $('#modalUser').modal(options);
    });

    // close modal
    $('#btnCloseModal').click(function() {

      clearFormUser();
    });

    // clear form user
    function clearFormUser() {

      $('#form_user')[0].reset();
      $("#div_progress_bar").hide();
      $('#notif_user').hide();
      $('#notif_user').html();
      $('#div_user_id').hide();
      $('#id').val();
    }

    // function ajax for save user
    $("#form_user").submit(function(e) {

      e.preventDefault();

      var statusDivUserId = $('#div_user_id').css('display');
      if (statusDivUserId == 'none') {

        // insert user
        insertUser();

      } else {

        // update user
        updateUser();

      }
      e.stopImmediatePropagation();
    });

    // insert user
    function insertUser() {

      $.ajax({
        url: $("#link_user_create").attr('href'),
        type: 'post',
        data: $("#form_user").serialize(),
        cache: false,
        dataType: 'json',
        beforeSend: function() {

          $("#div_progress_bar").show();
        },
        success: function(result) {

          if (result.status) {

            $("#div_progress_bar").hide();
            $('#notif_user').show();
            $('#notif_user').html(result.message);
            $('#form_user')[0].reset();

            // use it instead of fnReloadAjax            
            oTable.api().ajax.reload();

          } else {

            $("#div_progress_bar").hide();
            $('#notif_user').show();
            $('#notif_user').html(result.message);
          }
        }
      });

    }

    // update user
    function updateUser() {

      $.ajax({
        url: $("#link_user_update").attr('href'),
        type: 'post',
        data: $("#form_user").serialize(),
        cache: false,
        dataType: 'json',
        beforeSend: function() {

          $("#div_progress_bar").show();
        },
        success: function(result) {

          if (result.status) {

            $("#div_progress_bar").hide();
            $('#notif_user').show();
            $('#notif_user').html(result.message);

            // use it instead of fnReloadAjax            
            oTable.api().ajax.reload();

          } else {

            $("#div_progress_bar").hide();
            $('#notif_user').show();
            $('#notif_user').html(result.message);
          }
        }
      });

    }

  });

})(jQuery);