<style>
  @media (max-width: 768px) {
    .sidebar-hide {
        display: none;
    }
}
</style>

<div id="sidebar-wrapper" data-simplebar="" data-simplebar-auto-hide="true">
 <div class="brand-logo">
   <a href="home">
     <img src="views/img/JGC LOGO.png" class="logo-icon" alt="logo icon">
   </a>
 </div>

 <ul class="sidebar-menu">   
  <li class="sidebar-header">GENERAL INFO</li>
  <!-- 
  <li>
        <a href="javaScript:void();" class="waves-effect">
          <i class="fa fa-ban"></i> <span>Blacklisted</span><i class="fa fa-angle-left pull-right"></i>
        </a>
		<ul class="sidebar-submenu">
		  <li><a href="blacklist"><i class="zmdi zmdi-dot-circle-alt"></i>Accounts</a></li>
		</ul>
      </li> -->
      <?php if($_SESSION['type']=="admin" || $_SESSION['type']=="login_admin" || $_SESSION['type']=="login_user" ) {?> 
      <li>
        <a href="adminrequest" class="waves-effect">
          <i class="fa fa-paper-plane "></i> <span>Admin Request</span></i>
        </a>
      </li>
      <?php }?>

      <?php if($_SESSION['type']=="admin" ||  $_SESSION['type']=="hr_admin" ||  $_SESSION['type']=="hr_user") {?>
      <li>
        <a href="javaScript:void();" class="waves-effect">
          <i class="zmdi zmdi-collection-plus"></i> <span>Employees Data</span><i class="fa fa-angle-left pull-right"></i>
        </a>
		<ul class="sidebar-submenu">
		  <li><a href="clients"><i class="zmdi zmdi-dot-circle-alt"></i>EMB</a></li>
		</ul>
    <ul class="sidebar-submenu">
		  <li><a href="fch"><i class="zmdi zmdi-dot-circle-alt"></i>FCH</a></li>
		</ul>
    <ul class="sidebar-submenu">
		  <li><a href="pspmi"><i class="zmdi zmdi-dot-circle-alt"></i>PSPMI</a></li>
		</ul>
    <ul class="sidebar-submenu">
		  <li><a href="rlc"><i class="zmdi zmdi-dot-circle-alt"></i>RLC</a></li>
		</ul>
      </li>
      <?php }?>
      <?php if(
        $_SESSION['type']=="admin" || $_SESSION['type']=="wp_admin" || $_SESSION['type']=="wp_user" 
        || $_SESSION['type']=="backup" 
        || $_SESSION['type']=="wp_approve" 
        || $_SESSION['type']=="wp_accounting"
        || $_SESSION['type']=="wp_operation"  
        || $_SESSION['type']=="wp_mis"
        || $_SESSION['type']=="wp_financial"
        || $_SESSION['type']=="wp_audit"
        || $_SESSION['type']=="wp_credit"
        || $_SESSION['type']=="wp_hrom"
        || $_SESSION['type']=="wp_grcd"
        || $_SESSION['type']=="wp_pspmi"
        || $_SESSION['type']=="wp_pspmi_admin"
         ) {?> 
      <li>
       
	
		  <li>
        <a href="workingpermit"  class="waves-effect">
          <i class="fa fa-file"></i><span> Working Permit </span>
        </a>
      </li>
		  <!-- <li>
        <a href="request"  class="waves-effect">
          <i class="fa fa-files-o"></i><span> Request</span>
        </a>
      </li> -->
      </li>
      <?php }?>
      <?php if($_SESSION['type']=="dp_admin") {?> 
      <li>
        <a href="javaScript:void();" class="waves-effect">
          <i class="zmdi zmdi-file"></i> <span>Request</span><i class="fa fa-angle-left pull-right"></i>
        </a>
		<ul class="sidebar-submenu">
		  <li><a href="workingpermit"><i class="zmdi zmdi-dot-circle-alt"></i>Working Permit</a></li>
		</ul>
      </li>
      <?php }?>
      <?php if($_SESSION['type']=="backup_user" || $_SESSION['type']=="backup_admin" ||  $_SESSION['type']=="admin"  ) {?> 
        <li class="sidebar-hide">
          <a href="backups"  class="waves-effect">
            <i class="fa fa-hdd-o"></i><span>Backup</span></i>
          </a>
        </li>
        <?php }?>
        <?php if($_SESSION['type']=="backup_user" || $_SESSION['type']=="backup_admin" ||  $_SESSION['type']=="admin" || $_SESSION['type']=="fullypaid_admin"  ) {?> 
        <li class="sidebar-hide">
          <a href="fullypaid"  class="waves-effect">
            <i class="fa fa-money"></i><span>Fully Paid</span></i>
          </a>
        </li>
        <?php }?>
        <!-- Ticket-->
      <?php if($_SESSION['type']=="backup_user" || $_SESSION['type']=="admin" || $_SESSION['type']=="operation_admin") {?> 
      <li class="sidebar-hide">
      <a href="ticket" class="waves-effect">
          <i class="fa fa-ticket"></i> <span>Ticket</span></i>
        </a>
      </li>
      <?php }?>
         <!-- Ticket -->
         
         <!--Operation-->
         
         <?php if($_SESSION['type']=="admin" ||  $_SESSION['type']=="backup_user" || $_SESSION['type']=="operation_admin") {?>
  <li class="sidebar-hide">
        <a href="javaScript:void();" class="waves-effect">
          <i class="fa fa-tasks"></i> <span>Operation Reports</span><i class="fa fa-angle-left pull-right"></i>
        </a>
        <?php if($_SESSION['type']=="admin" || $_SESSION['type']=="operation_admin") {?>
		<ul class="sidebar-submenu">
		  <li><a href="operations"><i class="zmdi zmdi-dot-circle-alt"></i>Gross In & Outgoing</a></li>
		</ul>
    <?php } ?>
    <ul class="sidebar-submenu">
		  <li><a href="operationlsor"><i class="zmdi zmdi-dot-circle-alt"></i>LSOR</a></li>
		</ul>
    <?php if($_SESSION['type']=="admin" || $_SESSION['type']=="operation_admin") {?>
    <ul class="sidebar-submenu">
		  <li><a href="operationreturnee"><i class="zmdi zmdi-dot-circle-alt"></i>Fully Paid & Returnee Rate</a></li>
		</ul>
   
    <ul class="sidebar-submenu">
		  <li><a href="operationloansaging"><i class="zmdi zmdi-dot-circle-alt"></i>Loans Receivable Aging</a></li>
		</ul>

    
    <ul class="sidebar-submenu">
		  <li><a href="adminPenStatistics"><i class="zmdi zmdi-dot-circle-alt"></i>Weekly Pensioner</a></li>
		</ul>
    <ul class="sidebar-submenu">
		  <li><a href="monthlyagentAdmin"><i class="zmdi zmdi-dot-circle-alt"></i>Monthly Agents</a></li>
		</ul>
    <ul class="sidebar-submenu">
		  <li><a href="operationSP"><i class="zmdi zmdi-dot-circle-alt"></i>Sales Performance</a></li>
		</ul>
		 <ul class="sidebar-submenu">
		  <li><a href="operationAPH"><i class="zmdi zmdi-dot-circle-alt"></i>Availments/Hour</a></li>
		</ul>
		 <ul class="sidebar-submenu">
		  <li><a href="operationACOME"><i class="zmdi zmdi-dot-circle-alt"></i>Availments/Cutoff&End</a></li>
		</ul>



    <?php }elseif($_SESSION['type']=="backup_user"){ ?>

    <ul class="sidebar-submenu">
		  <li><a href="monthlyagent"><i class="zmdi zmdi-dot-circle-alt"></i>Monthly Agents</a></li>
		</ul>
    <ul class="sidebar-submenu">
		  <li><a href="branchPenStatistics"><i class="zmdi zmdi-dot-circle-alt"></i>Weekly Pensioner</a></li>
		</ul>
    <ul class="sidebar-submenu">
		  <li><a href="branchSP"><i class="zmdi zmdi-dot-circle-alt"></i>Sales Performance</a></li>
		</ul>
		 <ul class="sidebar-submenu">
		  <li><a href="branchAPH"><i class="zmdi zmdi-dot-circle-alt"></i>Availments</a></li>
		</ul>
      </li>
  <?php }} ?>
 <?php if($_SESSION['type']=="admin" || $_SESSION['type']=="backup_user" || $_SESSION['type']=="insurance_admin")  {?> 
        <li class="sidebar-hide">
            <a href="insurance" class="waves-effect">
              <i class="fa fa-medkit"></i> <span>Insurance</span></i>
            </a>
        </li>
        <?php }?>
        
              <!-- For Branch Upload DTR File -->
      <?php if( $_SESSION['type']=="backup_user") {?> 
        <!--  <li>-->
        <!--    <a href="branchDTRUpload" class="waves-effect">-->
        <!--      <i class="fa fa-upload"></i> <span>DTR Upload</span></i>-->
        <!--    </a>-->
        <!--</li>-->
      <?php }?>
          <!-- For HR Admin Upload DTR File -->
      <?php if($_SESSION['type']=="admin" ) {?> 
          <li>
            <a href="adminBackupDelete" class="waves-effect">
              <i class="fa fa-download"></i> <span>Manage Backup</span></i>
            </a>
        </li>
      <?php }?>
      
       <?php if($_SESSION['type']=="admin" || $_SESSION['type']=="backup_user" ) {?> 
          <li class="sidebar-hide">
            <a href="branchCollectionReceipt" class="waves-effect">
              <i class="fa fa-medkit"></i> <span>Receipt Printing</span></i>
            </a>
        </li>
      <?php }?>

         <!--End Operation-->
         <!-- Start Credit and Coll -->
         
             <?php if($_SESSION['type']=="backup_user") {?> 
      <li class="sidebar-hide">
        <a href="branchPDRColl" class="waves-effect">
          <i class="fa fa-credit-card "></i> <span>PDR Collection</span></i>
        </a>
      </li>
      <?php }?>
      
       <?php if($_SESSION['type']=="backup_user") {?> 
      <li class="sidebar-hide">
        <a href="branchSOA" class="waves-effect">
          <i class="fa fa-book "></i> <span>SOA</span></i>
        </a>
      </li>
      <?php }?>

      <?php if($_SESSION['type']=="admin") {?> 
      <li>
      <a href="accounts" class="waves-effect">
          <i class="fa fa-user-plus"></i> <span>Create Account</span></i>
        </a>
      </li>
      <li>
        <a href="dataBackup" class="waves-effect">
          <i class="fa fa-hdd-o"></i> <span>Data Backup</span></i>
        </a>
      </li>
      <?php }?>
       <?php if($_SESSION['type']=="admin") {?> 
      <li>
	 <a href="sqltodbf" class="waves-effect">
          <i class="fa fa-user-plus"></i> <span>SQL TO DBF</span></i>
        </a>
      </li>
      <?php }?>
      	<?php if($_SESSION['type']=="admin" || $_SESSION['type']=="pastdue_user" ) {?> 
      <li>
      <a href="pastdue" class="waves-effect">
          <i class="fa fa-money"></i> <span>Past Due</span></i>
        </a>
      </li>
      <?php }?>

      <?php if($_SESSION['type']=="admin" || $_SESSION['type']=="backup_user" || $_SESSION['type']=="inventory_mis" 
       || $_SESSION['type']=="inventory_audit"  || $_SESSION['type']=="inventory_user" || $_SESSION['type']=="inventory_admin" ) {?> 
          <li>
            <a href="inventory" class="waves-effect">
              <i class="fa fa-medkit"></i> <span>Inventory Module</span></i>
            </a>
        </li>
      <?php }?>

      <li>
      <a id="logout" class="waves-effect">
          <i class="fa fa-sign-out"></i> <span>Logout</span></i>
        </a>
      </li>
      
  </ul>
</div>

