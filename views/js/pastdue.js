$('.pastdueTable').DataTable({
    "ajax": "ajax/pastdue.ajax.php", 
    "deferRender": true,
    "retrieve": true,
    "processing": true,
    "order": [[1, 'asc']],
    "iDisplayLength": 25,

  }); 

  $('.targetTable').DataTable({
    "ajax": "ajax/target.ajax.php", 
    "deferRender": true,
    "retrieve": true,
    "processing": true,
    "order": [[1, 'asc']],
    "iDisplayLength": 25,

  }); 


  $('.ledgerTable').DataTable({
    "ajax": {
      "url": "ajax/ledger.ajax.php",
      "data": function (d) {
        d.idClient = $('.ledgerTable').attr("idClient");
      }
    },
    "deferRender": true,
    "retrieve": true,
    "processing": true,
    "order": [[1, 'asc']],
    "iDisplayLength": 25,

  }); 

  $('.pastdueledgerTable').DataTable({
    "ajax": "ajax/ledger.ajax.php",
    "deferRender": true,
    "retrieve": true,
    "processing": true,
    "order": [[1, 'asc']],
    "iDisplayLength": 25,

  })

  $(".pastdueTable").on("click", "tbody .btnEditClient", function(){
    var idClient = $(this).attr("idClient");
    var account_no = $(this).attr("account_no");
    window.location = "index.php?route=pastdueedit&idClient="+idClient+"&account_no="+account_no;
  })


  $(".pastdueTable").on("click", "tbody .btnViewPastDue", function(){
    var idClient = $(this).attr("idClient");
    window.location = "index.php?route=showpastdue&idClient="+idClient;
  })

  
  
  $(".viewLedger").on("click", function(){
    var idClient = $(this).attr("id");
    var account_no = $(this).attr("account_no");
    
    window.location = "index.php?route=ledger&idClient="+idClient+"&account_no="+account_no;



  })

  function goBack() {
    history.go(-1);
  }
  

  $(".ledgerTable").on("click", "tbody .btnEditClient", function(){
    var idClient = $(this).attr("idClient");
    var type = "editLedger"; 

    $('#editLedgerModal .modal-body').empty();

        $.ajax({
          url: 'ajax/pastdueedit.ajax.php',
          data: {
            idClient: idClient,
            type: type
          },
          dataType: 'json',
          success: function(data) {
            
              $.each(data, function(index, item) {
                  var card = item.card;
                  $('#editLedgerModal .modal-body').append(card);
              });
              $('#editLedgerModal').modal('show');
          },
          error: function() {
              alert('Error fetching data');
          }
      });
   
  }) 

  $(".pastdueTable").on("click", "tbody .btnDeleteClient", function(){
    var idClient = $(this).attr("idClient");
   
  
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
              window.location = "index.php?route=pastdue&idClient="+idClient;
          }
    })
  })


  
  $(".ledgerTable").on("click", "tbody .btnDeleteClient", function(){
    var idClient = $(this).attr("idClient");
    var id = $(this).attr("id");
    var account_no = $(this).attr("account_no");

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
              window.location = "index.php?route=ledger&idClient="+idClient+"&account_no="+account_no+"&id="+id;
          }
    })
  })
 
  
  $(".printLedger").on("click", function(){
    var account_no = $(this).attr("account_no");
    var branch_name = $(this).attr("branch_name");
    window.open("extensions/tcpdf/pdf/print_ledger.php?account_no="+account_no+"&branch_name="+branch_name);
  
  })


  $(".targetTable").on("click", "tbody .btnEditClient", function(){
    var idClient = $(this).attr("idClient");
    var type = "editTarget";
    $('#editTargetModal .modal-body').empty();

        $.ajax({
          url: 'ajax/pastdueedit.ajax.php',
          data: {
            idClient: idClient,
            type: type
          },
          dataType: 'json',
          success: function(data) {
            
              $.each(data, function(index, item) {
                  var card = item.card;
                  $('#editTargetModal .modal-body').append(card);
              });
              $('#editTargetModal').modal('show');

          },
          error: function() {
              alert('Error fetching data');
          }
      });
   
  }) 


  $(".targetTable").on("click", "tbody .btnDeleteClient", function(){
    var idClient = $(this).attr("idClient");
   

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
              window.location = "index.php?route=pastduetarget&idClient="+idClient;
          }
    })
  })


 
  $(".generateWeeklyReport").on("click", function(){
    var input1 = document.getElementById('weekto');
    var weekto = input1.value;
    var input2 = document.getElementById('weekfrom');
    var weekfrom = input2.value;

    var fromDate = new Date($('#weekfrom').val());
    var toDate = new Date($('#weekto').val());
    var firstDayOfWeek = new Date(fromDate);
    firstDayOfWeek.setDate(fromDate.getDate() - fromDate.getDay() + 1);
    var lastDayOfWeek = new Date(firstDayOfWeek);
    lastDayOfWeek.setDate(firstDayOfWeek.getDate() + 4);
    var diffInDays = Math.abs((toDate - fromDate) / (1000 * 60 * 60 * 24));
    
    if (fromDate.getDay() === 1 && toDate.getDay() === 5 && fromDate >= firstDayOfWeek && toDate <= lastDayOfWeek || diffInDays <= 4) {
      // Selected date range is valid within the same week
      $(".weeklyreportTable").empty();

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
        url: 'ajax/weeklyreport.ajax.php',
        data: {
          weekfrom: weekfrom,
          weekto: weekto
        },
        dataType: 'json',
        success: function(data) {
          // Close loading screen
          swal.close();

          $.each(data, function(index, item) {
            var card = item.card;
            $('.weeklyreportTable').append(card);
          });

          var print = document.getElementById("printWeeklyCollection");
          print.hidden = false;
        },
        error: function() {
          // Close loading screen
          swal.close();
          alert('Error fetching data');
        }
      });
    } else {
      // Invalid date range, show an error message or perform appropriate actions
      $(".weeklyreportTable").empty();
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

$(".printWeeklyCollection1").on("click", function(){
  var input2 = document.getElementById('weekfrom');
  var weekfrom = input2.value;
  var input1 = document.getElementById('weekto');
  var weekto = input1.value;
  var preparedBy1 = document.getElementById('preparedBy');
  var preparedBy = preparedBy1.value;
  var checkedBy1 = document.getElementById('checkedBy');
  var checkedBy = checkedBy1.value; 
  var position1 = document.getElementById('position');
  var position = position1.value; 
  window.open("extensions/tcpdf/pdf/weekly_collection_report.php?weekfrom="+weekfrom+"&weekto="+weekto+"&preparedBy="+ preparedBy + "&checkedBy="+ checkedBy+"&position="+position);
})


  $(".generateClassReport").on("click", function(){
    var input = document.getElementById('dateFrom');
    var dateFrom = input.value;
    var input1 = document.getElementById('dateTo');
    var dateTo = input1.value;
    var branch_name = document.getElementById('branch_name');
    var selectedbranch_name = branch_name.value;
    var selectClass = document.getElementById('class');
    var selectedClass = selectClass.value;

    $(".reportClassTable").empty();

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
             url: 'ajax/pastduereport.ajax.php',
             data: {
               dateFrom: dateFrom,
               dateTo: dateTo,
               branch_name: selectedbranch_name,
               class: selectedClass
             },
             dataType: 'json',
             success: function(data) {
               // Close loading screen
          swal.close();
                 // // Clear the button container
               
                 // var dateInWords = moment(new_date).format("MMMM DD, YYYY");
                 // $('#button-container').empty();
                 // $('#date-container').html("<div class='col-sm-1'><button class='btn btn-light' id='bck_mnt'><i class='fa fa-arrow-left'></i></button></div><div class='col-sm-2>'><h5 class='mt-2'>"+dateInWords+"</h5></div>");
                 // // Loop through the data and generate a button for each item
                 // $('#bck_mnt').click(function(){
                 //   $('#filter').trigger('change');
                 // });
                 
              
                 $.each(data, function(index, item) {
                     var card = item.card;
                     $('.reportClassTable').append(card);
                 });

                 // Get the element with the ID "showTable"
             var element = document.getElementById("showTableClassReport");
             var print = document.getElementById("showPrintClass");

             // Set the hidden attribute to false to show the element
             element.hidden = false;
             print.hidden = false;
                 
             },
             error: function() {
               // Close loading screen
          swal.close();
                 alert('Error fetching data');
             }
         });

    

  
  })


  $(".printPastDueClassReport").on("click", function(){
    var input2 = document.getElementById('dateFrom');
    var dateFrom = input2.value;
    var input1 = document.getElementById('dateTo');
    var dateTo = input1.value;
    var input3 = document.getElementById('branch_name');
    var branch_name = input3.value;
    var input4 = document.getElementById('class');
    var class_type = input4.value;

    window.open("extensions/tcpdf/pdf/print_pastdueclassreport.php?dateFrom="+dateFrom+"&dateTo="+dateTo+"&branch_name="+branch_name+"&class_type="+class_type);
  
  })


  $(".class").on("change", function(){ 
    var selectClass = document.getElementById('class');
    var selectedClass = selectClass.value;
    var dateChange = document.getElementById("dateChange");

    if(selectedClass == "W" || selectedClass == "F" ){
      dateChange.hidden = false;

    }else{
      dateChange.hidden = true;
    }

   

  });

  $(".pastdueChecker").on("click",function(){
 
      var type = "duplicate";
        $.ajax({
          url: 'ajax/checker.ajax.php',
          data: {
            type: type
          },
          dataType: 'json',
          success: function(data) {
            
              $.each(data, function(index, item) {
                  var card = item.card;
                  $('#pastdueChecker .modal-body tbody').append(card);
              });
              $('#pastdueChecker').modal('show');

          },
          error: function() {
              alert('Error fetching data');
          }
      });
   
  }) 

  $(".pastdueledgerTable").on("click", "tbody .btnEditClient", function(){
    var idClient = $(this).attr("idClient");
    var type = "editLedger";

    $('#editLedgerModal .modal-body').empty();

        $.ajax({
          url: 'ajax/pastdueedit.ajax.php',
          data: {
            idClient: idClient,
            type: type
          },
          dataType: 'json',
          success: function(data) {
            
              $.each(data, function(index, item) {
                  var card = item.card;
                  $('#editLedgerModal .modal-body').append(card);
              });
              $('#editLedgerModal').modal('show');

          },
          error: function() {
              alert('Error fetching data');
          }
      });
   
  }) 

  $(".pastdueledgerTable").on("click", "tbody .btnDeleteClient", function(){
    var idClient = $(this).attr("idClient");
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
              window.location = "index.php?route=pastdueledger&idClient="+idClient;
          }
    })
  })


  $(".pastdueChecker1").on("click",function(){
    var type = "checkLedger";
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
        url: 'ajax/checker.ajax.php',
        data: {
          type: type
        },
        dataType: 'json',
        success: function(data) {
           swal.close();
            $.each(data, function(index, item) {
                var card = item.card;
                $('#pastdueChecker1 .modal-body tbody').append(card);
            });
            $('#pastdueChecker1').modal('show');

        },
        error: function() {
          swal.close();
            alert('Error fetching data');
        }
    });
 
}) 

