
$(".generateSalesPerformanceReport").on("click", function(){
    var input1 = document.getElementById('monthEnd');
    var monthEnd = input1.value;

    // Populate the input fields in the modal with these values
    $("#dateFrom_clone").val(monthEnd);

    var print = document.getElementById("printSalesPerformanceReport");
          print.hidden = true;

      // Selected date range is valid within the same week
      $(".showTableSalesPerformanceReport").empty();


      if (monthEnd === "") {

        swal({
          type: "warning",
          title: "Please select date first",
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
        url: 'ajax/operationSL.ajax.php',
        data: {
            monthEnd: monthEnd,
        },
        dataType: 'json',
        success: function(data) {
          // Close loading screen
          swal.close();

          $.each(data, function(index, item) {
            var card = item.card;
            $('.showTableSalesPerformanceReport').append(card);
          });

          var print = document.getElementById("printSalesPerformanceReport");
          print.hidden = false;
        },
        error: function() {
          // Close loading screen
          swal.close();
          alert('Error fetching data');
        }
      });
        
      }

      

});






// $(".printSalesPerformanceReport").on("click", function(){
//   var input1 = document.getElementById('monthEnd');
//   var monthEnd = input1.value;

//   window.open("extensions/tcpdf/pdf/adminSalesPerformance.php?monthEnd="+monthEnd);

// })

$('.salesPerformanceTable').DataTable({
  "ajax": "ajax/branchSP.ajax.php", 
  "deferRender": true,
  "retrieve": true,
  "processing": true
});

$('.salesRepresentativeTable').DataTable({
  "ajax": "ajax/operationSRList.ajax.php", 
  "deferRender": true,
  "retrieve": true,
  "processing": true
});



$(".salesPerformanceTable").on("click", "tbody .btnEditAccountPen", function(){

  var id = $(this).attr("id");

$('#editPensionerAccounts .modal-body').empty();

    $.ajax({
      url: 'ajax/editBranchSP.ajax.php',
      data: {
        id: id
      },
      dataType: 'json',
      success: function(data) {
        
          $.each(data, function(index, item) {
              var card = item.card;
              $('#editPensionerAccounts .modal-body').append(card);
          });
          $('#editPensionerAccounts').modal('show');

      },
      error: function() {
          alert('Error fetching data');
      }
  });

}) 

$(".salesRepresentativeTable").on("click", "tbody .btnEditSalesRep", function(){

  var id = $(this).attr("id");

$('#editPensionerAccounts .modal-body').empty();

    $.ajax({
      url: 'ajax/editSalesRep.ajax.php',
      data: {
        id: id
      },
      dataType: 'json',
      success: function(data) {
        
          $.each(data, function(index, item) {
              var card = item.card;
              $('#editPensionerAccounts .modal-body').append(card);
          });
          $('#editPensionerAccounts').modal('show');

      },
      error: function() {
          alert('Error fetching data');
      }
  });

}) 

$(".salesRepresentativeTable").on("click", "tbody .btnDeleteSalesRep", function(){
  var id = $(this).attr("id");
 

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
            window.location = "index.php?route=operationSPList&id="+id;
        }
  })
})

