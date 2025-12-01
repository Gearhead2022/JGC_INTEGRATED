
// $(document).ready(function() {
// $(".generatePensionerReport").on("click", function(){
//     var input = document.getElementById('penDateFrom');
//     var penDateFrom = input.value;
//     var input_1 = document.getElementById('penDateTo');
//     var penDateTo = input_1.value;
//     var input_2 = document.getElementById('penBegBal');
//     var penBegBal = input_2.value;

//     const start = new Date(penDateFrom);
//     const end = new Date(penDateTo);
   
//      // Calculate the difference in milliseconds
//      const differenceInMilliseconds = Math.abs(end - start);

//      const days = Math.floor(differenceInMilliseconds / (1000 * 60 * 60 * 24));

//      if (penDateFrom === "" || penDateTo === "" || penBegBal === "" || days > 4) {

//       swal({
//         type: "warning",
//         title: "Please select date first",
//         showCancelButton: true,
//         confirmButtonColor: '#3085d6',
//         cancelButtonColor: '#d33',
//         cancelButtonText: 'cancel',
//         confirmButtonText: 'OK'
//       }).then(function(result){
//         if (result.value) {
//             window.location = "";
//         }
       
//       });
      
//      } else {

//       $(".reportPensionerTable").empty();

//       var element = document.getElementById("showTablePensionReport");
  
//       // Set the hidden attribute to false to show the element
//       element.hidden = false;
     
  
//        // Display loading screen
//        swal({
//         title: "Generating",
//         text: "Please wait...",
//         allowOutsideClick: false,
//         allowEscapeKey: false,
//         onOpen: () => {
//           swal.showLoading();
//         }
//       });
//       $.ajax({
//           url: 'ajax/pensioner.ajax.php',
//           data: {
//             penDateFrom: penDateFrom,
//             penDateTo: penDateTo,
//             penBegBal: penBegBal
//             },
//             dataType: 'json',
//             success: function(data) {

//               try {
  
//                 var selectedDate = new Date(penDateFrom);
//                 var selectedDateEnd = new Date(penDateTo);
//                 var selectedpenBegBal = new Date(penBegBal);
                
//                 var dateRange = [];
//                 var currentDate = new Date(selectedDate); // Initialize currentDate
                
//                 while (currentDate <= selectedDateEnd) {
//                   dateRange.push(currentDate.toISOString().substring(0, 10)); // Format: 'YYYY-MM-DD'
//                   currentDate.setDate(currentDate.getDate() + 1); // Update currentDate
//                 }
//                 let day1 = dateRange[0] ? new Date(dateRange[0]).toLocaleDateString('en-US', { month: 'short', day: 'numeric' }) : null;
//                 let day2 = dateRange[1] ? new Date(dateRange[1]).toLocaleDateString('en-US', { month: 'short', day: 'numeric' }) : null;
//                 let day3 = dateRange[2] ? new Date(dateRange[2]).toLocaleDateString('en-US', { month: 'short', day: 'numeric' }) : null;
//                 let day4 = dateRange[3] ? new Date(dateRange[3]).toLocaleDateString('en-US', { month: 'short', day: 'numeric' }) : null;
//                 let day5 = dateRange[4] ? new Date(dateRange[4]).toLocaleDateString('en-US', { month: 'short', day: 'numeric' }) : null;
                
//                 let dayBegBal = selectedpenBegBal ? new Date(selectedpenBegBal).toLocaleDateString('en-US', { month: 'short', year: 'numeric' }) : null;
                
//                 $("#header-date-1").text(day1);
//                 $("#header-date-2").text(day2);
//                 $("#header-date-3").text(day3);
//                 $("#header-date-4").text(day4);
//                 $("#header-date-5").text(day5);

//                 $("#header-date-6").text('BEG ' + dayBegBal);
                
          
//               // Close loading screen
//               swal.close();
//           } catch (error) {
//               console.error('Error parsing response:', error);
//               swal({
//                   title: "Error",
//                   text: "An error occurred while processing the response.",
//                   icon: "error"
//               });
//           }