$(".branch_name_checker").on("change",function(){
  var type = "checkFullypaid";
  var branch_name = document.getElementById('branch_name_checker');
  var selectedbranch_name = branch_name.value;
  $('.checkerBody').empty();

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
      url: 'ajax/checker.ajax.php',
      data: {
        selectedbranch_name: selectedbranch_name,
        type: type
      },
      dataType: 'json',
      success: function(data) {
         swal.close();
          $.each(data, function(index, item) {
              var card = item.card;
              $('#pastdueChecker2 .modal-body tbody').append(card);
          });
          $('#pastdueChecker2').modal('show');

      },
      error: function() {
        swal.close();
          alert('Error fetching data');
      }
  });

}) 

$(".amount").on("blur",function(){
  var amount1 = document.getElementById('amount');
  var amount = amount1.value;
  var element = document.getElementById("include_week1");
  if(amount<0){
    // Show hidden check box
    element.hidden = false;
  }else{
    element.hidden = true;
  }

})


$(".summaryReport").on("click",function(){
  var slcMonth1 = document.getElementById('slcMonth');
  var slcMonth = slcMonth1.value;
  var type = "summaryReport";

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
    url: 'ajax/pastduereport.ajax.php',
    data: {
      slcMonth: slcMonth,
      type: type
    },
    dataType: 'json',
    success: function(data) {
      swal.close();
      // Close loading screen
      $('.pastDueSummaryReport').html(data.card);
      var print = document.getElementById("printWeeklyCollection");
      print.hidden = false;
    },
    error: function() {
      // Close loading screen
      swal.close();

      alert('Error fetching data');
    }
  });
 
})


