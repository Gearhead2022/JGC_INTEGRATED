
$('.branchDailyDTRUploadTable').DataTable({
    "ajax": "ajax/branchDTRUpload.ajax.php", 
    "deferRender": true,
    "retrieve": true,
    "processing": true,
    "iDisplayLength": 25,
  
}); 

$(".branchDailyDTRUploadTable").on("click", "tbody .btnDeleteBranchDTR", function(){
    var id = $(this).attr("id");
    var branch_name = $(this).attr("branch_name");
    var entry_date = $(this).attr("entry_date");
  
        swal({
          title: 'Are you sure you want to delete this file?',
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          cancelButtonText: 'cancel',
          confirmButtonText: 'Yes'
        }).then(function(result){
          if (result.value) {
            window.location = "index.php?route=branchDTRUpload&id="+id+"&branch_name="+branch_name+"&entry_date="+entry_date;
          }
    })
  
  })

  
$('.hrDailyDTRDownloadTable').DataTable({
    "ajax": "ajax/hrDTRDownload.ajax.php", 
    "deferRender": true,
    "retrieve": true,
    "processing": true,
    "iDisplayLength": 25,
  
}); 

$(".hrDailyDTRDownloadTable").on("click", "tbody .btnDownloadBranchDTR", function(){
  var id = $(this).attr("id");
  var branch_name = $(this).attr("branch_name");
  var entry_date = $(this).attr("entry_date");
  var entry_file = $(this).attr("entry_file");

      swal({
        title: 'Are you sure you want to download this file?',
        type: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'cancel',
        confirmButtonText: 'Yes'
      }).then(function(result){
        if (result.value) {
          window.location = "index.php?route=hrDTRDownload&id="+id+"&branch_name="+branch_name+"&entry_date="+entry_date+"&entry_file="+entry_file;
        }
  })

})

$(".branchDailyDTRUploadTable").on("click", "tbody .btnEditBranchDTR", function(){

  var id = $(this).attr("id");
  var branch_name = $(this).attr("branch_name");
  
  $('#editDTR .modal-body').empty();

    $.ajax({
      url: 'ajax/editBranchDTR.ajax.php',
      data: {
        id: id, branch_name: branch_name
      },
      dataType: 'json',
      success: function(data) {
        
          $.each(data, function(index, item) {
              var card = item.card;
              $('#editDTR .modal-body').append(card);
          });
          $('#editDTR').modal('show');

      },
      error: function() {
          alert('Error fetching data');
      }
  });

}) 

$(".branchDailyDTRUploadTable").on("click", "tbody .btnViewBranchDTR", function(){

  var id = $(this).attr("id");
  var branch_name = $(this).attr("branch_name");
  
  $('#viewDTR .modal-body').empty();

    $.ajax({
      url: 'ajax/viewBranchDTR.ajax.php',
      data: {
        id: id, branch_name: branch_name
      },
      dataType: 'json',
      success: function(data) {
        
          $.each(data, function(index, item) {
              var card = item.card;
              $('#viewDTR .modal-body').append(card);
          });
          $('#viewDTR').modal('show');

      },
      error: function() {
          alert('Error fetching data');
      }
  });

}) 


$("#check_all").on("click", function(){ 

  var input = document.getElementById('check_entry_date');
  var check_entry_date = input.value;
  
  swal({
    title: "Generating",
    text: "Please wait...",
    allowOutsideClick: false,
    allowEscapeKey: false,
    onOpen: () => {
      swal.showLoading();
    }
  });

  $(".BranchDTRUploadList").empty();
     $.ajax({
        url: 'ajax/dtrChecker.ajax.php',
        data: {
          check_entry_date: check_entry_date
        },
        dataType: 'json',
        success: function(data) {

          swal.close();
            $.each(data, function(index, item) {
                var card = item.card;
                $('.BranchDTRUploadList').append(card);
            });

          // Get the element with the ID "showTable"
        var element = document.getElementById("showDTRTable");
        // Set the hidden attribute to false to show the element
        element.hidden = false;

        var print = document.getElementById("printDTRReport");
        print.hidden = false;
     
        },
        error: function() {
          swal.close();
          swal({
            type: "info",
            title: "An error occurred while processing the response.",
            showConfirmButton: true,
            confirmButtonText: "Ok"
        }).then(function(result){
            if (result.value) {
                window.location = "hrDTRDownload";
            }
        });
        }
    });

})


// Branch Time in DTR UPLOAD

