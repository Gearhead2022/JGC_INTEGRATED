$(document).ready(function(){

    $(".resetSOAButton").on("click", function() {

        $('#searchidsoatrans').modal('hide');
        document.getElementById('SOAForm').reset();
        // $('#processpdrcoltrans').modal('hide');
        // $('#searchidpdrcoltrans').modal('hide');
       
    });
    $(".soa_note_time").on('input', function() {
        var soa_note_date = document.getElementById('soa_note_date').value;
        var soa_note_time = document.getElementById('soa_note_time').value;

        var formatted_date = moment(soa_note_date).format('MMMM D, YYYY'); // Month Day, Year

        // Format the time using Moment.js
        var formatted_time = moment(soa_note_time, 'HH:mm').format('h:mm A'); 
      
        if (soa_note_date != '' && soa_note_time != '') {
           var val1 = "SCHEDULE FOR THE GAWAD OF ACCOUNT AND RELEASING OF ATM IS ON " + formatted_date + " NOT LATER THAN " + formatted_time;
           var noteTextarea = document.getElementById('soa_note');
           noteTextarea.value = val1; // Correct way to set textarea value
        } else {
            alert('Make sure to input date on.');
        }
    });
    

    // Define the function to show the modal
    function showSOAModalWithData(data) {
        if ($.isEmptyObject(data.name)) {
            $("#soa_account_no").val('');
            $("#soa_name").val('');
            $("#soa_address").val('');
            $("#soa_bank").val('');
            $("#soa_pension").val('');
            $("#soa_lr").val('');
            $("#soa_sl").val('');

            // Show a sweetAlert indicating no data found
            swal({
                type: "info",
                title: "Record might be printed already or record doesn't exist.",
                text: "Try checking archieve or re-uploading file dbf",
                confirmButtonColor: '#08655D',
                confirmButtonText: 'OK'
            });
        } else {
            // Populate the modal fields with the received data
            $("#soa_account_no").val(data.account_no);
            $("#soa_name").val(data.name);
            $("#soa_address").val(data.address);
            $("#soa_bank").val(data.bank);
            $("#soa_pension").val(data.pension.toLocaleString('en-US', {minimumFractionDigits: 2}));
            $("#soa_lr").val(data.principal.toLocaleString('en-US', {minimumFractionDigits: 2}));
            $("#soa_sl").val(data.change.toLocaleString('en-US', {minimumFractionDigits: 2}));

            // Show the modal using Bootstrap modal
            $("#searchidsoatrans").modal("show");

            $('#searchidsoatrans .modal-body .calculateEndTotal').each(function() {
                $(this).change(); // Trigger the change event manually
            });

            if (data.change >= 0) {
                $("#soa_sl").removeClass("text-danger");
                $("#soa_sl").addClass("text-success");
            } else {
                $("#soa_sl").removeClass("text-success");
                $('#soa_interest').attr('required', true);
                $("#soa_sl").addClass("text-danger");    
            }

            $('#soa_others').attr('required', true);

            // document.getElementById('date_note').val(soa_note_date);

            
            $('#searchidsoatrans .modal-body').on("input", ".calculateEndTotal", function() {
                var $card = $(this).closest('.card');
                var soa_lr = data.principal;
                var soa_sl = data.change;
                var soa_others = parseFloat($card.find('.soa_others').val()) || 0; // Parse float here
                var soa_interest = parseFloat($card.find('.soa_interest').val()) || 0; // Parse float here
    
                var lr = parseFloat(soa_lr) || 0;
                var sl = parseFloat(soa_sl) || 0;
            
                var end_bal; // Declare end_bal variable//
            
                if (sl <= 0) { // negative sl//
                    if (lr != 0 && sl != 0) {  // w/ sl and w/ lr//
                        end_bal = (lr - sl) + soa_interest + soa_others;
                    } else if (lr == 0 && sl != 0) { //no lr w/ sl//
                        end_bal = Math.abs(sl) + soa_interest + soa_others; 
                    } else if (lr != 0 && sl == 0){ //w/ lr and no sl//
                        end_bal = lr + soa_others; 
                    } else {
                        end_bal = 0;
                    }
                } else {
                     if (lr > 0) { // w/ lr and positive sl  //   
                     if (lr <= sl) {  //sl greater than lr//
                            end_bal = (lr - sl) + soa_interest + soa_others;
                        }else{
                            end_bal = (lr - sl) + soa_interest + soa_others; 
                        }
                    } else { //else lr = 0 and sl positive//
                        end_bal = Math.abs(sl - soa_interest) - soa_others;  
                    }
                }
            
                if (!isNaN(end_bal)) {
                    $card.find('.soa_balance_of').val(end_bal.toLocaleString('en-US', {minimumFractionDigits: 2}));
                } else {
                    $card.find('.soa_balance_of').val(''); // Reset or handle as needed
                }
            });
            
        }
    }

    // Add a click event listener to the button within the modal
    $(document).on("click", ".showSOADetails", function() {
        var input = document.getElementById('soa_account_no');
        var account_no = input.value;
        var input_branch = document.getElementById('soa_branch_name');
        var branch_name = input_branch.value;

        document.getElementById('SOAForm').reset();
    
        if (account_no === "") {
            swal({
                type: "warning",
                title: "Please enter id first",
                showCancelButton: true,
                confirmButtonColor: '#08655D',
                cancelButtonColor: '#d33',
                cancelButtonText: 'cancel',
                confirmButtonText: 'OK'
            }).then(function(result) {
                if (result.value) {
                    window.location = "";
                }
            });
        } else {
            $.ajax({
                url: 'ajax/soaSearchById.ajax.php',
                data: {
                account_no: account_no, branch_name: branch_name
                },
                dataType: 'json',
                success: function(data) {
                    try {
                        showSOAModalWithData(data);
    
                    } catch (error) {
                        console.error('Error parsing response:', error);
                        swal({
                            type: "info",
                            title: "Record might be printed already or record doesn't exist.",
                            text: "Try checking archieve or re-uploading file dbf",
                            confirmButtonColor: '#08655D',
                            showConfirmButton: true,
                            confirmButtonText: "Ok"
                        });
                    }
                },
                error: function() {
                    swal.close();
                    swal({
                        type: "info",
                        title: "Record might be printed already or record doesn't exist.",
                        text: "Try checking archieve or re-uploading file dbf",
                        confirmButtonColor: '#08655D',
                        showConfirmButton: true,
                        confirmButtonText: "Ok"
                    });
                }
            });
        }
    });

    // Function to check if any of the fields are empty and open modal if necessary
    function checkFieldsAndOpenSOAModal() {
        // Get the values of the input fields
        var branchName = $('#soa_branch_name').val();
        var fa = $('#soa_branch_fa').val();
        var boh = $('#soa_branch_boh').val();
        var address = $('#soa_branch_address').val();
        var tel = $('#soa_branch_tel').val();

        // Check if any of the fields are empty
        if (!branchName || !fa || !boh || !address || !tel) {
            // If any field is empty, open the modal
            $('#soaUpdateInfo').modal('show');
        }
    }

    // Run the function when the window is loaded
    window.onload = function() {
        checkFieldsAndOpenSOAModal();
    };

    $('#addSOARecordById').click(function(event) {
        // Prevent the default button click behavior
        event.preventDefault();
    
        // Get values from the form
        var account_no = $('#soa_account_no').val();
        var name = $('#soa_name').val();
        var address = $('#soa_address').val();
        var bank = $('#soa_bank').val();
        var pension = $('#soa_pension').val();
        var principal = $('#soa_lr').val();
        var change = $('#soa_sl').val();
        var interest = $('#soa_interest').val();
        var from = $('#soa_from').val();
        var to = $('#soa_to').val();
        var others = $('#soa_others').val();
        var baltot = $('#soa_balance_of').val();
        var bcode = $('#soa_branch_name').val();
        var note = $('#soa_note').val();
        
        var soa_note_time = $('#soa_note_time').val();
        var soa_note_date = $('#soa_note_date').val();

        if (from != '' && to != '' && others != '' && soa_note_date != '' &&  soa_note_time != '') {
              // Perform your AJAX request here
            $.ajax({
                url: 'ajax/soaSaveById.ajax.php',
                type: 'GET',
                data: { 
                    account_no: account_no,
                    name: name,
                    address: address,
                    bank: bank,
                    pension: pension,
                    principal: principal,
                    change: change,
                    interest: interest,
                    from: from,
                    to: to,
                    others: others,
                    baltot: baltot,
                    bcode: bcode,
                    note: note
                },
        
                success: function(response) {
                    if (response === 'ok') {
                        document.getElementById("soa_print").hidden = false;
                        document.getElementById("addSOARecordById").disabled = true;
                    } else if (response === 'no_records') { // Corrected condition
                        document.getElementById("soa_print").hidden = true;
                        document.getElementById("addSOARecordById").disabled = false;

                        swal({
                            type: "warning",
                            title: "Please fill up these required information first",
                            confirmButtonColor: '#08655D',
                            showConfirmButton: true,
                            confirmButtonText: "Continue"
                        }).then(function(result){
                            if (result.value) {
                                document.getElementById('SOAForm').reset();
                                $("#searchidsoatrans").modal("hide");
                                $('#soaUpdateInfo').modal('show');
                            }
                        })
                    }else{
                        swal({
                            type: "info",
                            title: "There's might be issues with the process.",
                            confirmButtonColor: '#08655D',
                            showConfirmButton: true,
                            confirmButtonText: "Continue"
                        })
                    }
                },
                error: function(xhr, status, error) {
                    swal({
                        type: "info",
                        title: "There's might be issues with the process.",
                        confirmButtonColor: '#08655D',
                        showConfirmButton: true,
                        confirmButtonText: "Ok"
                    });
                }
            });
            
        } else {
            
            swal({
                type: "info",
                title: "Please provide the required fields",
                confirmButtonColor: '#08655D',
                showConfirmButton: true,
                confirmButtonText: "Ok"
            });
            
            
        }
    
    });
    
})


