<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <title><?php echo $head_title; ?></title>
      <style type="text/css">
         .form-signin
         {
         max-width: 330px;
         padding: 15px;
         margin: 0 auto;
         padding-top: 5px;
         }
         .form-signin .form-signin-heading, .form-signin .checkbox
         {
         margin-bottom: 10px;
         }
         .form-signin .checkbox
         {
         font-weight: normal;
         }
         .form-signin .form-control
         {
         position: relative;
         font-size: 16px;
         height: auto;
         padding: 10px;
         -webkit-box-sizing: border-box;
         -moz-box-sizing: border-box;
         box-sizing: border-box;
         }
         .form-signin .form-control:focus
         {
         z-index: 2;
         }
         .form-signin input[type="password"]
         {
         margin-bottom: 10px;
         }
         .account-wall
         {
         margin-top: 20px;
         padding: 40px 0px 20px 0px;
         background-color: #f7f7f7;
         -moz-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
         -webkit-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
         box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
         }
         .login-title
         {
         color: #555;
         font-size: 18px;
         font-weight: 400;
         display: block;
         }
         .profile-img
         {
         width: 96px;
         height: 96px;
         margin: 0 auto 10px;
         display: block;
         -moz-border-radius: 50%;
         -webkit-border-radius: 50%;
         border-radius: 50%;
         }
         .profile-name {
         font-size: 16px;
         font-weight: bold;
         text-align: center;
         margin: 10px 0 0;
         height: 1em;
         }
         .profile-email {
         display: block;
         padding: 0 8px;
         font-size: 15px;
         color: #404040;
         line-height: 2;
         font-size: 14px;
         text-align: center;
         overflow: hidden;
         text-overflow: ellipsis;
         white-space: nowrap;
         -moz-box-sizing: border-box;
         -webkit-box-sizing: border-box;
         box-sizing: border-box;
         }
         .need-help
         {
         display: block;
         margin-top: 10px;
         }
         .new-account
         {
         display: block;
         margin-top: 10px;
         }
      </style>
      <link rel="stylesheet" href="<?php echo $path_gmail; ?>css/bootstrap.min.css">
      <link rel="stylesheet" href="<?php echo $path_sweetalert2; ?>dist/sweetalert2.css">
      <link rel="stylesheet" type="text/css" href="<?php echo $path_craftpip; ?>dist/jquery-confirm.min.css" />
   </head>
   <body>
      <div class="container">
         <div class="row">
            <div class="col-sm-6 col-md-4 col-md-offset-4">
               <div class="account-wall">
                  <img class="profile-img" src="<?php echo $path_gmail; ?>img/photo.png">
                  <form id="form_login" class="form-signin" method="post" action="<?php echo $link_authenticate_user; ?>">
                     <div class="form-group">
                        <input type="text" class="form-control" name="username" placeholder="Username" required/>
                     </div>
                     <div class="form-group">
                        <input type="password" class="form-control" name="password" placeholder="Password" required/>
                     </div>
                     <br/>
                     <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
                  </form>
               </div>
               <div id="div_progress_bar" class="progress progress-striped active" style="display:none">
                  <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
               </div>
            </div>
         </div>
      </div>
      <script src="<?php echo $path_gmail; ?>js/jquery-1.9.1.min.js"></script>
      <script src="<?php echo $path_sweetalert2; ?>dist/sweetalert2.min.js"></script>
      <script type="text/javascript" src="<?php echo $path_craftpip; ?>dist/jquery-confirm.min.js"></script>
      <script src="<?php echo $path_app; ?>js/auth.js"></script>
   </body>
</html>