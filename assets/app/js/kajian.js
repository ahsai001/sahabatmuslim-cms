(function($) {



  // fungsi dijalankan setelah seluruh dokumen ditampilkan

  $(document).ready(function() {



    var oTable = $('#dataTables-example').dataTable({

      "responsive": true,

      "processing": true,

      "serverSide": true,

      "ajax": {

        url: $("#link_kajian_refresh").attr("href"), // json datasource                

        type: "post", // method  , by default get

      },
       "columns": [
            { "data": "title" },
            { "data": "tanggal" },
            { "data": "starttime" },
            { "data": "endtime" },
            { "data": "startendtime" },
            { "data": "info" },
            { "data": "name" },
            { "data": "Actions" , "searchable":false , "orderable":false }
        ]

    });



    var oTable2 = $('#tableListUstadz').dataTable({

      "responsive": true,

      "processing": true,

      "serverSide": true,

      "ajax": {

        url: $("#link_list_ustadz").attr("href"), // json datasource                

        type: "post", // method  , by default get

      }

    });



    var oTable3 = $('#tableListLokasi').dataTable({

      "responsive": true,

      "processing": true,

      "serverSide": true,

      "ajax": {

        url: $("#link_list_lokasi").attr("href"), // json datasource                

        type: "post", // method  , by default get

      }

    });



    // show modal form kajian

    $('#btnCallModalKajian').click(function() {



      // clear form kajian



      var options = {

        "backdrop": "static"

      }



      $('#modalKajian').modal(options);

    });




// show modal form kajian auto

$('#btnCallModalKajianAuto').click(function() {



  // clear form kajian



  var options = {

    "backdrop": "static"

  }



  $('#modalKajianAuto').modal(options);

});




    // show modal list ustadz

    $('#btnSelectUstadz').click(function() {



      var options = {

        "backdrop": "static"

      }



      $('#modalUstadz').modal(options);

    });



    // select ustadz

    $("#tableListUstadz").delegate("tr", "click", function() {



      var idUstadz = $("td:eq(0)", this).text();

      $('#ustadz_id').val(idUstadz);

      $('#modalUstadz').modal('hide');

    });



    // show modal list lokasi

    $('#btnSelectLokasi').click(function() {



      var options = {

        "backdrop": "static"

      }



      $('#modalLokasi').modal(options);

    });



    // select lokasi

    $("#tableListLokasi").delegate("tr", "click", function() {



      var idLokasi = $("td:eq(0)", this).text();

      $('#lokasi_id').val(idLokasi);

      $('#modalLokasi').modal('hide');

    });



    // close modal

    $('#btnCloseModal').click(function() {



      clearFormKajian();

      $('#div_kajian_id').hide();

    });



    // close modal kajin detail

    $('#btnCloseModalKajianDetail').click(function() {



      $('#form_kajian_detail')[0].reset();

    });



    function clearFormKajian() {



      $('#form_kajian')[0].reset();

      $("#div_progress_bar").hide();

      $('#notif_kajian').hide();

      $('#notif_kajian').html();

    }



    // datepicker (tanggal)

    $('#tanggal').datepicker({

      format: 'yyyy-mm-dd',

      //startDate: new Date(),

      autoclose: true

    });



    // function ajax for save kajian



    $("#form_kajian").submit(function(e) {



      e.preventDefault();



      var statusDivKajianId = $('#div_kajian_id').css('display');



      if (statusDivKajianId == 'none') {



        // insert kajian

        insertKajian();



      } else {



        // update kajian

        updateKajian();



      }



      e.stopImmediatePropagation();



    });



    function insertKajian() {



      $.ajax({

        url: $("#link_kajian_create").attr('href'),

        type: 'post',

        data: $("#form_kajian").serialize(),

        cache: false,

        dataType: 'json',

        beforeSend: function() {



          // disable button

          $('#btnSelectUstadz').prop('disabled', true);

          $('#btnSelectLokasi').prop('disabled', true);

          $('#btnCloseModal').prop('disabled', true);



          // show progress bar

          $("#div_progress_bar").show();

        },

        success: function(result) {



          if (result.status) {



            $("#div_progress_bar").hide();

            $('#notif_kajian').show();

            $('#notif_kajian').html(result.message);

            $('#form_kajian')[0].reset();

            // use it instead of fnReloadAjax            

            oTable.api().ajax.reload();



          } else {



            $("#div_progress_bar").hide();

            $('#notif_kajian').show();

            $('#notif_kajian').html(result.message);

          }



          // enable button

          $('#btnSelectUstadz').prop('disabled', false);

          $('#btnSelectLokasi').prop('disabled', false);

          $('#btnCloseModal').prop('disabled', false);



        }

      });



    }



    function updateKajian() {



      $.ajax({

        url: $("#link_kajian_update").attr('href'),

        type: 'post',

        data: $("#form_kajian").serialize(),

        cache: false,

        dataType: 'json',

        beforeSend: function() {



          // disable button

          $('#btnSelectUstadz').prop('disabled', true);

          $('#btnSelectLokasi').prop('disabled', true);

          $('#btnCloseModal').prop('disabled', true);



          // show progress bar

          $("#div_progress_bar").show();

        },

        success: function(result) {



          if (result.status) {



            $("#div_progress_bar").hide();

            $('#notif_kajian').show();

            $('#notif_kajian').html(result.message);



            // use it instead of fnReloadAjax            

            oTable.api().ajax.reload();



          } else {



            $("#div_progress_bar").hide();

            $('#notif_kajian').show();

            $('#notif_kajian').html(result.message);

          }



          // enable button

          $('#btnSelectUstadz').prop('disabled', false);

          $('#btnSelectLokasi').prop('disabled', false);

          $('#btnCloseModal').prop('disabled', false);



        }

      });



    }






    $("#form_kajian_auto").submit(function(e) {
      e.preventDefault();
      //process hit ajax
      $.ajax({
        url: $("#link_kajian_create_auto").attr('href'),
        type: 'post',
        data: $("#form_kajian_auto").serialize(),
        cache: false,
        dataType: 'json',
        beforeSend: function() {
          $('#btnCloseModal_auto').prop('disabled', true);
          // show progress bar
          $("#div_progress_bar_auto").show();
        },
        success: function(result) {
          if (result.status) {
            $("#div_progress_bar_auto").hide();
            $('#notif_kajian_auto').show();
            $('#notif_kajian_auto').html(result.message);
            $('#form_kajian_auto')[0].reset();
            // use it instead of fnReloadAjax            
            oTable.api().ajax.reload();
          } else {
            $("#div_progress_bar_auto").hide();
            $('#notif_kajian_auto').show();
            $('#notif_kajian_auto').html(result.message);
          }
          $('#btnCloseModal_auto').prop('disabled', false);
        }
      });
      e.stopImmediatePropagation();
    });






    // click datatables

    $('#dataTables-example').on('click', 'tbody td a', function(e) {



      e.preventDefault();



      // display div kajian id

      $('#div_kajian_id').show();



      var attr_class = $(this).attr('class');

      var attr_href = $(this).attr('href');



      var title = $(this).closest('tr').find('td').eq(0).text();

      var tanggal = $(this).closest('tr').find('td').eq(1).text();

      var starttime = $(this).closest('tr').find('td').eq(2).text();

      var endtime = $(this).closest('tr').find('td').eq(3).text();

      var startendtime = $(this).closest('tr').find('td').eq(4).text();

       var info = $(this).closest('tr').find('td').eq(5).html();



      var sliceStartTime = starttime.slice(0, 5);

      var sliceEndTime = endtime.slice(0, 5);



      var spliterHref = attr_href.split("*/#");

      var kajianId = spliterHref[0];

      var ustadzId = spliterHref[1];

      var lokasiId = spliterHref[2];



      if (attr_class == 'edit') {



        $("#title").val(title);

        $("#tanggal").val(tanggal);

        $("#starttime").val(sliceStartTime);

        $("#endtime").val(sliceEndTime);

        $("#startendtime").val(startendtime);


         $("#info").val(info);


        $("#ustadz_id").val(ustadzId);

        $("#lokasi_id").val(lokasiId);

        $("#kajian_id").val(kajianId);



        // display modal form edit kajian

        var options = {

          "backdrop": "static"

        }



        $('#modalKajian').modal(options);



      } else if (attr_class == 'view') {



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

              $("#kajianTitle").val(title);

              $("#kajianTanggal").val(tanggal);

              $("#kajianStarttime").val(starttime);

              $("#kajianEndtime").val(endtime);

              $("#kajianStartEndtime").val(result.content.startendtime);

              $("#kajianInfo").val(info);


              $("#kajianPlace").val(result.content.place);

              $("#kajianAddress").val(result.content.address);

              $("#kajianLatitude").val(result.content.latitude);

              $("#kajianLongitude").val(result.content.longitude);

              $("#kajianUstadz").val(result.content.ustadz);
              $("#kajianUser").val(result.content.user);



            } else {



              // status false

              swal("Failed", result.message, "error");

            }



          }

        });



      } else {



        // delete data kajian

        swal({

          title: "Are you sure?",

          text: "Menghapus data kajian",

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



      }



    });



  });



})(jQuery);