//               swal.close();

//               $('.reportPensionerTable').html(data.card);
             
//               var element = document.getElementById("showTablePensionReport");
             
//               element.hidden = false;
              
//         },
//         error: function() {
//           // Close loading screen
//     swal.close();
//             alert('Error fetching data');
//         }
//     });
      
//      }
     
//   })




//   $(".generateELCPensionerReport").on("click", function(){
//       var input = document.getElementById('penDateFrom');
//       var penDateFrom = input.value;
//       var input_1 = document.getElementById('penDateTo');
//       var penDateTo = input_1.value;
//       var input_2 = document.getElementById('penBegBal');
//       var penBegBal = input_2.value;
  
//       const start = new Date(penDateFrom);
//       const end = new Date(penDateTo);
     
//        // Calculate the difference in milliseconds
//        const differenceInMilliseconds = Math.abs(end - start);
  
//        const days = Math.floor(differenceInMilliseconds / (1000 * 60 * 60 * 24));
  
//        if (penDateFrom === "" || penDateTo === "" || penBegBal === "" || days > 4) {
  
//         swal({
//           type: "warning",
//           title: "Please select date first",
//           showCancelButton: true,
//           confirmButtonColor: '#3085d6',
//           cancelButtonColor: '#d33',
//           cancelButtonText: 'cancel',
//           confirmButtonText: 'OK'
//         }).then(function(result){
//           if (result.value) {
//               window.location = "";
//           }
         
//         });
        
//        } else {
  
//         $(".reportPensionerTable").empty();
  
//         var element = document.getElementById("showTablePensionReport");
    
//         // Set the hidden attribute to false to show the element
//         element.hidden = false;
       
    
//          // Display loading screen
//          swal({
//           title: "Generating",
//           text: "Please wait...",
//           allowOutsideClick: false,
//           allowEscapeKey: false,
//           onOpen: () => {
//             swal.showLoading();
//           }
//         });
//         $.ajax({
//             url: 'ajax/elcpensioner.ajax.php',
//             data: {
//               penDateFrom: penDateFrom,
//               penDateTo: penDateTo,
//               penBegBal: penBegBal
//               },
//               dataType: 'json',
//               success: function(data) {
  
//                 try {
    
//                   var selectedDate = new Date(penDateFrom);
//                   var selectedDateEnd = new Date(penDateTo);
//                   var selectedpenBegBal = new Date(penBegBal);
                  
//                   var dateRange = [];
//                   var currentDate = new Date(selectedDate); // Initialize currentDate
                  
//                   while (currentDate <= selectedDateEnd) {
//                     dateRange.push(currentDate.toISOString().substring(0, 10)); // Format: 'YYYY-MM-DD'
//                     currentDate.setDate(currentDate.getDate() + 1); // Update currentDate
//                   }
//                   let day1 = dateRange[0] ? new Date(dateRange[0]).toLocaleDateString('en-US', { month: 'short', day: 'numeric' }) : null;
//                   let day2 = dateRange[1] ? new Date(dateRange[1]).toLocaleDateString('en-US', { month: 'short', day: 'numeric' }) : null;
//                   let day3 = dateRange[2] ? new Date(dateRange[2]).toLocaleDateString('en-US', { month: 'short', day: 'numeric' }) : null;
//                   let day4 = dateRange[3] ? new Date(dateRange[3]).toLocaleDateString('en-US', { month: 'short', day: 'numeric' }) : null;
//                   let day5 = dateRange[4] ? new Date(dateRange[4]).toLocaleDateString('en-US', { month: 'short', day: 'numeric' }) : null;
                  
//                   let dayBegBal = selectedpenBegBal ? new Date(selectedpenBegBal).toLocaleDateString('en-US', { month: 'short', year: 'numeric' }) : null;
                  
