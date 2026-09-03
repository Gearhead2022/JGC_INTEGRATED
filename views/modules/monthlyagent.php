<?php
require_once "models/connection.php";

$connection = new Connection();
$pdo = $connection->connect();
?>


<style>
#default-datatable tr th{
  text-align:center;
  vertical-align: middle;
}
/* Change the color of the date input icon in WebKit browsers */
input[type="date"]::-webkit-calendar-picker-indicator {
  filter: invert(95%); /* Change the color to your desired color */
}

</style>
<div class="clearfix"></div>
<div class="content-wrapper">
<div class="container-fluid">

<div class="row pt-2">
        <div class="col-sm-12">
          <h4 class="page-title">MONTHLY AGENT AND RUNNERS PRODUCTION</h4>
        </div>
     </div>

     <div class="row">
        <div class="col-12">

            <div class="card">
            <div class="card-header float-sm-right">


            <div class="row">

           
                  <button type="button" class="btn btn-light btn-round waves-effect waves-light m-1" data-toggle="modal" data-target="#monthlyAgentCenterTitle"><i class="fa fa-plus"></i> <span>&nbsp;ADD AGENTS & SALES</span> </button>
                  <!-- <button type="button" class="btn btn-light btn-round waves-effect waves-light m-1" data-toggle="modal" data-target="#beginningMonthlyAgentCenterTitle"><i class="fa fa-plus"></i> <span>&nbsp;BEGINNING BALANCE AGENTS & SALES -->

                  </span> </button>
          
              
              </div> 


              <!-- monthly  agent -->
              <div class="card-body" >

          
              <div class="table-responsive">
              <table id="default-datatable" class="table table-bordered table-hover table-striped monthlyAgentsTable">
                <thead>

                <tr>  
            
                  <th>DATE</th>
                  <th>AGENTS</th>
                  <th>SALES</th>
                  <th>ACTION</th>
                </tr>

               

                </thead>
              </table>

            </div>
            </div>






            <!-- <div class="card-body">
            <div class="table-responsive"> -->
              <!-- <table  id="default-datatable" class="table table-bordered table-hover table-striped monthlyAgentsBegTable">
                <thead>

                <tr>  
            
                  <th>BEGINNING AGENTS</th>
                  <th>BEGINNING SALES</th>
                  <th>DATE</th>
                
              
                </tr>

               

                </thead>
              </table> -->
<!-- 
              </div>
            </div> -->






        <!-- FIRST modal -->
        <div class="modal fade" id="monthlyAgentCenterTitle" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
             <div class="modal-content">
                <div class="modal-header">
                   <h5 class="modal-title" id="exampleModalLongTitle">ADD AGENTS & SALES</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                <form  method="post" enctype="multipart/form-data">
            
                
            


            <div class="row">

              <div class="col-sm-6 form-group">
              <label for="input-6">AGENTS</label>
              <input type="number" class="form-control" id="agents"  name="agents" autocomplete="nope" required>
              </div>


              <div class="col-6">
              <div class="form-group">
                  <label for="input-6">SALES</label>
                  <input type="number" class="form-control dateMonthlyAgent" id="sales"  name="sales" autocomplete="nope" required>
              </div>
              </div>

              </div> 



              <div class="row">

            
              <div class="col-sm-6 form-group">
                <label for="input-6">DATE</label>
                <input type="date" class="form-control dateMonthlyAgent" id="mdate"  name="mdate" autocomplete="nope" required>
                </div>

              </div> 


                </div>
                <div class="modal-footer">
                        <button type="submit" name ="addMonthlyRecords" class="btn btn-primary">Submit</button>
                        <button type="button"  class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
              </div>
              </form>


              <?php
                            $addMonthlyAgent = new ControllerPensioner();
                            $addMonthlyAgent -> ctrAddMonthlyAgent();
                          ?>
              </div>
                </div>










              
        <!-- SECOND modal -->

        <!-- <div class="modal fade" id="beginningMonthlyAgentCenterTitle" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
             <div class="modal-content">
                <div class="modal-header">
                   <h5 class="modal-title" id="exampleModalLongTitle">BEG AGENTS & SALES</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                <form  method="post" enctype="multipart/form-data">
            
                
            


                <div class="row">
                <div class="col-sm-6 form-group">
                <label for="input-6">BEGINNING SALES</label>
                <input type="number" class="form-control" id="sales_beg_bal"  name="sales_beg_bal" autocomplete="nope" required>
                </div>

                <div class="col-6">
                <div class="form-group">
                    <label for="input-6">BEGINNING AGENTS</label>
                    <input type="number" class="form-control" id="agent_beg_bal"  name="agent_beg_bal" autocomplete="nope" required>
                </div>
                </div>

                </div> 

                <div class="row">
                  <div class="col-sm-6">
                  <label for="input-6">DATE</label>
                <input type="date" class="form-control " id="bdate"  name="bdate" autocomplete="nope" required>
                  </div>
                </div>






                  </div>
                  <div class="modal-footer">
                          <button type="submit" name ="addMonthlyRecordsBeginning" class="btn btn-primary">Submit</button>
                          <button type="button"  class="btn btn-secondary" data-dismiss="modal">Close</button>
                  </div>
                </div>
                </form>


                <?php
                            // $addMonthlyAgentbeg = new ControllerPensioner();
                            // $addMonthlyAgentbeg -> ctrAddMonthlyAgentBeg();
                          ?>
               
                  </div>
                  </div> -->





        <!-- START Edit modal for add beginning balance-->
        <div class="modal fade" id="editMonthlyAgentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
              <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">EDIT</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                          </button>
                  </div>
                  <form  method="post">
                  <div class="modal-body">
                  
                </div>
                </form>
                  <?php 
                   $monthlyedit = new ControllerPensioner();
                  $monthlyedit -> ctrEditMonthlyAgent();

                  ?>
              
            </div>
          </div>
        </div>
        
         <!-- END Edit modal for add beginning balance-->




                  <?php
 
            $monthlydelete = new ControllerPensioner();
            $monthlydelete  -> ctrDeleteMonthlyAgent();
            
            ?>






