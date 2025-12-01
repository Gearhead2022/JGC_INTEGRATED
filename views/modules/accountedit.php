<?php
$idClient = $_GET['idClient'];
$request = (new Connection)->connect()->query("SELECT * from accounts WHERE id = $idClient")->fetch(PDO::FETCH_ASSOC);

$full_name = $request['full_name'];
$username = $request['username'];
$newtype = $request['type'];
 
$is_confirmed = $request['is_confirmed'];
$access= "";

if($is_confirmed === 0){
 $acccess = "USER";
}else{
  $acccess = "ADMIN";
}
 
$type ="";
if($newtype=="admin"){
    $type = "Admin";
}elseif($newtype=="pdr_admin"){
    $type = "PDR-Admin";
}elseif($newtype=="pdr_user"){
    $type = "PDR-User";
}elseif($newtype=="hr_admin"){
    $type = "HR-Admin";
}elseif($newtype=="hr_user"){
    $type = "HR-User";
}elseif($newtype=="wp_admin"){
    $type = "WP-Admin";
}elseif($newtype=="wp_user"){
    $type = "WP-User";
}elseif($newtype=="wp_approve"){
  $type = "WP-Approval";
}elseif($newtype=="backup_user"){
  $type = "Backup-User";
}elseif($newtype=="pastdue_user"){
  $type = "PastDue-User";
}elseif($newtype=="backup_admin"){
$type = "Backup-Admin";
}elseif($newtype=="inventory_mis"){
  $type = "Inventory-MIS";
 }
elseif($newtype=="inventory_user"){
$type = "Inventory-User";
} 
elseif($newtype=="inventory_audit"){
  $type = "Inventory-Audit";
}   
elseif($newtype=="login_user"){
  $type = "Login-User";
}   
elseif($newtype=="login_admin"){
  $type = "Login-Admin";
}    







?> 
<div class="clearfix"></div>
  <div class="content-wrapper">
  <?php if($_SESSION['type'] == "admin"){?>
     <div class="container-fluid">
      <div class="row " >
        <div class="col-sm-12">
          <h4 class="page-title">USER REGISTRATION</h4>
        </div>
      </div>
    <div class="row">
      <div class="col-lg-12">
          <div class="card">
            <div class="card-body"> 
             <div class="row">
              <div class="container-fluid">
                <div class="col-lg-12">
                  <form role="form" method="POST" autocomplete="nope">
                    <div class="card">
                      <div class="card-body">
                      <div class="row">
                          <div class="col-sm-6 form-group">
                              <label for="input-3">Type Of User</label>
                              <select name="type" class="form-control"  id="" required> 
                              <option value="<?php echo $newtype; ?>"><?php echo $type; ?></option>
                                <option value="pdr_admin">PDR-Admin</option>
                                <option value="pdr_user">PDR-User</option>
                                <option value="hr_admin">HR-Admin</option>
                                <option value="hr_user">HR-User</option>
                                <option value="wp_admin">WP-Admin</option>
                                <option value="wp_user">WP-User</option>
                                <option value="wp_approve">WP-Approval</option>
                                <option value="backup_user">Backup-User</option>
                                <option value="backup_admin">Backup-Admin</option>
                                <option value="inventory_mis">Inventory-MIS</option>
                                <option value="inventory_user">Inventory-User</option>
                                <option value="inventory_audit">Inventory-Audit</option>
                                <option value="login_user">Login-User</option>
                                <option value="login_admin">Login-Admin</option>
                                <option value="admin">Admin</option>
                              </select>
                          </div>
                          </div>
                          <div class="row">
                                <div class="col-sm-6 form-group">
                                    <label for="input-3">Full Name</label>
                                    <input type="text" hidden class="form-control" id="input-3"  value="<?php echo $idClient;?>" name="id" autocomplete="nope">
                                    <input type="text" class="form-control" value="<?php echo $full_name; ?>" id="input-3" placeholder="Enter Full Name" name="full_name" autocomplete="nope">
                                </div>
                          </div>
                           <div class="row">
                                <div class="col-sm-6 form-group">
                                    <label for="input-3">Username</label>
                                    <input type="text" class="form-control" value="<?php echo $username; ?>" id="input-3" placeholder="Enter Username" name="username" autocomplete="nope">
                                </div>
                          </div>
                          <div class="row">
                                <div class="col-sm-6 form-group">
                                    <label for="input-4">Password</label> 
                                    <input type="password" class="form-control input-4" placeholder="Enter Password" name="password" type="password"  id="newPassword" required />
                                </div>
                          </div>
                          <div class="row">
                                 <div class="col-sm-6 form-group">
                                    <label for="input">Confirm Password</label>  
                                    <input type="password" class="form-control input-5" placeholder="Confirm Password" name="newConfirmPassword"  id="newConfirmPassword" required  />
                                    <span id="message"></span>
                                </div>
                          </div> 
                          <div class="row">
                                 <div class="col-sm-6 form-group">
                                    <label for="input">Login Access</label>  
                                    <select name="is_confirmed" class="form-control"  id="" required> 
                                         <option value="<?php echo $is_confirmed; ?>"><?php echo $acccess; ?></option>
                                        <option value="0">USER</option>
                                        <option value="1">ADMIN</option>
                                  </select>
                                </div>
                          </div>
                      </div>
                    </div>
                  </div>
                  <div class="card-footer">
                    <div class="row">
                      <div class="col-lg-3">
                      </div>
                      <div class="col-lg-9">
                        <div class="float-sm-right">
                         <button type="submit" id="start_button" name="editpass" disabled="disable" class="btn btn-light btn-round px-5"><i class="fa fa-save" ></i>&nbsp;&nbsp;Save</button>
                         <button type="button" class="btn btn-light btn-round px-5" onClick="location.href='accounts'" ><i class="fa fa-times"></i>&nbsp;&nbsp;Cancel</button> 
                        </div>
                      </div>
                    </div>
                  </div>  <!-- footer -->
              </div>    <!-- card -->
            </form>
            <?php 
              $createAccount = new ControllerAccounts();
              $createAccount -> ctrEditAccount();
             ?>
          </div>
        </div><!--End Row-->
          </div>
        </div>
      </div>
    </form>
  </div>
  <?php } ?>
</div>



  <!--   Core JS Files   -->

</body>

</html>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<script>



$('#newPassword, #newConfirmPassword').on('keyup', function () {
  if ($('#newPassword').val() == $('#newConfirmPassword').val()) {
    
    $('#message').html('Passsword Match').css('color', '#25e525');
    $('#start_button').prop('disabled', false);
   
  } else {
    $('#message').html('Passwords Does Not Match').css('color', '#e18b29');
    $('#start_button').prop('disabled', true);}
});


</script>