//                   $("#header-date-1").text(day1);
//                   $("#header-date-2").text(day2);
//                   $("#header-date-3").text(day3);
//                   $("#header-date-4").text(day4);
//                   $("#header-date-5").text(day5);
  
//                   $("#header-date-6").text('BEG ' + dayBegBal);
                  
            
//                 // Close loading screen
//                 swal.close();
//             } catch (error) {
//                 console.error('Error parsing response:', error);
//                 swal({
//                     title: "Error",
//                     text: "An error occurred while processing the response.",
//                     icon: "error"
//                 });
//             }
  
//                 swal.close();
  
//                 $('.reportPensionerTable').html(data.card);
               
//                 var element = document.getElementById("showTablePensionReport");
               
//                 element.hidden = false;
                
//           },
//           error: function() {
//             // Close loading screen
//       swal.close();
//               alert('Error fetching data');
//           }
//       });
        
//        }
       
//     })
 

//   $(".adminGeneratePensionerReport").on("click", function(){
//     var input = document.getElementById('penDateFrom');
//     var penDateFrom = input.value;
//     var input_1 = document.getElementById('penDateTo');
//     var penDateTo = input_1.value;
//     var input_2 = document.getElementById('penBegBal');
//     var penBegBal = input_2.value;

//     const start = new Date(penDateFrom);
//     const end = new Date(penDateTo);
   
//      // Calculate the difference in milliseconds
//      const differenceInMilliseconds = Math.abs(end - start);

//      const days = Math.floor(differenceInMilliseconds / (1000 * 60 * 60 * 24));

//      if (penDateFrom === "" || penDateTo === "" || penBegBal === "" || days > 4) {

//       swal({
//         type: "warning",
//         title: "Please select date first",
//         showCancelButton: true,
//         confirmButtonColor: '#3085d6',
//         cancelButtonColor: '#d33',
//         cancelButtonText: 'cancel',
//         confirmButtonText: 'OK'
//       }).then(function(result){
//         if (result.value) {
//             window.location = "";
//         }
       
//       });
      
//      } else {

//       $(".adminReportPensionerTable").empty();

//       var element = document.getElementById("adminShowTablePensionReport");

//       var print = document.getElementById("printAdminPensionerReport");
  
//       // Set the hidden attribute to false to show the element
//       element.hidden = false;
//       print.hidden = false;
  
//        // Display loading screen
//        swal({
//         title: "Generating",
//         text: "Please wait...",
//         allowOutsideClick: false,
//         allowEscapeKey: false,
//         onOpen: () => {
//           swal.showLoading();
//         }
//       });
//       $.ajax({
//           url: 'ajax/adminPensionerStatistics.ajax.php',
//           data: {
//             penDateFrom: penDateFrom,
//             penDateTo: penDateTo,
//             penBegBal: penBegBal
//             },
//             dataType: 'json',
//             success: function(data) {

//               try {
  
//                 var selectedDate = new Date(penDateFrom);
//                 var selectedDateEnd = new Date(penDateTo);
//                 var selectedpenBegBal = new Date(penBegBal);
                
//                 var dateRange = [];
//                 var currentDate = new Date(selectedDate); // Initialize currentDate
                
//                 while (currentDate <= selectedDateEnd) {
//                   dateRange.push(currentDate.toISOString().substring(0, 10)); // Format: 'YYYY-MM-DD'
//                   currentDate.setDate(currentDate.getDate() + 1); // Update currentDate
//                 }
//                 let day1 = dateRange[0] ? new Date(dateRange[0]).toLocaleDateString('en-US', { month: 'short', day: 'numeric' }) : null;
//                 let day2 = dateRange[1] ? new Date(dateRange[1]).toLocaleDateString('en-US', { month: 'short', day: 'numeric' }) : null;
//                 let day3 = dateRange[2] ? new Date(dateRange[2]).toLocaleDateString('en-US', { month: 'short', day: 'numeric' }) : null;
//                 let day4 = dateRange[3] ? new Date(dateRange[3]).toLocaleDateString('en-US', { month: 'short', day: 'numeric' }) : null;
//                 let day5 = dateRange[4] ? new Date(dateRange[4]).toLocaleDateString('en-US', { month: 'short', day: 'numeric' }) : null;
                
