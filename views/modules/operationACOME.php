
<style>
  .modal-content {
    width: 1000px;
   
} .addBox {
    border-color: white;

    border-style: groove;
}
#per{
    font-size: 10px;
}

</style>
<div class="clearfix"></div>
  
<div class="content-wrapper">
   <div class="container-fluid">
     <div class="row pt-2 pb-2">
        <div class="col-sm-12">
          <h4 class="page-title">FILTER DAILY AVAILMENTS</h4>
        </div>
     </div>

      <div class="row">

        <div class="col-lg-12">
        
          <div class="card">
            <div class="card-header float-sm-right">
            <div class="row">
                <div class="col-sm-2 form-group">
                      <label for="year">Select a Year:</label>
                      <select name="year" id="year" class="form-control">
                          <?php
                              // Get the current year
                              date_default_timezone_set('Asia/Manila');
                              $currentYear = date("Y", time());

                              // Define a range of years (e.g., from current year - 10 to current year + 10)
                              $startYear = $currentYear - 10;
                              $endYear = $currentYear + 10;

                              // Loop through the range of years
                              for ($year = $startYear; $year <= $endYear; $year++) {
                                  // Check if the current year matches the loop year and set selected attribute
                                  $selected = ($year == $currentYear) ? "selected" : "";
                                  echo "<option value='$year' $selected>$year</option>";
                              }
                          ?>
                      </select>
                  </div>
              <div class="col-sm-2 form-group mt-4">
                  <button type="button" name="generateDates" class="btn btn-light btn-round waves-effect waves-light m-1 generateDates"><i class="fa fa-repeat"></i> <span>&nbsp;SELECT</span> </button>
                </div>

    
            </div>

            <br><br>
            <div class="row">
            <div class="col-sm-2 form-group ">
                      <label for="input-6">SELECT CUT OFF DATE DEC</label>
                      <input type="date" class="form-control" id="prev_year_dec"  placeholder="Enter Date"  name="prev_year_dec" autocomplete="nope" required>
              </div>
            </div>
       
            <div class="row">
              <div class="col-sm-2 form-group">
                      <label for="input-6">SELECT CUT OFF DATE JAN</label>
                      <input type="date" class="form-control " id="cur_year_jan"  placeholder="Enter Date"  name="cur_year_jan" autocomplete="nope" required>
              </div>
              <div class="col-sm-2 form-group">
                      <label for="input-6">SELECT CUT OFF DATE FEB</label>
                      <input type="date" class="form-control " id="cur_year_feb"  placeholder="Enter Date"  name="cur_year_feb" autocomplete="nope" required>
              </div>
              <div class="col-sm-2 form-group">
                      <label for="input-6">SELECT CUT OFF DATE MAR</label>
                      <input type="date" class="form-control " id="cur_year_mar"  placeholder="Enter Date"  name="cur_year_mar" autocomplete="nope" required>
              </div>
              <div class="col-sm-2 form-group">
                      <label for="input-6">SELECT CUT OFF DATE APR</label>
                      <input type="date" class="form-control " id="cur_year_apr"  placeholder="Enter Date"  name="cur_year_apr" autocomplete="nope" required>
              </div>
              <div class="col-sm-2 form-group">
                      <label for="input-6">SELECT CUT OFF DATE MAY</label>
                      <input type="date" class="form-control " id="cur_year_may"  placeholder="Enter Date"  name="cur_year_may" autocomplete="nope" required>
              </div>
              <div class="col-sm-2 form-group">
                      <label for="input-6">SELECT CUT OFF DATE JUN</label>
                      <input type="date" class="form-control " id="cur_year_jun"  placeholder="Enter Date"  name="cur_year_jun" autocomplete="nope" required>
              </div>
              <div class="col-sm-2 form-group">
                      <label for="input-6">SELECT CUT OFF DATE JUL</label>
                      <input type="date" class="form-control " id="cur_year_jul"  placeholder="Enter Date"  name="cur_year_jul" autocomplete="nope" required>
              </div>
              <div class="col-sm-2 form-group">
                      <label for="input-6">SELECT CUT OFF DATE AUG</label>
                      <input type="date" class="form-control " id="cur_year_aug"  placeholder="Enter Date"  name="cur_year_aug" autocomplete="nope" required>
              </div>
              <div class="col-sm-2 form-group">
                      <label for="input-6">SELECT CUT OFF DATE SEP</label>
                      <input type="date" class="form-control " id="cur_year_sep"  placeholder="Enter Date"  name="cur_year_sep" autocomplete="nope" required>
              </div>
              <div class="col-sm-2 form-group">
                      <label for="input-6">SELECT CUT OFF DATE OCT</label>
                      <input type="date" class="form-control " id="cur_year_oct"  placeholder="Enter Date"  name="cur_year_oct" autocomplete="nope" required>
              </div>
              <div class="col-sm-2 form-group">
                      <label for="input-6">SELECT CUT OFF DATE NOV</label>
                      <input type="date" class="form-control " id="cur_year_nov"  placeholder="Enter Date"  name="cur_year_nov" autocomplete="nope" required>
              </div>
              <div class="col-sm-2 form-group">
                      <label for="input-6">SELECT CUT OFF DATE DEC</label>
                      <input type="date" class="form-control " id="cur_year_dec"  placeholder="Enter Date"  name="cur_year_dec" autocomplete="nope" required>
              </div>
              
                <div class="col-sm-2 form-group mt-4">
                  <button type="button" name="generateAvailmentsEveryCutOffReport" class="btn btn-light btn-round waves-effect waves-light m-1 generateAvailmentsEveryCutOffReport"><i class="fa fa-repeat"></i> <span>&nbsp;GENERATE</span> </button>
                </div>
              </div> 
            </div>          
            <div class="card-body">   
                <div class="row">  
                <hr />
                <div class="float-right">
                    <button type="button" id="printAvailmentsEveryCutOffReport" hidden class="btn btn-light btn-round waves-effect waves-light m-1 printAvailmentsEveryCutOffReport"><i class="fa fa-print"></i> <span>&nbsp;PRINT</span> </button>
                </div>
                    <div id="availmentsEveryCutOffReportTable" class="table-responsive" >
                        <table class="table table-bordered table-hover table-striped availmentsEveryCutOffReportTable">
                
                        </table>
                    </div>
                </div>
            </div>
          </div>
        </div>
      </div> 
    <div class="overlay toggle-menu"></div>


  </div>        <!-- container-fluid -->
</div>          <!-- content-wrapper -->
</div>

<?php
 
//   $Operation  -> ctrDeleteLoanAging();
  
?>


  
