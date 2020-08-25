(function($) {

    // fungsi dijalankan setelah seluruh dokumen ditampilkan
    $(document).ready(function() {

        var oTable = $('#dataTables-example').dataTable({
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "ajax": {
                url: $("#link_lokasi_refresh").attr("href"), // json datasource                
                type: "post", // method  , by default get
            },
           "columns": [
                { "data": "place" },
                { "data": "address" },
                { "data": "latitude" },
                { "data": "longitude" },
                { "data": "Actions", "searchable":false, "orderable":false }
            ]
        });

        // click datatables
        $('#dataTables-example').on('click', 'tbody td a', function(e) {

            e.preventDefault();

            var attr_class = $(this).attr('class');
            var attr_href = $(this).attr('href');

            var place = $(this).closest('tr').find('td').eq(0).text();
            var address = $(this).closest('tr').find('td').eq(1).text();
            var latitude = $(this).closest('tr').find('td').eq(2).text();
            var longitude = $(this).closest('tr').find('td').eq(3).text();

            if (attr_class == 'edit') {

                // edit
                //var id = attr_href.charAt(attr_href.length - 1);
                var id = attr_href;

                // display div lokasi id
                $('#div_lokasi_id').show();

                $("#place").val(place);
                $("#address").val(address);
                $("#latitude").val(latitude);
                $("#longitude").val(longitude);
                $("#id").val(id);

                // display modal form edit lokasi
                var options = {
                    "backdrop": "static"
                }

                $('#modalLokasi').modal(options);

            } else {

                // delete data lokasi
                swal({
                    title: "Are you sure?",
                    text: "Menghapus data lokasi",
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

        // show modal form lokasi
        $('#btnCallModalLokasi').click(function() {

            clearFormLokasi();

            var options = {
                "backdrop": "static"
            }

            $('#modalLokasi').modal(options);
        });

        // close modal
        $('#btnCloseModal').click(function() {

            clearFormLokasi();
        });

        // function ajax for save lokasi
        $("#form_lokasi").submit(function(e) {

            e.preventDefault();

            var statusDivLokasiId = $('#div_lokasi_id').css('display');
            if (statusDivLokasiId == 'none') {

                // insert lokasi
                insertLokasi();

            } else {

                // update lokasi
                updateLokasi();

            }

            e.stopImmediatePropagation();
        });

        // insert lokasi
        function insertLokasi() {

            $.ajax({
                url: $("#link_lokasi_create").attr('href'),
                type: 'post',
                data: $("#form_lokasi").serialize(),
                cache: false,
                dataType: 'json',
                beforeSend: function() {

                    // disable button
                    $('#btnCloseModal').prop('disabled', true);

                    $("#div_progress_bar").show();
                },
                success: function(result) {

                    if (result.status) {

                        $("#div_progress_bar").hide();
                        $('#notif_lokasi').show();
                        $('#notif_lokasi').html(result.message);

                        $('#form_lokasi')[0].reset();

                        // use it instead of fnReloadAjax            
                        oTable.api().ajax.reload();

                    } else {

                        $("#div_progress_bar").hide();
                        $('#notif_lokasi').show();
                        $('#notif_lokasi').html(result.message);
                    }

                    // emable button
                    $('#btnCloseModal').prop('disabled', false);
                }
            });

        }

        // update lokasi
        function updateLokasi() {

            $.ajax({
                url: $("#link_lokasi_update").attr('href'),
                type: 'post',
                data: $("#form_lokasi").serialize(),
                cache: false,
                dataType: 'json',
                beforeSend: function() {

                    // disable button
                    $('#btnCloseModal').prop('disabled', true);

                    $("#div_progress_bar").show();
                },
                success: function(result) {

                    if (result.status) {

                        $("#div_progress_bar").hide();
                        $('#notif_lokasi').show();
                        $('#notif_lokasi').html(result.message);

                        // use it instead of fnReloadAjax            
                        oTable.api().ajax.reload();

                    } else {

                        $("#div_progress_bar").hide();
                        $('#notif_lokasi').show();
                        $('#notif_lokasi').html(result.message);
                    }

                    // emable button
                    $('#btnCloseModal').prop('disabled', false);

                }
            });

        }

        // clear form lokasi
        function clearFormLokasi() {

            $('#form_lokasi')[0].reset();
            $("#div_progress_bar").hide();
            $('#notif_lokasi').hide();
            $('#notif_lokasi').html();
            $('#div_lokasi_id').hide();
            $('#id').val();
        }

    });

})(jQuery);