//                 let dayBegBal = selectedpenBegBal ? new Date(selectedpenBegBal).toLocaleDateString('en-US', { month: 'short', year: 'numeric' }) : null;
                
//                 $("#header-date-1").text(day1);
//                 $("#header-date-2").text(day2);
//                 $("#header-date-3").text(day3);
//                 $("#header-date-4").text(day4);
//                 $("#header-date-5").text(day5);

//                 $("#header-date-6").text('BEG ' + dayBegBal);
                
          
//               // Close loading screen
//               swal.close();
//           } catch (error) {
//               console.error('Error parsing response:', error);
//               swal({
//                   title: "Error",
//                   text: "An error occurred while processing the response.",
//                   icon: "error"
//               });
//           }

//               swal.close();

//               $.each(data, function(index, item) {
//                 var card = item.card;
//                 $('.adminReportPensionerTable').append(card);
//             });
             
//               var element = document.getElementById("adminShowTablePensionReport");  
//               var print = document.getElementById("printAdminPensionerReport");
          
//               // Set the hidden attribute to false to show the element
//               element.hidden = false;
//               print.hidden = false;
              
//         },
//         error: function() {
//           // Close loading screen
//     swal.close();
//             alert('Error fetching data');
//         }
//     });
      
//      }
     
//   })

//   $(".printAdminPensionerReport").on("click", function(){
//     var input1 = document.getElementById('penDateFrom');
//     var penDateFrom = input1.value;
//     var input2 = document.getElementById('penDateTo');
//     var penDateTo = input2.value;
//     var input3 = document.getElementById('penBegBal');
//     var penBegBal = input3.value;


//     window.open("extensions/tcpdf/pdf/adminPensionerReport.php?penDateFrom="+penDateFrom+"&penDateTo="+penDateTo+"&penBegBal="+penBegBal);
  
//   })



// })


  
  
    
    
  
  



//monthly agents











// monthly agents

$('.monthlyAgentsTable').DataTable({
  "ajax": "ajax/monthlyagents.ajax.php", 
  "deferRender": true,
  "retrieve": true,
  "processing": true,
  "order": [[0, 'desc']]
});



$('.monthlyAgentsBegTable').DataTable({
  "ajax": "ajax/monthlyagents.ajax.php", 
  "deferRender": true,
  "retrieve": true,
  "processing": true
});

 

// admin









$(".generateMonthlyAgentReport").on("click",function(){
  var input1 = document.getElementById('mdate');
  var mdate = input1.value;

  $('#mdate_clone').val(mdate);
 
  swal({
    title: "Generating",
    text: "Please wait...",
    allowOutsideClick: false,
    allowEscapeKey: false,
    onOpen: () => {
      swal.showLoading();
    }
  });

  $.ajax({
    url: 'ajax/monthlyagentAdmin.ajax.php',
    data: {

      mdate: mdate,

    },
    dataType: 'json',
    success: function(data) {
      swal.close();
      // Close loading screen
      $('.showTableMonthlyAgentReport').html(data.card);
      // var element = document.getElementById("monthlyagentTable");
      // element.hidden = false;
      var input1 = document.getElementById('printMonthlyAgent');
      input1.hidden = false;
    },
    error: function() {
      // Close loading screen
      swal.close();

      alert('Error fetching data');
    }
  });
 
})






// print pdf

$(".printMonthlyAgent").on("click", function(){
  var input1 = document.getElementById('mdate');
  var mdate = input1.value;

  window.open("extensions/tcpdf/pdf/print_monthly_agent_prod.php?mdate="+mdate);

})


// delet button monthly agent runner production