$(document).keydown(function(event) {

    if (event.altKey && event.which === 112) {
      handleAltF1();
    }
    // Check the keycode of the pressed key
    switch (event.which) {
      case 112: // F1 key
        handleF1();
        break;
      case 113: // F2 key
        handleF2();
        break;
      // Add cases for other F3 to F10 keys as needed
      case 114: // F3 key
        handleF3();
        break;
      // Add cases for other F4 to F10 keys as needed
      // ...
      case 121: // F10 key
        handleF10();
        break;
      default:
        // For other keys, do nothing or handle them as needed
        break;
    }

  });
   // Define functions to be executed for each F-key
   function handleAltF1() {
    console.log('Alt + F1 key pressed');
    // Add your code here for Alt + F1
  }

  function handleF1() {
    console.log('F1 key pressed');
    // Add your code here for F1
  }

  function handleF2() {
    console.log('F2 key pressed');
    // Add your code here for F2
  }

  // Add other functions for F3 to F10 as needed
  function handleF3() {
    console.log('F3 key pressed');
    // Add your code here for F3
  }

  // Add other functions for F4 to F10 as needed
  // ...
  function handleF10() {
    console.log('F10 key pressed');
    // Add your code here for F10
  }

    
  $(".printSummary1").on("click", function(){
    var input2 = document.getElementById('slcMonth');
    var slcMonth = input2.value;
    var preparedBy1 = document.getElementById('preparedBy');
    var preparedBy = preparedBy1.value;
    var checkedBy1 = document.getElementById('checkedBy');
    var checkedBy = checkedBy1.value;
    var notedBy1 = document.getElementById('notedBy');
    var notedBy = notedBy1.value;
    var position1 = document.getElementById('position');
    var position = position1.value;
   
    window.open("extensions/tcpdf/pdf/pastdue_performance_summary.php?slcMonth="+slcMonth+"&preparedBy="+preparedBy+"&checkedBy="+checkedBy+"&notedBy="+notedBy+"&position="+position);
  
  })




  // summary of bad accounts

  $(".summaryOfBadAccounts").on("click", function(){
    var input = document.getElementById('dateFrom');
    var dateFrom = input.value;
    var input_1 = document.getElementById('branch_name_input');
    var branch_name_input = input_1.value;
  
    $(".reportAccountSummaryTable").empty();

    

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
        url: 'ajax/badAccounts.ajax.php',
        data: {
          dateFrom: dateFrom,
          branch_name_input: branch_name_input
          },
          dataType: 'json',
          success: function(data) {

            // var selectedYear = new Date(dateFrom).getFullYear();
            // $("#header-year-1").text(selectedYear);
            // $("#header-year-2").text(selectedYear - 1);
            // $("#header-year-3").text(selectedYear - 2);
            // $("#header-year-4").text(selectedYear - 3);
            // $("#header-year-5").text(selectedYear - 4);
            // $("#header-year-6").text(selectedYear - 5);
            // $("#header-year-7").text(selectedYear - 6);
            // $("#header-year-8").text(selectedYear - 7);
            // $("#header-year-9").text(selectedYear - 8);
            // $("#header-year-10").text(selectedYear - 9);
            // Close loading screen
      swal.close();                 
          $.each(data, function(index, item) {
              var card = item.card;
              $('.reportAccountSummaryTable').append(card);
          });

          // Get the element with the ID "showTable"
      var element = document.getElementById("showTableAccountReport");
      var print = document.getElementById("printPastDueSummaryReport");

      // Set the hidden attribute to false to show the element
      element.hidden = false;
      print.hidden = false;
          
      },
      error: function() {
        // Close loading screen
  swal.close();
          alert('Error fetching data');
      }
  });

  })

  
  $(".summaryOfBadAccounts2").on("click", function(){
    var input2 = document.getElementById('dateFrom');
    var dateFrom = input2.value;
    var input1 = document.getElementById('branch_name_input');
    var branch_name_input = input1.value;
    var input3 = document.getElementById('preparedBy');
    var preparedBy = input3.value;
    var input4 = document.getElementById('checkedBy');
    var checkedBy = input4.value;
    var input5 = document.getElementById('notedBy');
    var notedBy = input5.value;

    var input6 = document.getElementById('f1');
    var f1 = input6.value;
    var input7 = document.getElementById('amount1');
    var amount1 = input7.value;
    var input8 = document.getElementById('f2');
    var f2 = input8.value;
    var input9 = document.getElementById('amount2');
    var amount2 = input9.value;
    var input10 = document.getElementById('f3');
    var f3 = input10.value;
    var input11= document.getElementById('amount3');
    var amount3 = input11.value;
    var input12 = document.getElementById('f4');
    var f4 = input12.value;
    var input13 = document.getElementById('amount4');
    var amount4 = input13.value;
    var input14 = document.getElementById('f5');
    var f5 = input14.value;
    var input15 = document.getElementById('amount5');
    var amount5 = input15.value;
    var input16 = document.getElementById('f6');
    var f6 = input16.value;
    var input17 = document.getElementById('amount6');
    var amount6 = input17.value;
    var input18 = document.getElementById('f7');
    var f7 = input18.value;
    var input19 = document.getElementById('amount7');
    var amount7 = input19.value;
    var input20 = document.getElementById('ftotal');
    var ftotal = input20.value;
    var input21 = document.getElementById('totalamount');
    var totalamount = input21.value;
    var input22 = document.getElementById('ftitle');
    var ftitle = input22.value;
   
    window.open("extensions/tcpdf/pdf/print_bad_accounts.php?dateFrom="+dateFrom+"&branch_name_input="+branch_name_input+"&preparedBy="+preparedBy+"&checkedBy="+checkedBy+"&notedBy="+notedBy+"&f1="+f1+"&amount1="+amount1+"&f2="+f2+"&amount2="+amount2+"&f3="+f3+"&amount3="+amount3+"&f4="+f4+"&amount4="+amount4+"&f5="+f5+"&amount5="+amount5+"&f6="+f6+"&amount6="+amount6+"&f7="+f7+"&amount7="+amount7+"&ftotal="+ftotal+"&totalamount="+totalamount+"&ftitle="+ftitle);
  
  })

  //summaryOfBadAccounts2

  // past due account summary per year//

  

  $(".generatePastDueLedgerReport").on("click", function(){
    var input = document.getElementById('dateFrom');
    var dateFrom = input.value;
    var input_1 = document.getElementById('branch_name_input');
    var branch_name_input = input_1.value;

  
     // Populate the input fields in the modal with these values
     $("#branch_name_input_clone").val(branch_name_input);
     $("#dateFrom_clone").val(dateFrom);

     if (dateFrom === "" || branch_name_input === "") {

      swal({
        type: "warning",
        title: "Please select date & branch name first",
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

      $(".reportAccountSummaryTable").empty();

      var element = document.getElementById("showTableAccountReport");
      var print = document.getElementById("printPastDueSummaryReport");
  
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
          url: 'ajax/pastdueaccountsummary.ajax.php',
          data: {
            dateFrom: dateFrom,
            branch_name_input: branch_name_input
            },
            dataType: 'json',
            success: function(data) {
  
              try {
  
                  var selectedYear = new Date(dateFrom).getFullYear();
                $("#header-year-1").text(selectedYear);
                $("#header-year-2").text(selectedYear - 1);
                $("#header-year-3").text(selectedYear - 2);
                $("#header-year-4").text(selectedYear - 3);
                $("#header-year-5").text(selectedYear - 4);
                $("#header-year-6").text(selectedYear - 5);
                $("#header-year-7").text(selectedYear - 6);
                $("#header-year-8").text(selectedYear - 7);
                $("#header-year-9").text(selectedYear - 8);
                $("#header-year-10").text(selectedYear - 9);
  
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
             
              // Close loading screen
        swal.close();                 
            $.each(data, function(index, item) {
                var card = item.card;
                $('.reportAccountSummaryTable').append(card);
            });
  
            // Get the element with the ID "showTable"
        var element = document.getElementById("showTableAccountReport");
        var print = document.getElementById("printPastDueSummaryReport");
  
        // Set the hidden attribute to false to show the element
        element.hidden = false;
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



