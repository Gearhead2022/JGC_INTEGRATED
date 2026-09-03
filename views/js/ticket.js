$('.ticketTable').DataTable({
    "ajax": "ajax/ticket.ajax.php", 
    "deferRender": true,
    "retrieve": true,
    "processing": true,
    "order": [[1, 'asc']],
    "iDisplayLength": 25,
  }); 


  $('.showAccountNum').DataTable({
    "ajax": {
      "url": "ajax/ticket_user.ajax.php",
      "data": function (d) {
        d.id = $('.showAccountNum').attr("idnum");
      }
    },
    "deferRender": true,
    "retrieve": true,
    "processing": true,
    "order": [[1, 'asc']],
    "iDisplayLength": 25,

  }); 

  $('.ticketArchiveTable').DataTable({
    "ajax": "ajax/ticketarchive.ajax.php", 
    "deferRender": true,
    "retrieve": true,
    "processing": true,
    "order": [[1, 'asc']],
    "iDisplayLength": 25,

  }); 




  $(".ticketTable").on("click", "tbody .btnViewTicket", function(){
    var id = $(this).attr("id");
    var branch_name = $(this).attr("branch_name");
    var name = $(this).attr("name");
    var terms = $(this).attr("terms");
    var index_id = $(this).attr("index_id");
    var area_code = $(this).attr("area_code");
    var tdate = $(this).attr("tdate");
    window.location = "index.php?route=showTicketDetails&id="+id+"&branch_name="+branch_name+"&name="+name+"&terms="+terms+"&index_id="+index_id+"&area_code="+area_code+"&tdate="+tdate;
  })


  $(".btnPrintTicket").on("click", function(){
    var id = $(this).attr("id");
    var branch_name = $(this).attr("branch_name");
    var name = $(this).attr("name");
    var terms = $(this).attr("terms");
    var index_id = $(this).attr("index_id");
    var area_code = $(this).attr("area_code");
    var tdate = $(this).attr("tdate");
    var type="true";
    if(terms == 1){
      var tikname = "TICKET";
    }else{
      var tikname = "TICKETS";
    }
    swal({
      type: "warning",
      title: "Are you sure that <u>" + name +"</u> will get a Total of \n"+"<u>"+terms+" "+tikname+"?</u>",
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      cancelButtonText: 'CANCEL',
      confirmButtonText: 'OK'
    }).then(function(result){
      if (result.value) {
          window.location = "index.php?route=showTicketDetails&id="+id+"&branch_name="+branch_name+"&name="+name+"&terms="+terms+"&index_id="+index_id+"&area_code="+area_code+"&tdate="+tdate+"&type="+type;

      }
    });
  
  })


 


$(".ticketArchiveTable").on("click", "tbody .btnPrintTicket", function(){
  var defPassword = "ORAETLABORA";
  var id = $(this).attr("id");
  var branch_name = $(this).attr("branch_name");
  var name = $(this).attr("name");
  var terms = $(this).attr("terms");
  var index_id = $(this).attr("index_id");
  var area_code = $(this).attr("area_code");
  var tdate = $(this).attr("tdate");
  $('#archiveModal').modal('show');
  $("#btnArchive").on("click", function(){
    var arc_password1 = document.getElementById('arc_password');
    var arc_password = arc_password1.value;
    if(arc_password == defPassword){
        window.open("extensions/tcpdf/pdf/ticket.php?id="+id+"&branch_name="+branch_name+"&name="+name+"&terms="+terms+"&tdate="+tdate);
        window.location = "index.php?route=ticketarchive";
    }else{
      swal({
        type: "warning",
        title: "You Enter Wrong Password!",
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'OK'
      }).then(function(result){
        if (result.value) {
            window.location = "ticketarchive";
        }
       
      });
    }
  
  })

 
})




$(".generateBatchTicket").on("click", function(){
  var input = document.getElementById('area_code');
  var area_code = input.value;

  var input1 = document.getElementById('branch_name');
  var branch_name = input1.value;

   if (area_code === "" && branch_name === "") {

      swal({
        type: "warning",
        title: "Please select area or branch name first.",
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

    $(".reportBatchTicketTable").empty();

    var element = document.getElementById("showTableBatchTicketReport");

    var print = document.getElementById("printBatchTicketReport");

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
        url: 'ajax/batchTicketPrint.ajax.php',
        data: {
          area_code: area_code, branch_name: branch_name
          },
          dataType: 'json',
          success: function(data) {

            swal.close();
            
            $.each(data, function(index, item) {
              var card = item.card;
              $('.reportBatchTicketTable').append(card);
          });

           

            var element = document.getElementById("showTableBatchTicketReport");  
            var print = document.getElementById("printBatchTicketReport");
        
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



$(".printBatchTicketReport").on("click", function(){
  var input1 = document.getElementById('area_code');
  var area_code = input1.value;

  var input1 = document.getElementById('branch_name');
  var branch_name = input1.value;

  window.open("extensions/tcpdf/pdf/batchTicketPrintingReport.php?area_code="+area_code+"&branch_name="+branch_name);

})


$(".ticketTable").on("click", "tbody .btnDeleteClient", function(){
  var idClient = $(this).attr("idClient");
  swal({
        title: 'Do you want to delete this ticket?',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'cancel',
        confirmButtonText: 'Yes'
      }).then(function(result){
        if (result.value) {
            window.location = "index.php?route=ticket&idClient="+idClient;
        }
  })
})

$("#ticketMonitoring").on("click", function(){
  var tFrom1 = document.getElementById('tFrom');
  var tFrom = tFrom1.value;
  var tTo1 = document.getElementById('tTo');
  var tTo = tTo1.value;
  var tType1 = document.getElementById('tType');
  var tType = tType1.value;
  var tBranch_name1 = document.getElementById('tBranch_name');
  var tBranch_name = tBranch_name1.value;
  var tPreby1 = document.getElementById('tPreby');
  var tPreby = tPreby1.value;
  if(tFrom != "" && tTo != "" && tType != "" && tBranch_name != "" && tPreby != ""){
    window.open("extensions/tcpdf/pdf/ticket_monitoring.php?tFrom="+tFrom+"&tTo="+tTo+"&tType="+tType+"&branch_name="+tBranch_name+"&tPreby="+tPreby+"&tType="+tType);
  }else{
    swal({
      type: "warning",
      title: "Don't leave the fields empty!",
      cancelButtonColor: '#3085d6',
      cancelButtonText: 'OK',
    }).then(function(result){
    });
  }
})



$("#dailySummaryReport").on("click", function(){
  var dateTo1 = document.getElementById('dateTo');
  var dateTo = dateTo1.value;
  var sType1 = document.getElementById('sType');
  var sType = sType1.value;
  var sPreby1 = document.getElementById('sPreby');
  var sPreby = sPreby1.value;

  if(dateTo != ""  && sType != "" && sPreby != ""){
    window.open("extensions/tcpdf/pdf/ticket_summary.php?dateTo="+dateTo+"&sType="+sType+"&sPreby="+sPreby);
  }else{
    swal({
      type: "warning",
      title: "Don't leave the fields empty!",
      cancelButtonColor: '#3085d6',
      cancelButtonText: 'OK',
    }).then(function(result){
    });
  }
})





