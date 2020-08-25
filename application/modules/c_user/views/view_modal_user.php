<div class="modal fade" id="modalUser" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header modal-header-info">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="modalUserLabel">Form User</h4>
         </div>
         <form id="form_user" role="form" method="post">
            <div class="modal-body">
               <div class="form-group">
                  <label>Username</label>
                  <input id="username" name="username" class="form-control" required> 
               </div>
               <div class="form-group">
                  <label>Password</label>
                  <input id="password" name="password" type="password" class="form-control"> 
               </div>
               <div class="form-group">
                  <label>Level</label>
                  <select id="level" class="form-control" name="level">
                     <option value="admin">Admin</option>
                     <option value="editor">Editor</option>
                     <option value="guest editor">Guest Editor</option>
                  </select>
               </div>
               <div id="div_user_id" class="form-group" style="display:none">
                  <label>ID</label>
                  <input id="id" name="id" class="form-control" readonly> 
               </div>
               <div id="div_progress_bar" class="progress progress-striped active" style="display:none">
                  <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
               </div>
               <div id="notif_user" class="alert alert-info" style="display:none"></div>
            </div>
            <div class="modal-footer">
               <button type="submit" class="btn btn-primary">Save</button>
               <button id="btnCloseModal" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
         </form>
      </div>
   </div>
</div>