$('.branchDailyTimeInDTRUploadTable').DataTable({
  "ajax": "ajax/branchTimeInDTRUpload.ajax.php", 
  "deferRender": true,
  "retrieve": true,
  "processing": true,
  "iDisplayLength": 25,

}); 

$(".branchDailyTimeInDTRUploadTable").on("click", "tbody .btnEditBranchTimeInDTR", function(){

  var id = $(this).attr("id");
  var branch_name = $(this).attr("branch_name");
  
  $('#editTimeinDTR .modal-body').empty();

    $.ajax({
      url: 'ajax/editBranchTimeInDTR.ajax.php',
      data: {
        id: id, branch_name: branch_name
      },
      dataType: 'json',
      success: function(data) {
        
          $.each(data, function(index, item) {
              var card = item.card;
              $('#editTimeinDTR .modal-body').append(card);
          });
          $('#editTimeinDTR').modal('show');

      },
      error: function() {
          alert('Error fetching data');
      }
  });

}) 

$(".branchDailyTimeInDTRUploadTable").on("click", "tbody .btnDeleteBranchTimeInDTR", function(){
  var id = $(this).attr("id");
  var branch_name = $(this).attr("branch_name");
  var entry_date = $(this).attr("entry_date");

      swal({
        title: 'Are you sure you want to delete this file?',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'cancel',
        confirmButtonText: 'Yes'
      }).then(function(result){
        if (result.value) {
          window.location = "index.php?route=branchTimeInDTRUpload&id="+id+"&branch_name="+branch_name+"&entry_date="+entry_date;
        }
  })

})

// HR Time in DTR DOWNLOAD

$('.hrDailyTimeInDTRDownloadTable').DataTable({
  "ajax": "ajax/hrTimeInDTRDownload.ajax.php", 
  "deferRender": true,
  "retrieve": true,
  "processing": true,
  "iDisplayLength": 25,

}); 


$(".hrDailyTimeInDTRDownloadTable").on("click", "tbody .btnDecryptBranchDTR", function(){

  var id = $(this).attr("id");
  var branch_name = $(this).attr("branch_name");
  var entry_date = $(this).attr("entry_date");
  var entry_file = $(this).attr("entry_file");

  swal({
    title: "Generating",
    text: "Please wait...",
    allowOutsideClick: false,
    allowEscapeKey: false,
    onOpen: () => {
      swal.showLoading();
    }
  });
  
  $('#DTRTimeinModal .BranchTimeIn').empty();

    $.ajax({
      url: 'ajax/decryptBranchDTR.ajax.php',
      data: {
        id: id, branch_name: branch_name, entry_date: entry_date, entry_file: entry_file
      },
      dataType: 'json',
      success: function(data) {
        // alert(data);

        swal.close();
        $.each(data, function(index, item) {
          var card = item.card;
          $('#DTRTimeinModal .BranchTimeIn').append(card);
      });
      $('#DTRTimeinModal').modal('show');

      },
      error: function() {
        swal.close();
        swal({
          type: "info",
          title: "An error occurred while processing the response.",
          showConfirmButton: true,
          confirmButtonText: "Ok"
      }).then(function(result){
          if (result.value) {
              window.location = "hrTimeInDTRDownload";
          }
      });
      }
  });

}) 

$("#check_all_branch_dtr_time_in").on("click", function(){ 

  var input = document.getElementById('check_time_in_entry_date');
  var check_time_in_entry_date = input.value;
  
  swal({
    title: "Generating",
    text: "Please wait...",
    allowOutsideClick: false,
    allowEscapeKey: false,
    onOpen: () => {
      swal.showLoading();
    }
  });

  $(".BranchAllTimeInDTRUploadList").empty();
     $.ajax({
        url: 'ajax/branchdtrtimeinChecker.ajax.php',
        data: {
          check_time_in_entry_date: check_time_in_entry_date
        },
        dataType: 'json',
        success: function(data) {

          swal.close();
            $.each(data, function(index, item) {
                var card = item.card;
                $('.BranchAllTimeInDTRUploadList').append(card);
            });

          // Get the element with the ID "showTable"
        var element = document.getElementById("showAllTimeInDTRTable");
        // Set the hidden attribute to false to show the element
        element.hidden = false;
     
        },
        error: function() {
          swal.close();
          swal({
            type: "info",
            title: "An error occurred while processing the response.",
            showConfirmButton: true,
            confirmButtonText: "Ok"
        }).then(function(result){
            if (result.value) {
                window.location = "hrTimeInDTRDownload";
            }
        });
        }
    });

})

