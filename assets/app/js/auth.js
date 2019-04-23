(function($) {

  // fungsi dijalankan setelah seluruh dokumen ditampilkan
  $(document).ready(function() {

    $("#form_login").submit(function(e) {

      e.preventDefault();

      //do ajax proses

      $.ajax({

        type: "post", //form method
        url: $("#form_login").attr('action'),
        data: $("#form_login").serialize(),
        cache: false,
        dataType: "json",
        beforeSend: function() {

          $("#div_progress_bar").show();

        },
        success: function(result) {

          if (result.status) {

            $("#div_progress_bar").hide();
            swal("Success", result.message, "success");

            setTimeout(function() {
              window.location.href = result.url;
            }, 500);

          } else {

            // loading bar hide
            $("#div_progress_bar").hide();

            // loading bar hide
            $.alert({
              theme: 'supervan',
              title: 'Information!',
              content: result.message
            });
          }

        },
        error: function(xhr, Status, err) {

          // loading bar hide
          $("#div_progress_bar").hide();
          swal("Failed", Status, "error");
          console.log(Status);
        }

      });

      return false;

    })

  });

})(jQuery);