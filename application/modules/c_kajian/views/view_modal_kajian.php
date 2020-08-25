<div class="modal fade" id="modalKajian" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header modal-header-info">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="modalKajianLabel">Form Kajian</h4>
         </div>
         <form id="form_kajian" role="form" method="post">
            <div class="modal-body">
               <div class="form-group">
                  <label>Title</label>
                  <input id="title" name="title" class="form-control" required> 
               </div>
               <div class="form-group date">
                  <label>Tanggal</label>
                  <div class="input-group">
                     <input id="tanggal" name="tanggal" class="form-control" required> 
                     <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                  </div>
               </div>
               <div class="form-group clockpicker">
                  <label>Start Time</label>
                  <div class="input-group">
                     <input id="starttime" name="starttime" class="form-control" required> 
                     <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
                  </div>
               </div>
               <div class="form-group">
                  <label>End Time</label>
                  <div class="input-group">
                     <input id="endtime" name="endtime" class="form-control" required> 
                     <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
                  </div>
               </div>

               <div class="form-group">
                  <label>Start End Time (Opsional)</label>
                  <div class="input-group">
                     <input id="startendtime" name="startendtime" class="form-control" placeholder="contoh : Ba'da dzuhur - selesai"> 
                     <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
                  </div>
               </div>

               <div class="form-group">
                  <label>Info</label>
                  <textarea id="info" name="info" class="form-control" rows="3"></textarea>
               </div>


               <div class="form-group">
                  <label>Ustadz ID</label>
                  <input id="ustadz_id" name="ustadz_id" class="form-control" readonly> 
               </div>
               <div class="form-group">
                  <label>Lokasi ID</label>
                  <input id="lokasi_id" name="lokasi_id" class="form-control" readonly> 
               </div>
               <div id="div_kajian_id" class="form-group" style="display:none">
                  <label>Kajian ID</label>
                  <input id="kajian_id" name="kajian_id" class="form-control" readonly> 
               </div>
               <div id="div_progress_bar" class="progress progress-striped active" style="display:none">
                  <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
               </div>
               <div id="notif_kajian" class="alert alert-info" style="display:none"></div>
            </div>
            <div class="modal-footer">
               <button type="submit" class="btn btn-primary">Save</button>
               <button id="btnSelectUstadz" type="button" class="btn btn-info">Select Ustadz</button>
               <button id="btnSelectLokasi" type="button" class="btn btn-warning">Select Lokasi</button>
               <button id="btnCloseModal" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
         </form>
      </div>
   </div>
</div>