$(document).ready(function() {
  // Add an event listener for the modal hidden event
  $('#checkTimeInDTRUploads').on('hidden.bs.modal', function() {
    // Reload the page when the modal is closed
    location.reload();
  });
});

$(document).ready(function() {
  // Add an event listener for the modal hidden event
  $('#DTRTimeinModal').on('hidden.bs.modal', function() {
    // Reload the page when the modal is closed
    location.reload();
  });
});

$(document).ready(function() {
  // Add an event listener for the modal hidden event
  $('#checkDTRUploads').on('hidden.bs.modal', function() {
    // Reload the page when the modal is closed
    location.reload();
  });
});

$("#download_all_DTR_time_in").on("click", function(){
  // Prevent the default form submission behavior
  var input_2 = document.getElementById('entry_date');
  var entry_date = input_2.value;

  // Check if a date is selected (assuming a simple check for non-empty string)
  if (entry_date.trim() !== "") {
    swal({
      title: 'Are you sure you want to download all the file?',
      type: 'question',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      cancelButtonText: 'cancel',
      confirmButtonText: 'Yes'
    }).then(function(result){
      if (result.value) {
        window.location = "index.php?route=hrTimeInDTRDownload&entry_date="+entry_date+"&download_all_DTR_time_in=download_all_DTR_time_in";
      }
    });
  } 
});

$(".branchDailyTimeInDTRUploadTable").on("click", "tbody .btnViewBranchTimeInDTR", function(){

  var id = $(this).attr("id");
  var branch_name = $(this).attr("branch_name");
  
  $('#viewDTRTimeIn .modal-body').empty();

    $.ajax({
      url: 'ajax/viewBranchDTRTimeIn.ajax.php',
      data: {
        id: id, branch_name: branch_name
      },
      dataType: 'json',
      success: function(data) {
        
          $.each(data, function(index, item) {
              var card = item.card;
              $('#viewDTRTimeIn .modal-body').append(card);
          });
          $('#viewDTRTimeIn').modal('show');

      },
      error: function() {
          alert('Error fetching data');
      }
  });

}) 


// Addition For Printing Report

$(".printDTRReport").on("click", function(){
  var input_2 = document.getElementById("check_entry_date");

  var check_entry_date = input_2.value;
  window.open("extensions/tcpdf/pdf/print_DTRChecker.php?check_entry_date="+check_entry_date);

})

$("#check_all_DTR_Time_In").on("click", function(){ 

  var input = document.getElementById('check_entry_date');
  var check_entry_date = input.value;
  
  swal({
    title: "Generating",
    text: "Please wait...",
    allowOutsideClick: false,
    allowEscapeKey: false,
    onOpen: () => {
      swal.showLoading();
    }
  });

  $(".BranchTimeInDTRUploadList").empty();
     $.ajax({
        url: 'ajax/dtrTimeInChecker.ajax.php',
        data: {
          check_entry_date: check_entry_date
        },
        dataType: 'json',
        success: function(data) {

          swal.close();
            $.each(data, function(index, item) {
                var card = item.card;
                $('.BranchTimeInDTRUploadList').append(card);
            });

          // Get the element with the ID "showTable"
        var element = document.getElementById("showTimeInDTRTable");
        // Set the hidden attribute to false to show the element
        element.hidden = false;

        var print = document.getElementById("printTimeInDTRReport");
        print.hidden = false;
     
        },
        error: function() {
          swal.close();
          swal({
            type: "info",
            title: "An error occurred while processing the response.",
            showConfirmButton: true,
            confirmButtonText: "Ok"
        }).then(function(result){
            if (result.value) {
                window.location = "hrTimeInDTRDownload";
            }
        });
        }
    });

})

$(".printTimeInDTRReport").on("click", function(){
  var input_2 = document.getElementById("check_entry_date");

  var check_entry_date = input_2.value;
  window.open("extensions/tcpdf/pdf/print_TimeInDTRChecker.php?check_entry_date="+check_entry_date);

})


$('.dtr_download_all').click(function(){
    // Prevent the default form submission behavior
  var input_2 = document.getElementById('entry_date');
  var entry_date = input_2.value;

  // Check if a date is selected (assuming a simple check for non-empty string)
  if (entry_date.trim() !== "") {
    swal({
      title: 'Are you sure you want to download all the file?',
      type: 'question',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      cancelButtonText: 'cancel',
      confirmButtonText: 'Yes'
    }).then(function(result){
      if (result.value) {
        window.location = "email/dowloadallfiles.php?entry_date="+entry_date;
      }
    });
  } 
    
});





