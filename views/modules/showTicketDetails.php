
<?php 
$id = $_REQUEST['id'];
$branch_name = $_REQUEST['branch_name'];
$name = $_REQUEST['name'];
$terms = $_REQUEST['terms'];
$index_id = $_REQUEST['index_id'];
$area_code = $_REQUEST['area_code'];
$tdate = $_REQUEST['tdate'];
$Tickets = new ControllerTicket();
?>




<div class="clearfix"></div>
<div class="content-wrapper">
<div class="container-fluid">

<div class="row pt-2">
        <div class="col-sm-12">
          <h4 class="page-title">GENERATE TICKET</h4>
        </div>
     </div>



     <div class="row">
        <div class="col-12">

            <div class="card">
            <div class="card-header float-sm-right">


            <div class="row">

                <?php if($_SESSION['type'] =="backup_user"){?>

                    <button type="button" tdate="<?php echo $tdate ?>"  area_code="<?php echo $area_code ?>" index_id="<?php echo $index_id ?>" id="<?php echo $id ?>" branch_name="<?php echo $branch_name ?>" name="<?php echo $name ?>" terms="<?php echo $terms ?>" class="btn btn-light btn-round waves-effect waves-light m-1 btnPrintTicket"><i class="fa fa-print"></i> <span>&nbsp;PRINT</span> </button>
              <?php  }?>
              
              </div> 

              <div class="card-body" >
              <div class="table-responsive">
              <table id="default-datatable" class="table table-bordered table-hover table-striped showAccountNum" idnum='<?php echo $id; ?>'>
                <thead>
                <tr>
                  
                  <th>ID</th>
                  <th>NAME</th>
                  <th>DATE</th>
                </tr>

                </thead>
              
              </table>
            </div>
            </div>

            
                </div>
                </div>

                </div>
                </div>
                </div>
                </div>

                <?php 
                  $makeTicket = $Tickets->ctrMakeTicket();
                
                
                ?>