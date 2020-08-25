<div class="modal fade" id="modalKajianAuto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header modal-header-info">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="modalKajianLabel">Form Kajian</h4>
         </div>
         <form id="form_kajian_auto" role="form" method="post">
            <div class="modal-body">
               <div class="form-group">
                  <label>Itinerary Kajian List</label>
                  <textarea id="info_auto" name="info_auto" class="form-control" rows="10"></textarea>
               </div>
               <div id="div_progress_bar_auto" class="progress progress-striped active" style="display:none">
                  <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
               </div>
               <div id="notif_kajian_auto" class="alert alert-info" style="display:none"></div>
            </div>
            <div class="modal-footer">
               <button type="submit" class="btn btn-primary">Save</button>
               <button id="btnCloseModal_auto" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
         </form>
      </div>
   </div>
</div>