$(".monthlyAgentsTable").on("click", "tbody .btnDeleteClient", function(){
  var id = $(this).attr("id");
  // var type = $(this).attr("type");
  swal({
        title: 'Do you want to delete this record?',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'cancel',
        confirmButtonText: 'Yes'
      }).then(function(result){
        if (result.value) {
            window.location = "index.php?route=monthlyagent&id="+id;
        }
  }) 
})





// edit monthly agent production 
$(".monthlyAgentsTable").on("click", "tbody .btnEditClient", function(){
  var id = $(this).attr("id");
  
  $('#editMonthlyAgentModal .modal-body').empty();

      $.ajax({
        url: 'ajax/monthlyAgentEdit.ajax.php',
        data: {
          id: id
        
        },
        dataType: 'json',
        success: function(data) {
          
            $.each(data, function(index, item) {
                var card = item.card;
                $('#editMonthlyAgentModal .modal-body').append(card);
            });
            $('#editMonthlyAgentModal').modal('show');

        },
        error: function() {
            alert('Error fetching data');
        }
    });
 
}) 

// new added by john


$(document).ready(function() {
  $(".generatePensionerReport").on("click", function(){
      var input = document.getElementById('penDateFrom');
      var penDateFrom = input.value;
      var input_1 = document.getElementById('penDateTo');
      var penDateTo = input_1.value;
  
      $("#header-date-1, #header-date-2, #header-date-3, #header-date-4, #header-date-5").removeAttr("hidden").text(""); // Reset text content to prevent old values from lingering
  
      $("#day_one, #day_two, #day_three, #day_four, #day_five").removeAttr("hidden");
  
      var branchName = $('#branchNameElement').attr('data-branch');
      var type = $('#userType').attr('data-type');
  
      const start = new Date(penDateFrom);
      const end = new Date(penDateTo);
     
       // Calculate the difference in milliseconds
       const differenceInMilliseconds = Math.abs(end - start);
  
       const days = Math.floor(differenceInMilliseconds / (1000 * 60 * 60 * 24));
  
       if (penDateFrom === "" || penDateTo === "" || days > 4) {
  
        if (penDateFrom === "") {
  
          swal({
            type: "warning",
            title: "Please select date from first.",
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'cancel',
            confirmButtonText: 'OK'
          }).then(function(result){
            if (result.value) {
                window.location = "";
            }
           
          });
          
        } else if(penDateTo === "") {
          
          swal({
            type: "warning",
            title: "Please select date to first.",
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'cancel',
            confirmButtonText: 'OK'
          }).then(function(result){
            if (result.value) {
                window.location = "";
            }
           
          });
          
  
        } else{
  
          swal({
            type: "warning",
            title: "Must select maximum of 5 days.",
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'cancel',
            confirmButtonText: 'OK'
          }).then(function(result){
            if (result.value) {
                window.location = "";
            }
           
          });
  
        }
  
       } else {
  
        $(".reportPensionerTable").empty();
  
        var element = document.getElementById("showTablePensionReport");
    
        // Set the hidden attribute to false to show the element
        element.hidden = false;
       
    
         // Display loading screen
         swal({
          title: "Generating",
          text: "Please wait...",
          allowOutsideClick: false,
          allowEscapeKey: false,
          onOpen: () => {
            swal.showLoading();
          }
        });
  
        $.ajax({
            url: 'ajax/branchpensioner.ajax.php',
            data: {
              penDateFrom: penDateFrom,
              penDateTo: penDateTo
              },
              dataType: 'json',
              success: function(data) {
  
                try {
    
                  var selectedDate = new Date(penDateFrom);
                  var selectedDateEnd = new Date(penDateTo);
                  
                  var dateRange = [];
                  var currentDate = new Date(selectedDate); // Initialize currentDate
                  
                  while (currentDate <= selectedDateEnd) {
                    dateRange.push(currentDate.toISOString().substring(0, 10)); // Format: 'YYYY-MM-DD'
                    currentDate.setDate(currentDate.getDate() + 1); // Update currentDate
                  }
                  let day1 = dateRange[0] ? new Date(dateRange[0]).toLocaleDateString('en-US', { month: 'short', day: 'numeric' }) : null;
                  let day2 = dateRange[1] ? new Date(dateRange[1]).toLocaleDateString('en-US', { month: 'short', day: 'numeric' }) : null;
                  let day3 = dateRange[2] ? new Date(dateRange[2]).toLocaleDateString('en-US', { month: 'short', day: 'numeric' }) : null;
                  let day4 = dateRange[3] ? new Date(dateRange[3]).toLocaleDateString('en-US', { month: 'short', day: 'numeric' }) : null;
                  let day5 = dateRange[4] ? new Date(dateRange[4]).toLocaleDateString('en-US', { month: 'short', day: 'numeric' }) : null;
                  
                  var previousYear = selectedDate.getFullYear() - 1;
                  let dayBegBal = previousYear ? new Date(previousYear, 11, 31).toLocaleDateString('en-US', { month: 'short', year: 'numeric' }) : null;
                  
                  updateDateElement("#header-date-1", day1, "#day_one", "#d_i1", "#d_i2", "#d_i3");
                  updateDateElement("#header-date-2", day2, "#day_two", "#d_i4", "#d_i5", "#d_i6");
                  updateDateElement("#header-date-3", day3, "#day_three", "#d_i7", "#d_i8", "#d_i9");
                  updateDateElement("#header-date-4", day4, "#day_four", "#d_i10", "#d_i11", "#d_i12");
                  updateDateElement("#header-date-5", day5, "#day_five", "#d_i13", "#d_i14", "#d_i15");
  
                  $("#header-date-6").text('BEG ' + dayBegBal);
                  
            
                // Close loading screen
                swal.close();
            } catch (error) {
                console.error('Error parsing response:', error);
                swal({
                    title: "Error",
                    text: "An error occurred while processing the response.",
                    icon: "error"
                });
            }
  
                swal.close();
  
                $('.reportPensionerTable').html(data.card);
               
                var element = document.getElementById("showTablePensionReport");
               
                element.hidden = false;
                
          },
          error: function() {
            // Close loading screen
      swal.close();
              alert('Error fetching data');
          }
      });
        
       }
       
    })
  
  
    function updateDateElement(headerSelector, dayValue, daySelector, el_one, el_two, el_three) {
      if (!dayValue) {
          $(headerSelector).attr("hidden", true);
          $(daySelector).attr("hidden", true);
          $(el_one).attr("hidden", true);
          $(el_two).attr("hidden", true);
          $(el_three).attr("hidden", true);
  
      } else {
          $(headerSelector).text(dayValue);
          $(daySelector).removeAttr("hidden");
          $(el_one).removeAttr("hidden");
          $(el_two).removeAttr("hidden");
          $(el_three).removeAttr("hidden");
    
      }
  }
  
  
    $(".printAdminPensionerReport").on("click", function(){
      var input1 = document.getElementById('penDateFrom');
      var penDateFrom = input1.value;
      var input2 = document.getElementById('penDateTo');
      var penDateTo = input2.value;
      var input4 = document.getElementById('branchName');
      var branchName = input4.value;
  
  
      window.open("extensions/tcpdf/pdf/adminPensionerReport.php?penDateFrom="+penDateFrom+"&penDateTo="+penDateTo+"&branchName="+branchName);
    
    })
  
  
  
  })

  