// kim js 

     // When the second modal is shown
$('#arcModal1').on('show.bs.modal', function (e) {
    // Close the first modal if it's open
    $('#arcModal').modal('hide');
});

$('#arcBtn1').click(function(){
    var type = "modal1";
    filterDate = $('#arcDate').val();
    var id = 0;
    if(filterDate !=""){
    $('#soaTable').empty();
    $.ajax({
        url: 'ajax/soa.ajax.php',
        data:{
            date: filterDate,
            id: id,
            type: type,
        },
        dataType: 'json',
        success: function(data){
        // Close the first modal if it's open
        $('#soaTable').append(data.card);
        $('#arcModal1').modal('show').end().modal('hide');
        deleteSOA();
        $('.arcTR').click(function() {
            account_no = $(this).attr("account_no");
            var type1 = "modal2";
            $.ajax({
                url: 'ajax/soa.ajax.php',
                data:{
                    date: filterDate,
                    id: account_no,
                    type: type1,
                },
                dataType: 'json',
                success: function(data){
                    $('.arcModalBody').empty();
                    $('.arcModalBody').append(data.card);
                    $('#arcModal2').modal('show').end().modal('hide');
                    uniqueID = data.id;
                },
            error: function(){
                alert("my erropr");
            }

        })
        })
        },
        error: function(){
            alert("my erropr");
        }
    })
}else{
    swal({
        title: 'Select date first!',
        type: 'warning',
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'OK'
      }).then(function(result){
        if (result.value) {
            
        }
  })
}
})
$('#arcSearch').click(function(){
    var id = $('#arcID').val();
    var type = "modal1";
   
    if(id == ""){
       id=0;
    }
    $('#soaTable').empty();
    $.ajax({
        url: 'ajax/soa.ajax.php',
        data:{
            date: filterDate,
            id: id,
            type: type,
        },
        dataType: 'json',
        success: function(data){
            // Close the first modal if it's open
            $('#soaTable').append(data.card);
                deleteSOA();
                $('.arcTR').click(function() {
                    var type1 = "modal2";
                    account_no = $(this).attr("account_no");
                    $.ajax({
                        url: 'ajax/soa.ajax.php',
                        data:{
                            date: filterDate,
                            id: account_no,
                            type: type1,
                        },
                        dataType: 'json',
                        success: function(data){
                            $('.arcModalBody').empty();
                            $('.arcModalBody').append(data.card);
                            $('#arcModal2').modal('show').end().modal('hide');
                            uniqueID = data.id;
                        },
                    error: function(){
                        alert("ERROR");
                    }

                })
                })
            },
            error: function(){
                alert("ERROR");
            }
    })
})

