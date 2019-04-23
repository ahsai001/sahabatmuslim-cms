<div class="modal fade" id="modalLokasi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header modal-header-info">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="modalLokasiLabel">Form Lokasi</h4>
         </div>
         <form id="form_lokasi" role="form" method="post">
            <div class="modal-body">
               <div class="form-group">
                  <label>Place</label>
                  <input id="place" name="place" class="form-control" required> 
               </div>
               <div class="form-group">
                  <label>Address</label>
                  <textarea id="address" name="address" class="form-control" rows="3" required></textarea>
               </div>
               <div class="form-group">
                  <label>Latitude</label>
                  <input id="latitude" name="latitude" class="form-control" required> 
               </div>
               <div class="form-group">
                  <label>Longitude</label>
                  <input id="longitude" name="longitude" class="form-control" required> 
               </div>
               <div id="div_lokasi_id" class="form-group" style="display:none">
                  <label>ID</label>
                  <input id="id" name="id" class="form-control" readonly> 
               </div>
               <div id="div_progress_bar" class="progress progress-striped active" style="display:none">
                  <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
               </div>
               <div id="notif_lokasi" class="alert alert-info" style="display:none"></div>
            </div>
            <div class="modal-footer">
               <button type="submit" class="btn btn-primary">Save</button>
               <button id="btnCloseModal" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
         </form>
      </div>
   </div>
</div>