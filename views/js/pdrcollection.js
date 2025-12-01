$(document).ready(function() {

    $('.pdrCollDateTable').DataTable({
    "ajax": "ajax/pdrcollectionlist.ajax.php", 
    "deferRender": true,
    "retrieve": true,
    "processing": true,
  
  });


    $(".resetpdrButton").on("click", function() {

        $('#addpdrcoltrans').modal('hide');
        $('#processpdrcoltrans').modal('hide');
        $('#searchidpdrcoltrans').modal('hide');
        document.getElementById('pdrForm').reset();
        document.getElementById('pdrNewForm').reset();
        $("#message1").attr('hidden', false); // Ensure message2 is hidden
        $("#message2").attr('hidden', true); // Ensure message2 is hidden
        $("#new_account_no").attr('readonly', false);
       
    });

    $(".pdrCollDateTable").on("click", "tbody .btnProccessPDRCollection", function() {
      var account_no = $(this).attr("account_no");
      var tdate = $(this).attr("tdate");
      var branch_name = $(this).attr("branch_name");
  
      $('#processpdrcoltrans .modal-body').empty();
  
      $.ajax({
          url: 'ajax/processPDRCollection.ajax.php',
          data: {
              account_no: account_no,
              tdate: tdate,
              branch_name: branch_name
          },
          dataType: 'json',
          success: function(data) {
            $.each(data, function(index, item) {
                var card = item.card;
                $('#processpdrcoltrans .modal-body').append(card);
            });
            $('#processpdrcoltrans').modal('show');
        
            // After appending all cards, trigger change event for .calculateEndBal elements
            // This will ensure that end_bal is calculated automatically for pre-filled values
            $('#processpdrcoltrans .modal-body .calculateEndBal').each(function() {
                $(this).change(); // Trigger the change event manually
            });
        
            // Bind the change event listener for dynamic calculation
            $('#processpdrcoltrans .modal-body').on("input", ".calculateEndBal", function() {
                var $card = $(this).closest('.card');
                var prev_bal_input = $card.find('.prev_bal').val();
                var credit_input = $card.find('.credit').val();
                var debit_input = $card.find('.debit').val();
   
                var prev_bal = parseFloat(prev_bal_input) || 0;
                var credit = parseFloat(credit_input) || 0;
                var debit = parseFloat(debit_input) || 0;
                
                var end_bal = prev_bal + debit - credit;
        
                if (!isNaN(end_bal)) {
                    $card.find('.end_bal').val(end_bal.toFixed(2));
                } else {
                  console.log("Prev Bal:", prev_bal, "Amt Paid:", credit);
                    $card.find('.end_bal').val(''); // Reset or handle as needed
                }
            });
        },
          error: function() {
              alert('Error fetching data');
          }
      });
  });

  // Initialize DataTable

  $('.pdrCollArchiveDateTable').DataTable({
    "ajax": "ajax/pdrcollectionarchivelist.ajax.php", 
    "deferRender": true,
    "retrieve": true,
    "processing": true,
  
  });

// Filter list event
$(".filterPDRArchiveList").on("click", function() {
  var fdate = document.getElementById('seltfromdate');
  var fromdate = fdate.value;

  var tdate = document.getElementById('selttodate');
  var todate = tdate.value;

  var fromDate = new Date($('#seltfromdate').val());
  var toDate = new Date($('#selttodate').val());
  var firstDayOfWeek = new Date(fromDate);
  firstDayOfWeek.setDate(fromDate.getDate() - fromDate.getDay() + 1);
  var lastDayOfWeek = new Date(firstDayOfWeek);
  lastDayOfWeek.setDate(firstDayOfWeek.getDate() + 4);
  var diffInDays = Math.abs((toDate - fromDate) / (1000 * 60 * 60 * 24));
  
  if (fromDate.getDay() === 1 && toDate.getDay() === 5 && fromDate >= firstDayOfWeek && toDate <= lastDayOfWeek || diffInDays <= 4) {

    swal({
      title: "Generating",
      text: "Please wait...",
      allowOutsideClick: false,
      allowEscapeKey: false,
      onOpen: () => {
        swal.showLoading();
      }
    });

    var table = $('.pdrCollArchiveDateTable').DataTable();

      // Clear the existing data
      table.clear().draw();

    $.ajax({
      url: 'ajax/pdrcollectionarchivelist.ajax.php',
      data: {
        fromdate: fromdate, todate: todate
      },
      dataType: 'json',
      success: function(data) {
        swal.close();

        
        if (data.data.length > 0) {
          // Add new data to the table
          table.rows.add(data.data).draw();
      } else {
          // Show a message or handle empty data as needed
          swal({
              type: "warning",
              title: 'No Records Found in Transaction Date <u> ' + fromdate+'</u>',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              cancelButtonText: 'cancel',
              confirmButtonText: 'OK'
            }).then(function(result){
              if (result.value) {
                  
              }
            
            });
      }

        var print = document.getElementById("printPDRCollection");
        print.hidden = false;
      },
      error: function() {
        swal.close();
        alert('Error fetching data');
      }
    });
  }else{
    swal({
      type: "warning",
      title: "Please Select 1 Week Range of Report Monday to Friday!",
      showConfirmButton: true,
      confirmButtonText: "Ok"
    }).then(function(result){
      if (result.value) {
      
      }
    });
  }
});


$("#printPDRCollection").on("click", function() {
  var fdate = document.getElementById('seltfromdate');
  var from_date = fdate.value;

  var tdate = document.getElementById('selttodate');
  var to_date = tdate.value;

  // Open the first URL in a new tab/window to initiate the download
  window.open("email/export_branch_pdr_collection.php?from_date=" + from_date + "&to_date=" + to_date, '_blank');

  // Use setTimeout to delay the execution of the second function
  setTimeout(function() {
      callOtherFunction(from_date, to_date);
  }, 5000); // Delay in milliseconds (5000ms = 5 seconds)
});

function callOtherFunction(from_date, to_date) {
  // For the second call, change window.location to redirect or open in a new tab as preferred
  window.location = "API/exportSQLtoDBF.php?from_date=" + from_date + "&to_date=" + to_date;
  
   // Use setTimeout to delay the execution of the second function
    setTimeout(function() {
    // Trigger the click event on .filterPDRArchiveList programmatically
      $(".filterPDRArchiveList").trigger("click");
    }, 5000); // Adjust the timeout as needed
}


// add transaction

// Define the function to show the modal
function showModalWithData(data) {
  if ($.isEmptyObject(data.account_no)) {
      $("#due_id").val('');
      $("#search_first_name").val('');
      $("#search_last_name").val('');
      $("#search_middle_name").val('');
      $("#search_status").val('');
      $("#search_edate").val('');
      $("#search_tdate").val('');
      $("#search_ref").val('');
      $("#search_prev_bal").val('');
    //   $("#pdr_coll_branch").val('');
      // Show a sweetAlert indicating no data found
      swal({
          type: "info",
          title: "No information found",
          text: "The provided ID has no information associated with it.",
          confirmButtonColor: '#3085d6',
          confirmButtonText: 'OK'
      });
  } else {
      // Populate the modal fields with the received data
      $("#due_id").val(data.due_id);
      $("#search_first_name").val(data.first_name);
      $("#search_last_name").val(data.last_name);
      $("#search_middle_name").val(data.middle_name);
      $("#search_status").val(data.status);
      $("#search_edate").val(data.edate);
      $("#search_tdate").val(data.tdate);
      $("#search_ref").val(data.ref);
      $("#search_prev_bal").val(Math.abs(data.prev_bal));
      $("#pdr_coll_branch").val(data.branch_name);

      // Show the modal using Bootstrap modal
      $("#searchidpdrcoltrans").modal("show");

      // After appending all cards, trigger change event for .calculateEndBal elements
        // This will ensure that end_bal is calculated automatically for pre-filled values
        $('#searchidpdrcoltrans .modal-body .calculateEndBal').each(function() {
          $(this).change(); // Trigger the change event manually
      });
  
      // Bind the change event listener for dynamic calculation
      $('#searchidpdrcoltrans .modal-body').on("input", ".calculateEndBal", function() {
          var $card = $(this).closest('.card');
          var prev_bal_input = $card.find('.prev_bal').val();
          var credit_input = $card.find('.credit').val();
          var debit_input = $card.find('.debit').val();

          var prev_bal = parseFloat(prev_bal_input) || 0;
          var credit = parseFloat(credit_input) || 0;
          var debit = parseFloat(debit_input) || 0;

            end_bal = prev_bal + debit - credit;
    
          if (!isNaN(end_bal)) {
              $card.find('.end_bal').val(end_bal.toFixed(2));
          } else {
            // console.log("Prev Bal:", prev_bal, "Amt Paid:", amt_paid);
              $card.find('.end_bal').val(''); // Reset or handle as needed
          }

          // Check if any of the input fields have a value
          var hasValue = credit_input || debit_input;

          // Enable or disable the button based on the condition
          if (hasValue) {
              $('#addPDRCollRecordById').removeAttr('disabled');
          } else {
              $('#addPDRCollRecordById').attr('disabled', true);
          }
      });
  }
}

// Add a click event listener to the button within the modal
$(document).on("click", ".showPDRDetails", function() {
  var input = document.getElementById('pdr_coll_account_no');
  var account_no = input.value;
  var input_branch = document.getElementById('pdr_coll_branch');
  var branch_name = input_branch.value;

  if (account_no === "") {
      swal({
          type: "warning",
          title: "Please enter id first",
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
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
          url: 'ajax/pdrCollSearchById.ajax.php',
          data: {
            account_no: account_no, branch_name: branch_name
          },
          dataType: 'json',
          success: function(data) {
              try {
                  showModalWithData(data);


              } catch (error) {
                  console.error('Error parsing response:', error);
                  swal({
                      title: "Error",
                      text: "An error occurred while processing the response.",
                      icon: "error"
                  });
              }
          },
          error: function() {
              swal.close();
              alert('Error fetching data');
          }
      });
  }
});


// For Adding new Transaction

// After appending all cards, trigger change event for .calculateEndBal elements
        // This will ensure that end_bal is calculated automatically for pre-filled values
        $('#searchidpdrcoltrans .modal-body .calculateEndBal').each(function() {
          $(this).change(); // Trigger the change event manually
      });
  
      // Bind the change event listener for dynamic calculation
      $('#addpdrcoltrans .modal-body').on("input", ".calculateEndBal", function() {
          var $card = $(this).closest('.card');
          var prev_bal_input = $card.find('.new_prev_bal').val();
          var credit_input = $card.find('.new_credit').val();
          var debit_input = $card.find('.new_debit').val();

          var prev_bal = parseFloat(prev_bal_input) || 0;
          var credit = parseFloat(credit_input) || 0;
          var debit = parseFloat(debit_input) || 0;

            end_bal = prev_bal + debit - credit;
    
          if (!isNaN(end_bal)) {
              $card.find('.new_end_bal').val(end_bal.toFixed(2));
          } else {
            // console.log("Prev Bal:", prev_bal, "Amt Paid:", amt_paid);
              $card.find('.new_end_bal').val(''); // Reset or handle as needed
          }

              // Check if any of the input fields have a value
        //   var hasValue = credit_input || debit_input;

         // Enable or disable the button based on the condition
        //   if (hasValue) {
        //       $('#addNewPDRCollRecord').removeAttr('disabled');
        //   } else {
        //       $('#addNewPDRCollRecord').attr('disabled', true);
        //   }
      });

      //delete from tmp_pdr_coll

      $(".pdrCollDateTable").on("click", "tbody .btnDeletePDRCollection", function(){
        var account_no = $(this).attr("account_no");
        var tdate = $(this).attr("tdate");
        var branch_name = $(this).attr("branch_name");
        var id = $(this).attr("id");
      
        swal({
              title: 'Do you want to delete this data?',
              type: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              cancelButtonText: 'cancel',
              confirmButtonText: 'Yes'
            }).then(function(result){
             if (result.value) {
                  window.location = "index.php?route=branchPDRColl&account_no="+account_no+"&tdate="+tdate+"&branch_name="+branch_name+"&id="+id;
              }
        })
      })

       //delete from pdr_coll and past_due_ledger

       $(".pdrCollArchiveDateTable").on("click", "tbody .btnDeletePDRCollectionArchive", function(){
        var account_no = $(this).attr("account_no");
        var tdate = $(this).attr("tdate");
      
        var branch_name = $(this).attr("branch_name");
      
        swal({
              title: 'Do you want to delete this data?',
              type: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              cancelButtonText: 'cancel',
              confirmButtonText: 'Yes'
            }).then(function(result){
              if (result.value) {
                  window.location = "index.php?route=branchPDRCollArchive&account_no="+account_no+"&tdate="+tdate+"&branch_name="+branch_name;
              }
        })
      })

      // PDR LEDGER

      $('.pastdueListTable').DataTable({
        "ajax": "ajax/pdrBranchCollectionList.ajax.php", 
        "deferRender": true,
        "retrieve": true,
        "processing": true,
        "order": [[2, 'asc']],
        "iDisplayLength": 25,
    
      }); 

      $(".pastdueListTable").on("click", "tbody .btnViewPastDue", function(){
        var branch_name = $(this).attr("branch_name");
        var account_no = $(this).attr("account_no");
        window.location = "index.php?route=branchPDRShowLedger&branch_name="+branch_name+"&account_no="+account_no;
      })
    

      $('.showLedgerTable').DataTable({
        "ajax": {
            "url": "ajax/pdrBranchLedger.ajax.php",
            "data": function (d) {
                d.account_no = $('.showLedgerTable').attr("account_no");
            }
        },
        "deferRender": true,
        "retrieve": true,
        "processing": true,
        "order": [[2, 'desc']],
        "iDisplayLength": 20,
    });
    
    $("#printPDRLedger").on("click", function() {
      var account_no = $(this).attr("account_no");

      window.open("extensions/tcpdf/pdf/print_branch_ledger.php?account_no="+account_no, '_blank');
    
    });

    //03-14-24//
    
    $('#addpdrcoltrans .modal-body').on("keyup", "#new_account_no", function() {
      var id = document.getElementById('new_account_no');
      var account_no = id.value;

      $.ajax({
        url: 'API/checkIdExists.ajax.php',
        data: {
          account_no: account_no
        },
        type: "GET",
        success: function(data) {
          if (data === 'used' || account_no === "") {
            $("#message1").removeAttr('hidden'); // Show message1 because the condition is true
            $("#message2").attr('hidden', true); // Ensure message2 is hidden
            $("#addNewPDRCollRecord").attr('disabled', true);
          } else {
            $("#message1").attr('hidden', true); // Hide message1 because the condition is false
            $("#message2").removeAttr('hidden'); // Show message2
            $("#addNewPDRCollRecord").attr('disabled', false);
          }
        },
        error: function() {
            swal.close();
            alert('Error fetching data');
        }
      });

    })
    
      // April 20 2024 //

  $('#addpdrcoltrans .modal-body').on("change", "#auto_fill_id", function() {
    if (this.checked) {
        var new_branch_name = document.getElementById('new_branch_name');
        var branch_name = new_branch_name.value;

        $.ajax({
            url: 'API/getOLRIDSeries.ajax.php',
            data: {
                branch_name: branch_name
            },
            type: "GET",
            success: function(data) {
                $("#new_account_no").val(data);
                $("#new_account_no").attr('readonly', true);
                $("#message1").attr('hidden', true); // Hide message1 because the condition is false
                $("#message2").removeAttr('hidden'); // Show message2
                $("#addNewPDRCollRecord").attr('disabled', false);
            },
            error: function() {
                swal.close();
                alert('Error fetching data');
            }
        });
    } else {
        // Clear the value of new_account_no when the checkbox is unchecked
        $("#new_account_no").val("");
        $("#new_account_no").attr('readonly', false);
        $("#message1").removeAttr('hidden'); // Show message1 because the condition is true
        $("#message2").attr('hidden', true); // Ensure message2 is hidden
        $("#addNewPDRCollRecord").attr('disabled', true);
    }
});

})