<div class="modal fade info" id="modalUstadz" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header modal-header-info">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="modalUstadzLabel">Form Ustadz</h4>
         </div>
         <form id="form_ustadz" role="form" method="post">
            <div class="modal-body">
               <div class="form-group">
                  <label>Name</label>
                  <input id="name" name="name" class="form-control" required> 
               </div>
               <div class="form-group">
                  <label>Email</label>
                  <input id="email" name="email" class="form-control" placeholder="optional"> 
               </div>
               <div class="form-group">
                  <label>Phone</label>
                  <input id="phone" name="phone" class="form-control" placeholder="optional"> 
               </div>
               <div class="form-group">
                  <label>Address</label>
                  <textarea id="address" name="address" class="form-control" rows="3" placeholder="optional"></textarea>
               </div>
               <div id="div_ustadz_id" class="form-group" style="display:none">
                  <label>ID</label>
                  <input id="id" name="id" class="form-control" readonly> 
               </div>
               <div id="div_progress_bar" class="progress progress-striped active" style="display:none">
                  <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
               </div>
               <div id="notif_ustadz" class="alert alert-info" style="display:none"></div>
            </div>
            <div class="modal-footer">
               <button type="submit" class="btn btn-primary">Save</button>
               <button id="btnCloseModal" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
         </form>
      </div>
   </div>
</div>