$(".salesPerformanceTable").on("click", "tbody .btnDeleteAccountPen", function(){
  var id = $(this).attr("id");
 

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
            window.location = "index.php?route=branchSP&id="+id;
        }
  })
})

  
 $(".adminGeneratePensionerReport").on("click", function(){
      var input = document.getElementById('penDateFrom');
      var penDateFrom = input.value;
      var input_1 = document.getElementById('penDateTo');
      var penDateTo = input_1.value;;
      var input_3 = document.getElementById('branchName');
      var branchName = input_3.value;

      // Populate the input fields in the modal with these values
      $("#penDateFrom_clone").val(penDateFrom);
      $("#penDateTo_clone").val(penDateTo);
      $("#branchName_clone").val(branchName);
  
      const start = new Date(penDateFrom);
      const end = new Date(penDateTo);
     
       // Calculate the difference in milliseconds
       const differenceInMilliseconds = Math.abs(end - start);
  
       const days = Math.floor(differenceInMilliseconds / (1000 * 60 * 60 * 24));

       if (penDateFrom === "" || penDateTo === "" || days > 4 || branchName === "") {
  
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

        }else if(branchName === "") {
          
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
  
  
      
      }else{
        // Selected date range is valid within the same week
        $(".adminReportPensionerTable").empty();
  
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
          url: 'ajax/adminPensionerStatistics.ajax.php',
          data: {
            penDateFrom: penDateFrom,
            penDateTo: penDateTo,
            branchName: branchName
            },
            dataType: 'json',
           success: function(data) {
            // Close loading screen
            swal.close();
  
            $.each(data, function(index, item) {
              var card = item.card;
              $('.adminReportPensionerTable').append(card);
            });
  
            var print = document.getElementById("printAdminPensionerReport");
            print.hidden = false;
          },
          error: function() {
            // Close loading screen
            swal.close();
            alert('Error fetching data');
          }
        });
      }
})

//added 10-11-23//

$('.dailyAvailmentsTable').DataTable({
  "ajax": "ajax/branchDailyAvailments.ajax.php", 
  "deferRender": true,
  "retrieve": true,
  "processing": true,
  "order": [[2, 'desc']],
  "iDisplayLength": 25,

}); 

$(".dailyAvailmentsTable").on("click", "tbody .btnDeleteAPH", function(){
  var id = $(this).attr("id");
  var branch_name = $(this).attr("branch_name");
  var uploaded_date = $(this).attr("uploaded_date");

      swal({
        title: 'Are you sure you want to delete uploaded in '+uploaded_date+'?',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'cancel',
        confirmButtonText: 'Yes'
      }).then(function(result){
        if (result.value) {
          window.location = "index.php?route=branchAPH&id="+id+"&branch_name="+branch_name+"&uploaded_date="+uploaded_date;
        }
  })

})

$(".generateBranchDailyAvailments").on("click", function(){
  var input = document.getElementById('avl_date');
  var avl_date = input.value;

    if (avl_date === "") {

      swal({
        type: "warning",
        title: "Please select date first.",
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

    // Selected date range is valid within the same week
    $(".operationDailyAvailmentsTable").empty();

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
        url: 'ajax/operationDailyAvailmentsReport.ajax.php',
        data: {
          avl_date: avl_date
          },
          dataType: 'json',
        success: function(data) {
          // Close loading screen
          swal.close();

          $.each(data, function(index, item) {
            var card = item.card;
            $('.operationDailyAvailmentsTable').append(card);
          });

          var print = document.getElementById("branchDailyAvailmentsReport");
          print.hidden = false;
        },
        error: function() {
          // Close loading screen
          swal.close();
          alert('Error fetching data');
        }
      });
    }
   
})

$(".branchDailyAvailmentsReport").on("click", function(){
  var input1 = document.getElementById('avl_date');
  var avl_date = input1.value;

  window.open("extensions/tcpdf/pdf/print_operationDailyAvailmentReport.php?avl_date="+avl_date);

})

// added 10-20-23 //