$('#printArcSOA').click(function(){
    var pass = $('#arcInPass').val();
    var type = "reprint";
   if(pass == "ORAETLABORA"){
    $.ajax({
        url:'ajax/soa.ajax.php',
        data:{
            type: type,
            id: uniqueID,
        },
        dataType: "json",
        success: function(data){
            window.open("extensions/tcpdf/pdf/statement_of_account.php?id="+account_no+"&date="+filterDate);
            $('#arcPassword').modal('hide');
            var pass = $('#arcInPass').val("");
        },
        error: function(){
            alert("error");
        }  
    })

   }else{
    swal({
        title: 'The password you entered is incorrect!',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'cancel',
        confirmButtonText: 'Yes'
      }).then(function(result){
        if (result.value) {
            
        }
  })
   }
})

$('#arcReprint').click(function(){              
    var pass = $('#arcInPass').val("");
})


function reloadAjax(){
    var type = "modal1";
    filterDate = $('#arcDate').val();
    var id = 0;
    if(filterDate !=""){
    $('#soaTable').empty();
    $.ajax({
        url: 'ajax/soa.ajax.php',
        data:{
            date: filterDate,
            id: id,
            type: type,
        },
        dataType: 'json',
        success: function(data){
        // Close the first modal if it's open
        $('#soaTable').append(data.card);
        $('#arcModal1').modal('show').end().modal('hide');

         deleteSOA();
        $('.arcTR').click(function() {
            account_no = $(this).attr("account_no");
            var type1 = "modal2";
            $.ajax({
                url: 'ajax/soa.ajax.php',
                data:{
                    date: filterDate,
                    id: account_no,
                    type: type1,
                },
                dataType: 'json',
                success: function(data){
                    $('.arcModalBody').empty();
                    $('.arcModalBody').append(data.card);
                    $('#arcModal2').modal('show').end().modal('hide');
                    uniqueID = data.id;
                },
            error: function(){
                alert("my erropr");
            }

        })
        })

        }

        });
    
}
    }


