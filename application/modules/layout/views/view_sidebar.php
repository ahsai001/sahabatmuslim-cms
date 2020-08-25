<div class="navbar-default sidebar" role="navigation">
   <div class="sidebar-nav navbar-collapse">
      <ul class="nav" id="side-menu">
         <li>
            <a href="<?php echo $page_ustadz; ?>"><i class="fa fa-table fa-fw"></i> Ustadz</a>
         </li>
         <li>
            <a href="<?php echo $page_kajian; ?>"><i class="fa fa-table fa-fw"></i> Kajian</a>
         </li>
         <li>
            <a href="<?php echo $page_lokasi; ?>"><i class="fa fa-table fa-fw"></i> Lokasi</a>
         </li>
         <li>
            <a href="#"><i class="fa fa-edit fa-fw"></i> Admin<span class="fa arrow"></span></a>
            <ul class="nav nav-second-level">
               <li>
                  <a href="<?php echo $page_user; ?>">User</a>
               </li>
               <li>
                  <a href="#"> Content Need Approval<span class="fa arrow"></span></a>
                  <ul class="nav nav-third-level">
                     <li>
                        <a href="<?php echo $page_approval_ustadz; ?>">Ustadz</a>
                     </li>
                     <li>
                        <a href="<?php echo $page_approval_kajian; ?>">Kajian</a>
                     </li>
                     <li>
                        <a href="<?php echo $page_approval_lokasi; ?>">Lokasi</a>
                     </li>
                  </ul>
                  <!-- /.nav-third-level -->
               </li>
            </ul>
            <!-- /.nav-second-level -->
         </li>
      </ul>
   </div>
   <!-- /.sidebar-collapse -->
</div>