$('.branchPensionerListTable').DataTable({
  "ajax": "ajax/branchPensionerList.ajax.php", 
  "deferRender": true,
  "retrieve": true,
  "processing": true,
  "order": [[4, 'desc']],

});

$(".branchPensionerListTable").on("click", "tbody .btnEditPenAccnts", function(){

  var id = $(this).attr("id");

$('#editBranchPensionerAccounts .modal-body').empty();

    $.ajax({
      url: 'ajax/editBranchPensionerList.ajax.php',
      data: {
        id: id
      },
      dataType: 'json',
      success: function(data) {
        
          $.each(data, function(index, item) {
              var card = item.card;
              $('#editBranchPensionerAccounts .modal-body').append(card);
          });
          $('#editBranchPensionerAccounts').modal('show');

      },
      error: function() {
          alert('Error fetching data');
      }
  });

}) 

$(".branchPensionerListTable").on("click", "tbody .btnDeletePenAccnts", function(){
  var id = $(this).attr("id");
  var branch_name = $(this).attr("branch_name");
 
  swal({
        title: 'Do you want to delete this record?',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'cancel',
        confirmButtonText: 'Yes'
      }).then(function(result){
        if (result.value) {
            window.location = "index.php?route=branchPensionerList&id="+id+"&branch_name="+branch_name;
        }
  })
})

