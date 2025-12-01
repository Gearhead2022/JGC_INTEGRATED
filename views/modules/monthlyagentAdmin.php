<?php
  $branch_name = $_SESSION['branch_name'];
?>

<style>
#default-datatable tr th{
  text-align:center;
  vertical-align: middle;
}
input[type="month"]::-webkit-calendar-picker-indicator {
  filter: invert(95%);
}

</style>
<div class="clearfix"></div>
<div class="content-wrapper">
<div class="container-fluid">

<div class="row pt-2">
        <div class="col-sm-12">
          <h4 class="page-title">ADMIN MONTHLY AGENT AND RUNNERS PRODUCTION</h4>
        </div>
     </div>

     <div class="row">
        <div class="col-12">

            <div class="card">
            <div class="card-header float-sm-right">


            <div class="row">

            <?php if($_SESSION['type'] =="admin" || $_SESSION['type'] =="operation_admin" ){?>
            <div class="col-sm-2 form-group">
            <label for="input-6">DATE</label>
            <input type="month" class="form-control" id="mdate" name="mdate" autocomplete="nope" required>
            </div>   
            <div class="col-sm-2 form-group mt-4">       
            <button type="button" name="generateMonthlyAgentReport" class="btn btn-light btn-round waves-effect waves-light m-1 generateMonthlyAgentReport"><i class="fa fa-print"></i> <span>&nbsp;GENERATE</span> </button>
            </div>
            <div class="col-sm-2 mt-4">
            <button type="button" name="generateMonthlyAgentReport" class="btn btn-light btn-round waves-effect waves-light m-1"  onClick="location.href='ChartmonthlyAgent'"><i class="fa fa-print"></i> <span>&nbsp;CHART</span> </button>

            </div>
            <?php  }?>
              


            </div> 



          <div class="card-body" >

          <div class="float-right">
          <button type="button" id="printMonthlyAgent" hidden class="btn btn-light btn-round waves-effect waves-light m-1 " data-toggle="modal" data-target="#addCorrespondentForMonthlyAgent"><i class="fa fa-print"></i> <span>&nbsp;PRINT</span> </button>
          </div>
        
          <div class="table-responsive monthlyagentTable ">
          <table class="table table-bordered table-hover table-striped showTableMonthlyAgentReport">
            
            

          </table>

          </div>
          </div>




  
      </div>



<!-- modal for correspondeents, prepared by eg. -->



            <div class="modal fade" id="addCorrespondentForMonthlyAgent" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">ADD CORRESPONDENT</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                            </button>
                    </div>
                    <form  method="post">
                    <div class="modal-body">
                    <div class="row">

                    <div class="col-sm-12 form-group">
                          <input type="text" class="form-control mdate_clone"  id="mdate_clone" name="mdate_clone"  autocomplete="nope" hidden>
                    </div>
                   
                    <div class="col-sm-12 form-group">
                          <label for="input-6">PREPARED BY:</label>
                          <textarea type="text" class="form-control " style="white-space: pre-wrap;" id="wp_req_for" placeholder="Provide Name"  name="preparedMABy" autocomplete="nope">GLORY MAE D. JUNTADO</textarea>
                  </div>
               
                        </div>

                    </div>
                    <div class="modal-footer">
                            <button type="submit" name="saves" class="btn btn-primary">PRINT</button>
                            <button type="button"  class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
                </form>
                <?php
                  
                      $addMACorrespondents = new ControllerPensioner();
                      $addMACorrespondents->ctrAddMAReportCorrespondent();
    
                  ?>
            </div>
            </div>

            <!-- END REPORT CORRESPONDENTs MODAL -->
