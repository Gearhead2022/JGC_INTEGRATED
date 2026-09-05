<style>
    .success  {
    height: 2em;
    padding: 6px;
    font-size: 0.85em;
}
</style>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>

      // Fetch and display existing login requests on page load
      $(document).ready(function() {
            $.ajax({
                url: 'ajax/getPendingLoginRequests.php', // Your endpoint to fetch existing requests
                method: 'GET',
                success: function(data) {
                    data.forEach(request => {
                        const username = request.username;
                        const request_time = request.request_time;
                        const request_id = request.request_id;
                        console.log(username);
                        const username1 = username.trim().replace(/\s+/g, '');

                            let date = new Date(request_time);
                            // Format the date
                            let options = { 
                            year: 'numeric', 
                            month: 'long', 
                            day: 'numeric', 
                            hour: 'numeric', 
                            minute: 'numeric', 
                            second: 'numeric', 
                            hour12: true 
                            };

                            let formattedDate = date.toLocaleString('en-US', options);

                        // Create a new row for each existing login request
                        const newRow = `<tr id="row-${username1}">
                                            <td>${username}</td>
                                            <td>${formattedDate}</td>
                                            <td>
                                                <div class='btn-group group-round m-1'>
                                                     <button class="btn btn-success" onclick="approveLogin('${username}', '${request_id}')">Approve</button>
                                                     <button class="btn btn-danger" onclick="rejectLogin('${username}', '${request_id}')">Reject</button>
                                                </div>
                                            </td>
                                        </tr>`;
                        $('#login-requests tbody').append(newRow);
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching pending requests:', error);
                    alert('Failed to fetch pending login requests.');
                }
            });

            let table = $('.showTable').DataTable({
        "order": [[0, "desc"]], // Ensure sorting by the first column in descending order
        "paging": true,
        "searching": true,
        "info": true,
        "destroy": true // Allow reinitialization if necessary
    });

            generateTable(table);
   
          
        });
    // Create a WebSocket connection
    conn = new WebSocket('wss://jgcintegratedsystems.com/ws/');  // Use your local IP address
    // Listen for incoming messages
    conn.onmessage = function(event) {
    const response = JSON.parse(event.data);

    if (response.type === 'new_login_request') {
        let coordinator = $('#session').val();
        let sessionType = $('#sessionType').val();
        const username = response.username;
        const request_id = response.request_id;
        const date = response.date;
        const username1 = username.trim().replace(/\s+/g, '');

        // If session type is 'admin', bypass branch filtering and show all requests
        if (sessionType === 'admin' || sessionType ==='login_admin') {
            // Create a new row for the login request in the table for admin
            const newRow = `<tr id="row-${username1}">
                                <td>${username}</td>
                                <td>${date}</td>
                                <td>
                                     <div class='btn-group group-round m-1'>
                                        <button class="btn btn-success" onclick="approveLogin('${username}', '${request_id}')">Approve</button>
                                        <button class="btn btn-danger" onclick="rejectLogin('${username}', '${request_id}')">Reject</button>
                                     </div>
                                </td>
                            </tr>`;
            $('#login-requests tbody').append(newRow); // Append the new row to the table
        } else {
         
                // Create a new row for the login request in the table
                const newRow = `<tr id="row-${username1}">
                                    <td>${username}</td>
                                    <td>${date}</td>
                                    <td>
                                         <div class='btn-group group-round m-1'>
                                            <button class="btn btn-success" onclick="approveLogin('${username}', '${request_id}')">Approve</button>
                                            <button class="btn btn-danger" onclick="rejectLogin('${username}', '${request_id}')">Reject</button>
                                         </div>
                                    </td>
                                </tr>`;
                $('#login-requests tbody').append(newRow); // Append the new row to the table
            
        }
    } else if (response.type === 'error') {
        alert('Error: ' + response.message);
    }
};

    // Function to approve a login request
    function approveLogin(username, request_id) {
    let coordinator = $('#session').val();
    let table = $('.showTable').DataTable(); 
    const username1 = username.trim().replace(/\s+/g, '');
    
    // Send login confirmation for the user
    conn.send(JSON.stringify({ type: 'login_confirmation', request_id, username, coordinator }));

    // Use SweetAlert to show a confirmation message
    Swal.fire({
        title: 'Login Approved',
        text: `Login request for ${username} has been approved.`,
        icon: 'success',
        confirmButtonText: 'OK'
    }).then(() => {
        // Remove the row from the table after approval
        $(`#row-${username1}`).remove();
        generateTable(table);
    });
}


function rejectLogin(username, request_id) {
    let coordinator = $('#session').val();
    let table = $('.showTable').DataTable(); 
    const username1 = username.trim().replace(/\s+/g, '');

    // Send rejection message for the user
    conn.send(JSON.stringify({ type: 'reject_login', request_id, username, coordinator }));

    // Use SweetAlert to show a rejection message
    Swal.fire({
    title: 'Login Rejected',
    text: `The login request for ${username} has been rejected.`,
    icon: 'success',
    confirmButtonText: 'OK'
})
.then(() => {
        // Remove the row from the table after rejection
        $(`#row-${username1}`).remove();
        generateTable(table);
    });
}



  
function formatDate(request_time){
                let date = new Date(request_time);
            // Format the date
            let options = { 
            year: 'numeric', 
            month: 'long', 
            day: 'numeric', 
            hour: 'numeric', 
            minute: 'numeric', 
            second: 'numeric', 
            hour12: true 
            };

           return formattedDate = date.toLocaleString('en-US', options);
}
function generateTable(table){
    let type = "showTable";
    $.ajax({
        url: 'ajax/loginprocessing.ajax.php',
        data: {
            type: type
        },
        dataType: 'json',
        success: function(data) {
            if (table) {
                // Clear existing table data
                table.clear().draw();  

                // Sort the data by ID in descending order
                data.sort((a, b) => b.id - a.id);

                // Loop through the sorted data
                $.each(data, function(index, item) {
                    let requestDate = formatDate(item.request_time);
                    let approvedDate = formatDate(item.time_change);

                    let is_approved = item.is_approved;
                    if(is_approved == 1){
                        is_approved = '<span class="badge badge-success success">APPROVED</span>';
                    } else {
                        is_approved = '<span class="badge badge-danger success">REJECTED</span>';
                    }
                    // Add rows using the DataTables API
                    table.row.add([
                        item.id,   // First column data (Username)
                        item.username,   // First column data (Username)
                        item.full_name,    // Second column data (Actions)
                        requestDate, 
                        is_approved,    
                        approvedDate,    
                        item.coordinator 
                    ]).draw();
                    console.log(item);
                });
            } else {
                console.error('DataTables is not initialized.');
            }
        },
        error: function(xhr, status, error) {
            console.error('Error fetching data:', error);
            alert('Failed to fetch data.');
        }
    });
}



$("#logout").on("click", function(){
  
  swal.fire({
        title: 'Are you sure you want to logout?',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'cancel',
        confirmButtonText: 'Yes'
      }).then(function(result){
        if (result.value) {
            window.location = "logout";
        }
  })
})

</script>

<div class="clearfix"></div>
<div class="content-wrapper">
   <div class="container-fluid">
     <div class="row pt-2 pb-2">
        <div class="col-sm-12">
          <h4 class="page-title">LOGIN REQUEST</h4>
        </div>
     </div>
      <div class="row">
        <div class="col-sm-12">
            <input type="text" name="" hidden id="session" value="<?php echo $_SESSION['branch_name']; ?>" >
            <input type="text" name="" hidden id="sessionType" value="<?php echo $_SESSION['type']; ?>" >
            <div class="card">
                <div class="card-header float-sm-right">    
                    <!-- Table to display login requests -->
                    <div class="table-responsive">
                    <table id="login-requests"  class="table table-bordered table-hover table-striped ">
                        <thead>
                            <tr>
                                <th>Username</th>
                                <th>Request Time</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Login requests will be appended here dynamically -->
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div>
     </div>
     <div class="col-sm-12">
          <h4 class="page-title">PERMISSION GRANTED</h4>
     </div>


     <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header float-sm-right">
                <div class="table-responsive">
                <table id="default-datatable" class="table table-bordered table-hover table-striped showLoginTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Branch</th>
                            <th>Request Time</th>
                            <th>Status</th>
                            <th>Action Time</th>
                            <th>Coordinator</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Data will be populated here -->
                    </tbody>
                </table>

                 </div>
                </div>
            </div>
        </div>
     </div>
     <div class="overlay toggle-menu"></div>
   </div> <!-- container-fluid -->
</div> <!-- content-wrapper -->