//added

// $(".generateBranchSalesPerformanceReport").on("click", function(){
//   var input1 = document.getElementById('monthEnd');
//   var monthEnd = input1.value;

//   // Populate the input fields in the modal with these values
//   $("#dateFrom_clone").val(monthEnd);

//     // Selected date range is valid within the same week
//     $(".showTableBranchSalesPerformanceReport").empty();

//     if (monthEnd === "") {

//       swal({
//         type: "warning",
//         title: "Please select month first.",
//         showCancelButton: true,
//         confirmButtonColor: '#3085d6',
//         cancelButtonColor: '#d33',
//         cancelButtonText: 'cancel',
//         confirmButtonText: 'OK'
//       }).then(function(result){
//         if (result.value) {
//             window.location = "";
//         }
       
//       });
      
//     } else {

//       // Display loading screen
//     swal({
//       title: "Generating",
//       text: "Please wait...",
//       allowOutsideClick: false,
//       allowEscapeKey: false,
//       onOpen: () => {
//         swal.showLoading();
//       }
//     });

//     $.ajax({
//       url: 'ajax/branchSP.ajax.php',
//       data: {
//           monthEnd: monthEnd,
//       },
//       dataType: 'json',
//       success: function(data) {
//         // Close loading screen
//         swal.close();

//         $.each(data, function(index, item) {
//           var card = item.card;
//           $('.showTableBranchSalesPerformanceReport').append(card);
//         });

//       },
//       error: function() {
//         // Close loading screen
//         swal.close();
//         alert('Error fetching data');
//       }
//     });
      
//     }

// });

