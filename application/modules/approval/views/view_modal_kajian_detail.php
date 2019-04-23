<div class="modal fade" id="modalDetailKajian" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header modal-header-info">
            <h4 class="modal-title" id="modalDetailKajianLabel">Detail Kajian</h4>
         </div>
         <div class="modal-body">
            <div id="div_progress_bar_kajian_detail" class="progress progress-striped active" style="display:none">
               <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
            </div>
            <form id="form_kajian_detail" role="form">
               <div class="form-group">
                  <label>Title</label>
                  <input id="kajianTitle" class="form-control"> 
               </div>
               <div class="form-group">
                  <label>Tanggal</label>
                  <input id="kajianTanggal" class="form-control"> 
               </div>
               <div class="form-group">
                  <label>Start Time</label>
                  <input id="kajianStarttime" class="form-control"> 
               </div>
               <div class="form-group">
                  <label>End Time</label>
                  <input id="kajianEndtime" class="form-control"> 
               </div>
               <div class="form-group">
                  <label>Place</label>
                  <input id="kajianPlace" class="form-control"> 
               </div>
               <div class="form-group">
                  <label>Address</label>
                  <textarea id="kajianAddress" class="form-control" rows="3" required></textarea>
               </div>
               <div class="form-group">
                  <label>Latitude</label>
                  <input id="kajianLatitude" class="form-control"> 
               </div>
               <div class="form-group">
                  <label>Longitude</label>
                  <input id="kajianLongitude" class="form-control"> 
               </div>
               <div class="form-group">
                  <label>Ustadz</label>
                  <input id="kajianUstadz" class="form-control"> 
               </div>
            </form>
         </div>
         <div class="modal-footer">
            <button id="btnCloseModalKajianDetail" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
         </div>
      </div>
   </div>
</div>