$(".generateDates").on("click", function(){
  var input = document.getElementById('year');
  var year = input.value;

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
    type: "POST",
    url: 'ajax/fetch_year_data.ajax.php',
    data: { year: year },
    dataType: 'json',
    success: function(data) {
      // Assign data to HTML input fields
      document.getElementById("prev_year_dec").value = data.prev_year_dec;
      document.getElementById("cur_year_jan").value = data.cur_year_jan;
      document.getElementById("cur_year_feb").value = data.cur_year_feb;
      document.getElementById("cur_year_mar").value = data.cur_year_mar;
      document.getElementById("cur_year_apr").value = data.cur_year_apr;
      document.getElementById("cur_year_may").value = data.cur_year_may;
      document.getElementById("cur_year_jun").value = data.cur_year_jun;
      document.getElementById("cur_year_jul").value = data.cur_year_jul;
      document.getElementById("cur_year_aug").value = data.cur_year_aug;
      document.getElementById("cur_year_sep").value = data.cur_year_sep;
      document.getElementById("cur_year_oct").value = data.cur_year_oct;
      document.getElementById("cur_year_nov").value = data.cur_year_nov;
      document.getElementById("cur_year_dec").value = data.cur_year_dec;

      // Close the loading dialog
      swal.close();
    },
    error: function() {
      // Handle errors
      swal.close();
      swal("Error", "Failed to fetch year data", "error");
    }
  });
});


$(".generateAvailmentsEveryCutOffReport").on("click", function(){

    var input_1 = document.getElementById('prev_year_dec');
    var prev_year_dec = input_1.value;
    var input_2 = document.getElementById('cur_year_jan');
    var cur_year_jan = input_2.value;
    var input_3 = document.getElementById('cur_year_feb');
    var cur_year_feb = input_3.value;
    var input_4 = document.getElementById('cur_year_mar');
    var cur_year_mar = input_4.value;
    var input_5 = document.getElementById('cur_year_apr');
    var cur_year_apr = input_5.value;
    var input_6 = document.getElementById('cur_year_may');
    var cur_year_may = input_6.value;
    var input_7 = document.getElementById('cur_year_jun');
    var cur_year_jun = input_7.value;
    var input_8 = document.getElementById('cur_year_jul');
    var cur_year_jul = input_8.value;
    var input_9 = document.getElementById('cur_year_aug');
    var cur_year_aug = input_9.value;
    var input_10 = document.getElementById('cur_year_sep');
    var cur_year_sep = input_10.value;
    var input_11 = document.getElementById('cur_year_oct');
    var cur_year_oct = input_11.value;
    var input_12 = document.getElementById('cur_year_nov');
    var cur_year_nov = input_12.value;
    var input_13 = document.getElementById('cur_year_dec');
    var cur_year_dec = input_13.value;

    var input_14 = document.getElementById('year');
    var year = input_14.value;

    if (prev_year_dec === "") {

      swal({
        type: "warning",
        title: "Please insure that you have selected a year.",
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

    $(".availmentsEveryCutOffReportTable").empty();

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
        url: 'ajax/operationAvailmentsEveryCutOffReport.ajax.php',
        data: {
          prev_year_dec: prev_year_dec,
          cur_year_jan: cur_year_jan,
          cur_year_feb: cur_year_feb,
          cur_year_mar: cur_year_mar,
          cur_year_apr: cur_year_apr,
          cur_year_may: cur_year_may,
          cur_year_jun: cur_year_jun,
          cur_year_jul: cur_year_jul,
          cur_year_aug: cur_year_aug,
          cur_year_sep: cur_year_sep,
          cur_year_oct: cur_year_oct,
          cur_year_nov: cur_year_nov,
          cur_year_dec: cur_year_dec,
          year: year
          },
          dataType: 'json',
        success: function(data) {
          // Close loading screen
          swal.close();

          $.each(data, function(index, item) {
            var card = item.card;
            $('.availmentsEveryCutOffReportTable').append(card);
          });

          var print = document.getElementById("printAvailmentsEveryCutOffReport");
          print.hidden = false;
        },
        error: function() {
          // Close loading screen
          swal.close();
          alert('Error fetching data');
        }
      });
    }
   
})

$(".printAvailmentsEveryCutOffReport").on("click", function(){
  var input1 = document.getElementById('year');
  var year = input1.value;

  window.open("extensions/tcpdf/pdf/print_operationAvailmentsEveryCutOffReport.php?year="+year);

})



































