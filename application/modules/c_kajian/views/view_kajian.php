<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="description" content="">
      <meta name="author" content="">
      <title><?php echo $head_title; ?></title>
      <!-- Bootstrap Core CSS -->
      <link href="<?php echo $path_sbadmin2; ?>bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
      <!-- MetisMenu CSS -->
      <link href="<?php echo $path_sbadmin2; ?>bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">
      <!-- DataTables CSS -->
      <link href="<?php echo $path_sbadmin2; ?>bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet">
      <!-- DataTables Responsive CSS -->
      <link href="<?php echo $path_sbadmin2; ?>bower_components/datatables-responsive/css/dataTables.responsive.css" rel="stylesheet">
      <!-- Custom CSS -->
      <link href="<?php echo $path_sbadmin2; ?>dist/css/sb-admin-2.css" rel="stylesheet">
      <!-- Custom Fonts -->
      <link href="<?php echo $path_sbadmin2; ?>bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
      <!-- Sweet alert -->
      <link rel="stylesheet" href="<?php echo $path_sweetalert2; ?>dist/sweetalert2.css">
      <!-- Datepicker -->
      <link rel="stylesheet" href="<?php echo $path_datepicker; ?>css/bootstrap-datepicker3.min.css">
      <!-- Clock Picker -->
      <link rel="stylesheet" type="text/css" href="<?php echo $path_clockpicker; ?>dist/bootstrap-clockpicker.min.css">
      <link rel="stylesheet" type="text/css" href="<?php echo $path_clockpicker; ?>assets/css/github.min.css">
      <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
      <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
      <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
      <![endif]-->
      <style type="text/css">
         .modal-header {
         background-color: #5bc0de;
         }
         .modal-title {
         color: #FFF;
         display: inline-block;
         font-size: 18px;
         }
      </style>
   </head>
   <body>
      <div id="wrapper">
         <!-- Navigation -->
         <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <?php echo $header; ?>
            <!-- /.navbar-top-links -->
            <?php echo $sidebar; ?>
            <!-- /.navbar-static-side -->
         </nav>
         <!-- Page Content -->
         <div id="page-wrapper">
            <div class="row">
               <div class="col-lg-12">
                  <h1 class="page-header">Kajian</h1>
                  <a id="link_kajian_refresh" href="<?php echo $link_kajian_refresh; ?>"></a>
                  <a id="link_kajian_create" href="<?php echo $link_kajian_create; ?>"></a>
                  <a id="link_kajian_create_auto" href="<?php echo $link_kajian_create_auto; ?>"></a>
                  <a id="link_kajian_update" href="<?php echo $link_kajian_update; ?>"></a>
                  <a id="link_list_ustadz" href="<?php echo $link_list_ustadz; ?>"></a>
                  <a id="link_list_lokasi" href="<?php echo $link_list_lokasi; ?>"></a>
               </div>
               <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
               <div class="col-lg-12">
                  <div class="panel panel-primary">
                     <div class="panel-heading">
                        List Kajian
                     </div>
                     <!-- /.panel-heading -->
                     <div class="panel-body">
                        <div class="dataTable_wrapper">
                           <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                              <thead>
                                 <tr>
                                    <th>Title</th>
                                    <th>Tanggal</th>
                                    <th>Start time</th>
                                    <th>End time</th>
                                    <th>Start End time</th>
                                    <th>Info</th>
                                    <th>Ustadz</th>
                                    <th>Action</th>
                                 </tr>
                              </thead>
                           </table>
                        </div>
                        <!-- /.table-responsive -->
                     </div>
                     <!-- /.panel-body -->
                  </div>
                  <!-- /.panel -->
               </div>
               <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <button id='btnCallModalKajian' class="btn btn-primary">Add Kajian Manual</button><br/><br/>
            
            <button id='btnCallModalKajianAuto' class="btn btn-primary">Add Kajian Automatic</button><br/><br/>
            <!-- Modal Add Kajian -->
            <?php echo $view_modal_kajian; ?>
            <!-- Modal Add Kajian Auto -->
            <?php echo $view_modal_kajian_auto; ?>
            <!-- Modal Ustadz -->
            <?php echo $view_modal_ustadz; ?>
            <!-- Modal Lokasi -->
            <?php echo $view_modal_lokasi; ?>
            <!-- Modal Kajian Detail -->
            <?php echo $view_modal_kajian_detail; ?>
         </div>
         <!-- /#page-wrapper -->
      </div>
      <!-- /#wrapper -->
      <!-- jQuery Version 1.11.0 -->
      <script src="<?php echo $path_sbadmin2; ?>bower_components/jquery/dist/jquery.min.js"></script>
      <!-- Bootstrap Core JavaScript -->
      <script src="<?php echo $path_sbadmin2; ?>bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
      <!-- Metis Menu Plugin JavaScript -->
      <script src="<?php echo $path_sbadmin2; ?>bower_components/metisMenu/dist/metisMenu.min.js"></script>
      <!-- DataTables JavaScript -->
      <script src="<?php echo $path_sbadmin2; ?>bower_components/datatables/media/js/jquery.dataTables.min.js"></script>
      <script src="<?php echo $path_sbadmin2; ?>bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>
      <!-- Custom Theme JavaScript -->
      <script src="<?php echo $path_sbadmin2; ?>dist/js/sb-admin-2.js"></script>
      <!-- SweetAlert -->
      <script src="<?php echo $path_sweetalert2; ?>dist/sweetalert2.min.js"></script>
      <!-- Datepicker -->
      <script src="<?php echo $path_datepicker; ?>js/bootstrap-datepicker.min.js"></script>
      <!-- Clockpicker -->
      <script type="text/javascript" src="<?php echo $path_clockpicker; ?>dist/bootstrap-clockpicker.min.js"></script>
      <script type="text/javascript" src="<?php echo $path_clockpicker; ?>assets/js/highlight.min.js"></script>
      <!-- App -->
      <script src="<?php echo $path_app; ?>js/kajian.js?update=2018-10-17-rev3"></script>
      <script type="text/javascript">
         // clock piker
         var input = $('#starttime');
            input.clockpicker({
            autoclose: true
         });
         
         var input2 = $('#endtime');
            input2.clockpicker({
            autoclose: true
         });
      </script>
   </body>
</html>