function deleteSOA(){
    $('.soaDltBtn').click(function(e){
        e.stopPropagation(); // Stop propagation to parent elements
        var soaID = $(this).attr('soaID');
        $('#arcDelPassword').modal('show');
            $('#deleteArcSOA').click(function(){
                var pass = $('#arcDelPass').val();
                if(pass == "ORAETLABORA"){
                swal({
                    title: 'Are you sure?',
                    text: 'Once deleted, you will not be able to recover this item!',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, cancel!'
                }).then(function(result) {
                    if (result.value) {
                        var type2 = "delete";
                        $.ajax({
                            url:'ajax/soa.ajax.php',
                            data:{
                                type: type2,
                                id: soaID,
                            },
                            dataType: "json",
                            success: function(data){
                                reloadAjax();
                                swal({
                                    title: 'Deleted!',
                                    text: 'The item has been successfully deleted.',
                                    type: 'success',
                                    confirmButtonColor: '#3085d6',
                                    confirmButtonText: 'OK'
                                });
                                $('#arcDelPassword').modal('hide');
                                $('#arcDelPass').val("");
                            },
                            error: function(){
                                swal({
                                    title: 'Error',
                                    text: 'Error deleting data',
                                    type: 'error',
                                    confirmButtonColor: '#3085d6',
                                    confirmButtonText: 'OK'
                                });
                            }  
                        });
                }
        });
    }else{
        swal({
            title: 'The password you entered is incorrect!',
            type: 'warning',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Yes'
          }).then(function(result){
            if (result.value) {
                
            }
      })
    }
    })
        $('#arcID').val("");
    });
  

}

$('#soa_print').click(function(){

    var id = $('#soa_account_no').val();
    var date = $('#soa_to').val();
     window.open("extensions/tcpdf/pdf/statement_of_account.php?id="+id+"&date="+date);  
     
     $('#searchidsoatrans').modal('hide');
     document.getElementById('SOAForm').reset();
     document.getElementById("soa_print").hidden = true;
     document.getElementById("addSOARecordById").disabled = false;
})


$('#arcLogs').click(function(){
    // Show the arcModalLogs modal
     $('#soaLogsTable').empty();
    var type = "logs";
    $.ajax({
        url: 'ajax/soa.ajax.php',
        data:{
            type: type,
        },
        dataType: 'json',
        success: function(data){
        // Close the first modal if it's open
        $('#soaLogsTable').append(data.card);
        $('#arcModalLogs').modal('show');
        },
        error: function(){
            alert("error");
        }
        })
});

// Event listener for when arcModalLogs is about to be shown
$('#arcModalLogs').on('show.bs.modal', function (e) {
    // Close arcModal1 if it's open
    $('#arcModal1').modal('hide');
});

// Event listener for when arcModal1 is about to be shown
$('#arcModalLogs').on('hide.bs.modal', function (e) {
    // Close arcModalLogs if it's open
    $('#arcModal1').modal('show');
});
