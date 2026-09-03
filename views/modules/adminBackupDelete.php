
<div class="clearfix"></div>
  
<div class="content-wrapper">
   <div class="container-fluid">
     <div class="row pt-2 pb-2">
        <div class="col-sm-12">
          <h4 class="page-title">MANAGE BACKUP</h4>
        </div>
     </div>

      <div class="row">
        <div class="col-lg-12">
        
          <div class="card">
            <div class="card-header float-sm-right">
              <div class="row">
              <div class="col-2.1">
                    <label for="inputIdNo" class="col-form-label">SEARCH BACKUP DATE :</label>
                </div>
                <!-- <div class="col-2">
                    <input type="text" class="form-control" id="backup_year" name="backup_year" value="<?php echo date('Y'); ?>" readonly required>
                </div> -->

                <div class="col-2">
                    <input type="month" class="form-control" id="backup_month" name="backup_month" required onchange="updateWeekOptions()">
                </div>

                <div class="col-2">
                    <select class="form-control" id="backup_week" name="backup_week" required onchange="updateDateSpan()">
                        <option value="">Select Week</option> -->
                        <!-- Week options will be populated based on the month selection -->
                    </select>
                </div>

                <div class="col-2">
                    <input type="text" class="form-control" id="date_span" name="date_span" placeholder="Date Span" readonly>
                </div>
               
                <input type="text" hidden class="form-control" id="date_start" name="date_start" placeholder="Date Span" readonly>
                <input type="text" hidden class="form-control" id="date_end" name="date_end" placeholder="Date Span" readonly>
               
                <div class="col-sm-2 form-group">  
                  <button type="button" name="" class="btn btn-light btn-round waves-effect waves-light m-1 generateBackupMonthlyList"><i class="fa fa-refresh"></i> <span>&nbsp;GENERATE</span> </button>
                </div>

                <div class="col-sm-2 form-group">  
                  <button type="button" name="" disabled id="deleteBackupMonthlyList" class="btn btn-danger btn-round waves-effect waves-light m-1 deleteBackupMonthlyList"><i class="fa fa-minus-square"></i> <span>&nbsp;DELETE ALL</span> </button>
                </div>
            </div>    
            </div>        

            <div class="card-body">
              <div class="table-responsive">
              <table id="default-datatable" class="table table-bordered table-hover table-striped backupMonthlyDataList">
                <thead>
                <tr>
                  <th>Branch Name</th>
                  <th>No. Backup</th>
                  <th>Month Year</th>
                  <th>Date Span</th>
                </tr>
                </thead>
              </table>
            </div>
            </div>
          </div>
        </div>
      
      </div>    <!-- row -->

</div>

    <div class="overlay toggle-menu"></div>


  </div>        <!-- container-fluid -->
</div>          <!-- content-wrapper -->

<script>

function formatLocalDate(date) {
  const y = date.getFullYear();
  const m = String(date.getMonth() + 1).padStart(2, '0');
  const d = String(date.getDate()).padStart(2, '0');
  return `${y}-${m}-${d}`;
}

function updateWeekOptions() {
    const monthInput = document.getElementById('backup_month');
    if (!monthInput.value) return;

    const [year, month] = monthInput.value.split('-').map(Number);
    const weekSelect = document.getElementById('backup_week');
    weekSelect.innerHTML = '<option value="">Select Week</option>';

    const firstDayOfMonth = new Date(year, month - 1, 1);
    const lastDayOfMonth  = new Date(year, month, 0);

    let currentStart = new Date(firstDayOfMonth);
    let weekCount = 1;

    while (currentStart <= lastDayOfMonth) {
        const currentEnd = new Date(currentStart);

        // End week on Saturday (6)
        // const dayOfWeek = currentEnd.getDay();
        // const daysToSaturday = 6 - dayOfWeek;
        // currentEnd.setDate(currentEnd.getDate() + daysToSaturday);

        const dayOfWeek = (currentEnd.getDay() + 6) % 7;
        const daysToSunday = 6 - dayOfWeek;
        currentEnd.setDate(currentEnd.getDate() + daysToSunday);


        if (currentEnd > lastDayOfMonth) {
            currentEnd.setTime(lastDayOfMonth.getTime());
        }

        const startDay = currentStart.getDate();
        const endDay = currentEnd.getDate();

       weekSelect.innerHTML += `
          <option 
              value="${weekCount}" 
              data-start="${formatLocalDate(currentStart)}"
              data-end="${formatLocalDate(currentEnd)}"
          >
              Week ${weekCount} (${startDay} - ${endDay})
          </option>
      `;


        currentStart.setDate(currentEnd.getDate() + 1);
        weekCount++;
    }
}

function updateDateSpan() {
    const weekSelect = document.getElementById('backup_week');
    const option = weekSelect.options[weekSelect.selectedIndex];

    if (!option || !option.dataset.start) {
        document.getElementById('date_span').value = '';
        return;
    }

    const startDate = new Date(
        option.dataset.start + 'T00:00:00'
    );
    const endDate = new Date(
        option.dataset.end + 'T00:00:00'
    );

    const formatter = new Intl.DateTimeFormat('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
    });

    document.getElementById('date_span').value =
        `${formatter.format(startDate)} to ${formatter.format(endDate)}`;


    document.getElementById('date_start').value = option.dataset.start;
    document.getElementById('date_end').value = option.dataset.end;

}

</script>


