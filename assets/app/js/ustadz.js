(function($) {

    // fungsi dijalankan setelah seluruh dokumen ditampilkan
    $(document).ready(function() {

        var oTable = $('#dataTables-example').dataTable({
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "ajax": {
                url: $("#link_ustadz_refresh").attr("href"), // json datasource                
                type: "post", // method  , by default get
            },
           "columns": [
                { "data": "name" },
                { "data": "email" },
                { "data": "phone" },
                { "data": "address" },
                { "data": "Actions" , "searchable":false , "orderable":false }
            ]
        });

        // click datatables
        $('#dataTables-example').on('click', 'tbody td a', function(e) {

            e.preventDefault();

            var attr_class = $(this).attr('class');
            var attr_href = $(this).attr('href');

            var name = $(this).closest('tr').find('td').eq(0).text();
            var email = $(this).closest('tr').find('td').eq(1).text();
            var phone = $(this).closest('tr').find('td').eq(2).text();
            var address = $(this).closest('tr').find('td').eq(3).text();

            if (attr_class == 'edit') {

                // edit
                //var id = attr_href.charAt(attr_href.length - 1);
                var id = attr_href;

                // display div ustadz id
                $('#div_ustadz_id').show();

                $("#name").val(name);
                $("#email").val(email);
                $("#phone").val(phone);
                $("#address").val(address);
                $("#id").val(id);

                // display modal form edit ustadz
                var options = {
                    "backdrop": "static"
                }

                $('#modalUstadz').modal(options);

            } else {

                // delete data ustadz
                swal({
                    title: "Are you sure?",
                    text: "Menghapus data ustadz",
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

        // show modal form ustadz
        $('#btnCallModalUstadz').click(function() {

            clearFormUstadz();

            var options = {
                "backdrop": "static"
            }

            $('#modalUstadz').modal(options);
        });

        // close modal
        $('#btnCloseModal').click(function() {

            clearFormUstadz();
        });

        // function ajax for save ustadz
        $("#form_ustadz").submit(function(e) {

            e.preventDefault();

            var statusDivUstadzId = $('#div_ustadz_id').css('display');
            if (statusDivUstadzId == 'none') {

                // insert ustadz
                insertUstadz();

            } else {

                // update ustadz
                updateUstadz();

            }
            e.stopImmediatePropagation();
        });

        // clear form ustadz
        function clearFormUstadz() {

            $('#form_ustadz')[0].reset();
            $("#div_progress_bar").hide();
            $('#notif_ustadz').hide();
            $('#notif_ustadz').html();
            $('#div_ustadz_id').hide();
            $('#id').val();
        }

        // insert ustadz
        function insertUstadz() {

            $.ajax({
                url: $("#link_ustadz_create").attr('href'),
                type: 'post',
                data: $("#form_ustadz").serialize(),
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
                        $('#notif_ustadz').show();
                        $('#notif_ustadz').html(result.message);

                        $('#form_ustadz')[0].reset();

                        // use it instead of fnReloadAjax            
                        oTable.api().ajax.reload();

                    } else {

                        $("#div_progress_bar").hide();
                        $('#notif_ustadz').show();
                        $('#notif_ustadz').html(result.message);
                    }

                    // emable button
                    $('#btnCloseModal').prop('disabled', false);

                }
            });

        }

        // update ustadz
        function updateUstadz() {

            $.ajax({
                url: $("#link_ustadz_update").attr('href'),
                type: 'post',
                data: $("#form_ustadz").serialize(),
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
                        $('#notif_ustadz').show();
                        $('#notif_ustadz').html(result.message);

                        // use it instead of fnReloadAjax            
                        oTable.api().ajax.reload();

                    } else {

                        $("#div_progress_bar").hide();
                        $('#notif_ustadz').show();
                        $('#notif_ustadz').html(result.message);
                    }

                    // emable button
                    $('#btnCloseModal').prop('disabled', false);

                }
            });

        }

    });

})(jQuery);