$(".generateBranchSalesPerformanceReport").on("click", function(){
  var input1 = document.getElementById('monthEnd');
  var monthEnd = input1.value;

   if (monthEnd === "") {

      swal({
        type: "warning",
        title: "Please select area first.",
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'cancel',
        confirmButtonText: 'OK'
      }).then(function(result){
        if (result.value) {
            window.location = "";
        }
       
      });
      
   } else {

    $(".reportableBranchSalesPerformance").empty();

    var element = document.getElementById("showTableBranchSalesPerformanceReport");


    // Set the hidden attribute to false to show the element
    element.hidden = false;
    print.hidden = false;

     // Display loading screen
     swal({
      title: "Generating",
      text: "Please wait...",
      allowOutsideClick: false,
      allowEscapeKey: false,
      onOpen: () => {
        swal.showLoading();
      }
    });
    $.ajax({
        url: 'ajax/branchSP.ajax.php',
        data: {
          monthEnd: monthEnd
          },
          dataType: 'json',
          success: function(data) {

            var selectedDate = new Date(monthEnd);

            var previousMonthbegBal = new Date(selectedDate.getFullYear() -1, selectedDate.getMonth(), selectedDate.getDate());
            var monthNamesbegBal = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
            var monthNamebegBal = monthNamesbegBal[previousMonthbegBal.getMonth()];

            var selectedYearsbegBal = previousMonthbegBal.getFullYear().toString().substr(-2); 

            // $("#header-date-6").text('BEG ' + dayBegBal.replace(" ", ", "));

            $("#header-date-6").text('BEG DEC' + ', \'' + selectedYearsbegBal);
            
               // var previousMonth = new Date(selectedDate.getFullYear(), selectedDate.getMonth() - 1, selectedDate.getDate());
            // var monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
            // var monthName = monthNames[previousMonth.getMonth(), selectedDate.getFullYear().toLocaleString('en-US', { year: 'numeric' })];
            
            // $("#header-date-7").text('BEG ' + monthName[0] + monthName[1]);

            var previousMonth = new Date(selectedDate.getFullYear(), selectedDate.getMonth() - 1, selectedDate.getDate());
            var monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
            var monthName = monthNames[previousMonth.getMonth()];

            var selectedYears = selectedDate.getFullYear().toString().substr(-2); // Get the last 2 digits of the year

            $("#header-date-7").text('BEG ' + monthName + ', \'' + selectedYears);

            var previousMonth = new Date(selectedDate.getFullYear(), selectedDate.getMonth(), selectedDate.getDate());
            var monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
            var monthName1 = monthNames[previousMonth.getMonth()];

            var selectedYears2 = selectedDate.getFullYear().toString().substr(-2); // Get the last 2 digits of the year

            $("#header-date-8").text('BEG ' + monthName1 + ', \'' + selectedYears2);

            // var dayBegBalLastyearz = dayBegBal.replace(" ", ", '").getFullYear().substr(-2);
            

            // let dayBegBalLastyear = previousYear ? new Date(previousYear, 11, 31).toLocaleDateString('en-US', { month: 'short', year: '2-digit' }) : null;
            
            $("#header-date-9").html('GROSS IN' + '<br>' + 'Cumulative ' + '<br>' + ' DEC ' + ', \'' + selectedYearsbegBal + ' - ' + monthName1 + ' \'' + selectedYears2);

            $("#header-date-10").html('BRANCH NET' + '<br>' + monthName1 + ', \'' + selectedYears2);

            $("#header-date-11").html('BRANCH CUM NET' + '<br>' + ' DEC '+ ', \'' + selectedYearsbegBal + ' - ' + monthName1 + ' \'' + selectedYears2);

            swal.close();
            
            $.each(data, function(index, item) {
              var card = item.card;
              $('.reportableBranchSalesPerformance').append(card);
          });

            var element = document.getElementById("showTableBranchSalesPerformanceReport");  

            // Set the hidden attribute to false to show the element
            element.hidden = false;
            
      },
      error: function() {
        // Close loading screen
  swal.close();
          alert('Error fetching data');
      }
  });
    
   }
   
})


$('.showTableBranchAnnualTargetlist').DataTable({
  "ajax": "ajax/branchAnnualTargetList.ajax.php", 
  "deferRender": true,
  "retrieve": true,
  "processing": true
});

// new added 09-25-23//


$(".showTableBranchAnnualTargetlist").on("click", "tbody .btnEditAnnualTarget", function(){

  var id = $(this).attr("id");

$('#editAnnualTarget .modal-body').empty();

    $.ajax({
      url: 'ajax/editBranchAnnualTarget.ajax.php',
      data: {
        id: id
      },
      dataType: 'json',
      success: function(data) {
        
          $.each(data, function(index, item) {
              var card = item.card;
              $('#editAnnualTarget .modal-body').append(card);
          });
          $('#editAnnualTarget').modal('show');

      },
      error: function() {
          alert('Error fetching data');
      }
  });

}) 

$(".showTableBranchAnnualTargetlist").on("click", "tbody .btnDeleteAnnualTarget", function(){
  var id = $(this).attr("id");
  var branch_name = $(this).attr("id_delete");
 

  swal({
        title: 'Do you want to delete this record?',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'cancel',
        confirmButtonText: 'Yes'
      }).then(function(result){
        if (result.value) {
            window.location = "index.php?route=branchAnnualTargetList&id="+id+"&branch_name="+branch_name;
        }
  })
})

  
  



  
  

