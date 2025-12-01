$('.inventoryTable').DataTable({
    "ajax": "ajax/inventory.ajax.php", 
    "deferRender": true,
    "retrieve": true,
    "processing": true
  });

  $(".inventoryTable").on("click", "tbody .btnPrntQR", function(){
    var idClient = $(this).attr("idClient");
      // Wrap the ID in an array
     var arrayData = [idClient];
    
     // Convert the array to JSON and encode it for URL
     var jsonData = JSON.stringify(arrayData);
     
     // Open a new window with the JSON data as a query parameter
     window.open("extensions/tcpdf/pdf/testing.php?data=" + encodeURIComponent(jsonData));
  })


  $(".inventoryTable").on("click", "tbody .btnEditItem", function(){
    var idClient = $(this).attr("idClient");
    var action = "edit";
    $('#editItemModal .modal-body').empty();
    $.ajax({
      url: 'ajax/inventoryedit.ajax.php',
      data: {
        idClient: idClient
      },
      dataType: 'json',
      success: function(data) {
          $.each(data, function(index, item) {
              var card = item.card;
              $('#editItemModal .modal-body').append(card);
                // Bind the company change event for the newly added content
                $('#editItemModal .company').on("change", function(){
                  var company = $(this).val();
                  handleCompanyChange(company, action);
              });
             
              $('.editStatus').on('change', function(){
                 let stat = $(this).val();
                swal({
                  type: "warning",
                  title: "Are you sure you want to change the status to "+ stat,
                  showConfirmButton: true, 
                  confirmButtonText: "Ok"
              }).then(function(result){
                  if (result.value) {
                      // Handle the user's confirmation if needed
                  }
              });
              })
          });
          $('#editItemModal').modal('show');
        },
        error: function() {
          alert('Error fetching data');
      }
      });
  })

// Function to handle company change and fetch sticker data
function handleCompanyChange(company, action) {
  var type = "getbranch";
  $.ajax({
      url: 'ajax/inventoryprocessing.ajax.php',
      data: {
          company: company,
          type: type
      },
      dataType: 'json',
      success: function(data){
          $.each(data, function(index, item){
              if(action == "edit"){
                $('#editSticker_no').val(item.last_sticker);
              }else if(action == "add"){
                $('#sticker_no').val(item.last_sticker);
                $('#item_name1').append(item.card);
              }else if(action == "batch"){
                $('#item_name2').append(item.card);
              }else if(action == "audit"){
                $('#item_name3').append(item.card);
              }
              else if(action == "unregistered"){
                $('#item_name4').append(item.card);
              }
          });
      },
      error: function(){
          alert('Error fetching data');
      }
  });
}

  $(".company").on("change", function(){
    $('#item_name1').find('option').not(':first').remove();
    var company = $(this).val();
    var action = "add";
    handleCompanyChange(company, action);
  })

  let dltID, sticker; // Use `let` for block-scoped variables
  $(".inventoryTable").on("click", "tbody .btnDeleteItem", function(){
     dltID = $(this).attr("idClient");
     delItem = $(this).attr("item_code");
     sticker = $(this).attr("sticker");
     $('#itemSticker').val("");
    $('#confirmDeleteModal').modal('show'); // Show the modal
  });
  
  $('#confirmDeleteBtn').on('click', function() {
    var conSticker = $('#itemSticker').val();
    var type = "delete";
    if(conSticker == sticker){
    $.ajax({
      url: 'ajax/inventoryprocessing.ajax.php',
      data: {
          id: dltID,
          type: type,
          item_code: delItem
      },
          dataType: 'json',
          success: function(data){
                  if(data.status=="success"){
                    swal({
                      type: "success",
                      title: "SUCCESS",
                      text: "Sticker number "+ sticker+" has been succesfully deleted!",
                      showConfirmButton: true,
                      confirmButtonText: "Ok"
                  }).then(function(result) {
                        window.location.href = "inventory"; 
                  });
                  }else{
                    swal({
                      type: "error",
                      title: "ERROR",
                      text: data.message,
                      showConfirmButton: true,
                      confirmButtonText: "Ok"
                  }).then(function(result) {
                      if (result.isConfirmed) {
                          // Optionally, you can redirect or perform another action here
                      }
                  });
                  }
             
          },
          error: function(){
              alert('Error fetching data');
          }
      });
    }else{
      swal({
        type: "error",
        title: "ERROR",
        text: "You entered the wrong sticker number.",
        showConfirmButton: true,
        confirmButtonText: "Ok"
    }).then(function(result) {
        if (result.isConfirmed) {
            // Optionally, you can redirect or perform another action here
        }
    });
    }
    });


    document.addEventListener('DOMContentLoaded', function() {
      const checkboxes = document.querySelectorAll('.item-checkbox');
      let lastChecked = null;

      function handleCheck(e) {
          let inBetween = false;
          if (e.shiftKey && lastChecked) {
              checkboxes.forEach(checkbox => {
                  if (checkbox === this || checkbox === lastChecked) {
                      inBetween = !inBetween;
                  }
                  if (inBetween) {
                      checkbox.checked = lastChecked.checked;
                  }
              });
          }
          lastChecked = this;
      }

      checkboxes.forEach(checkbox => checkbox.addEventListener('click', handleCheck));
  });

  $('#printBatch').on('click', function() {
    var selectedStickers = [];
    $('input[name="stickers[]"]:checked').each(function() {
        selectedStickers.push($(this).val());
    });

    // Display the selected values (you can process them as needed)
    console.log(selectedStickers);


    var jsonData = JSON.stringify(selectedStickers);
    window.open("extensions/tcpdf/pdf/testing.php?data=" + encodeURIComponent(jsonData));
    
});



$(".unCompany").on("change", function(){
  $('#item_name4').find('option').not(':first').remove();
  var company = $(this).val();
  var action = "unregistered";
  handleCompanyChange(company, action);
})

$(".batchCompany").on("change", function(){
  $('#item_name2').find('option').not(':first').remove();
  var company = $(this).val();
  var action = "batch";
  handleCompanyChange(company, action);
})


$('#item_name2').on("change", function(){
  var company = $(this).val();
  var type = "batchprint";
  $('#stickerTitle').text(company+' STICKER LIST');
  $('.dispayList').empty();
  $.ajax({
    url: 'ajax/inventoryprocessing.ajax.php',
    data: {
      company: company,
      type: type
    },
    dataType: 'json',
    success: function(data) {
        $.each(data, function(index, item) {
            var card = item.card;
            $('#batchPrintModal .dispayList').append(card);
          // Replace the <h5> element with a new content
           // Bind the company change event for the newly added content
        });
      },
      error: function() {
        alert('Error fetching data');
    }
    });
})



$(".inventoryTable").on("click", "tbody .btnHistory", function(){
  var idClient = $(this).attr("idClient");
  var type = "history";
  $('#historyModal .modal-body').empty();
  $.ajax({
    url: 'ajax/inventoryprocessing.ajax.php',
    data: {
      id: idClient,
      type: type
    },
    dataType: 'json',
    success: function(data) {
        $.each(data, function(index, item) {
            var card = item.card;
            $('#historyModal .modal-body').append(card);
            $('#historyModal').modal('show');
          // Replace the <h5> element with a new content
           // Bind the company change event for the newly added content
        });
      },
      error: function() {
        alert('Error fetching data');
    }
    });
 
})


// $("#unregisteredModal").on("click",function(){
//   var type = "itemcode";
//   $.ajax({
//     url: 'ajax/inventoryprocessing.ajax.php',
//     data: {
//       type: type
//     },
//     dataType: 'json',
//     success: function(data) {
//         $.each(data, function(index, item) {
//             // var card = item.card;
//             // $('#historyModal .modal-body').append(card);
//             // $('#historyModal').modal('show');
//           // Replace the <h5> element with a new content
//            // Bind the company change event for the newly added content
//            $('#unitem_code').val(data[0]);
//            var newSrc = "views/files/qrcodes/" + data[0] + ".png";

//            // Change the src attribute of the img element
//            $("#qrCodeImage").attr("src", newSrc);
//         });
//       },
//       error: function() {
//         alert('Error fetching data');
//     }
//     });
 
// })

// Function to handle company change and fetch sticker data
function handleBranchChange(branch, action) {
  var type = "get_sticker";
  $.ajax({
      url: 'ajax/inventoryprocessing.ajax.php',
      data: {
          branch: branch,
          type: type
      },
      dataType: 'json',
      success: function(data){
          $.each(data, function(index, item){
            if (item.last_sticker != 1) {
              if (action == "edit") {
                  $('#editSticker_no').val(item.last_sticker);
              } else {
                  $('#sticker_no').val(item.last_sticker);
              }
              $('#item_name1').append(item.card);
              // Ensure the .last_stickerfields div stays hidden when not needed
              $('.last_stickerfields').attr('hidden', true);
              $('#last_sticker').val(0);
          } else {
              // Show the .last_stickerfields if last_sticker is 1
              $('#last_sticker').val("");
              $('#sticker_no').val("");
              $('.last_stickerfields').removeAttr('hidden');
          }
              console.log(data);
          });
      },
      error: function(){
          alert('Error fetching data');
      }
  });
}


  $(".item_name1").on("change", function(){
    var branch = $(this).val();
    var action = "add";
   
  handleBranchChange(branch, action);
})  


$("#last_sticker").on("change", function(){
  var last_sticker = parseInt($(this).val(), 10);
  $('#sticker_no').val(last_sticker+1);
})
  
$("#addQRCode1").on("click", function(){
  var type = "generate_sticker";
  var item_code = $("#item_code").val();
  $.ajax({
      url: 'ajax/inventoryprocessing.ajax.php',
      data: {
          item_code: item_code,
          type: type
      },
      dataType: 'json',
      success: function(data){
          $.each(data, function(index, item){
            $("#displayQrcode").attr("src", "views/files/qrcodes/" + item_code + ".png");
          });
      },
      error: function(){
          alert('Error fetching data');
      }
  });
})

$('#printInventoryReport').on('click', function(){
  let branch = $('#branch').val();
  let reportType = $('#reportType').val();
  let reportStatus = $('#reportStatus').val();
  let slctClass = $('.slctClass').val();

  
  if(branch === "" || reportType === "" || reportType === null){
      swal({
          type: "error",
          title: "You need to select a branch and a report first!",
          showConfirmButton: true,
          confirmButtonText: "Ok"
      }).then(function(result){
          if (result.value) {
              // Handle the user's confirmation if needed
          }
      });
  } else {
      if(reportType == "Item Classification"){
        window.open("extensions/tcpdf/pdf/inv_classification.php?branch=" + branch + "&type=" + reportType+"&slctClass="+slctClass);
    }else if(reportType == "Undelivered Items"){
      window.open("extensions/tcpdf/pdf/inv_location.php?type=" + reportType);
    }else{
      window.open("extensions/tcpdf/pdf/inv_itemaging.php?branch=" + branch + "&type=" + reportType+"&status="+reportStatus);
    }
  }
});


$(".auditCompany").on("change", function(){

  $('#item_name3').find('option').not(':first').remove();
  var company = $(this).val();
  var action = "audit";
  handleCompanyChange(company, action);
})

function updateAuditDisplay(branch){
  var type = "displayAudit";
  let date = $('.auditDate').val();
  if(date != ""){
  $.ajax({
      url: 'ajax/inventoryprocessing.ajax.php',
      data: {
        branch: branch,
        type: type,
        date: date
      },
      dataType: 'json',
      success: function(data){
          $.each(data, function(index, item){
            $('.auditTable').append(item.card);

            $('.auditInfo').on('click', function() {
              // Hide the auditScanModal and show the auditList modal
              $('.auditBody').empty();
              $('#auditList').css('z-index', parseInt($('#auditScanModal').css('z-index')) + 10);
              $('#auditList').modal('show');
          
              let type1 = "auditList";
              $.ajax({
                  url: 'ajax/inventoryprocessing.ajax.php',
                  data: {
                      branch: branch,
                      type: type1,
                      date: date,
                  },
                  dataType: 'json',
                  success: function(data) {
                    $.each(data, function(index, item1){
                      // Handle the data returned from the server
                      $('.auditBody').append(item1.card);
                    })
                  },
                  error: function() {
                      // Handle errors here
                  }
              });
          });
          
          }); 
      },
      error: function(){
          alert('Error fetching data');
      }
  });
}else{
  swal({
    type: "error",
    title: "You need to select date first!",
    showConfirmButton: true,
    confirmButtonText: "Ok"
}).then(function(result){
    if (result.value) {
        // Handle the user's confirmation if needed
    }
});
}
}

$(".item_name3").on("change", function(){
    let branch = $(this).val();
    $('.auditTable').empty();
    updateAuditDisplay(branch);
})

$('.chkExist').on("click", function() {
  if ($(this).is(':checked')) {
      // Checkbox is checked, remove readonly attribute
      $('#sticker_no').removeAttr('readonly');
  } else {
      // Checkbox is unchecked, add readonly attribute
      $('#sticker_no').attr('readonly', true);
  }
});

$('#printRequest').on("click", function(){
  let date = $('#dateRequest').val();
  if(date === ""){
    swal({
        type: "error",
        title: "You need to select date first!",
        showConfirmButton: true,
        confirmButtonText: "Ok"
    }).then(function(result){
        if (result.value) {
            // Handle the user's confirmation if needed
        }
    });
} else {
    window.open("extensions/tcpdf/pdf/inv_request.php?date=" + date);
}
})
$('.auditDate').on("change", function(){
  let company = $('.auditCompany').val();
  let branch = $('.item_name3').val();
  if(company !=null && branch !=null){
    $('.item_name3').trigger('change');
  }
})

$('.reportType').on("change", function(){
  let reportType = $(this).val();
  
  if (reportType == "Aging Report") {
    $('.reportClass').removeAttr('hidden'); // Show the div when "Aging Report" is selected
    $('.itemClass').attr('hidden', 'hidden'); // Hide Item Classification section
  } 
  // Show the Item Classification section
  else if (reportType == "Item Classification") {
    $('.itemClass').removeAttr('hidden'); // Show the div when "Item Classification" is selected
    $('.reportClass').attr('hidden', 'hidden'); // Hide Aging Report section
  } 
  // Hide both sections for any other option
  else {
    $('.itemClass').attr('hidden', 'hidden'); 
    $('.reportClass').attr('hidden', 'hidden'); // Hide both sections when any other option is selected
  }
});

function handleClassType(class_type, action) {
  var type = "getClassCategory";
  $.ajax({
      url: 'ajax/inventoryprocessing.ajax.php',
      data: {
          class_type: class_type,
          type: type
      },
      dataType: 'json',
      success: function(data){
          $.each(data, function(index, item){
             if(action == "add"){
                $('#class_categ').append(item.card);
              }
          });
      },
      error: function(){
          alert('Error fetching data');
      }
  });
}

function handleClassList(class_categ, action) {
  var type = "getClassList";
  $.ajax({
      url: 'ajax/inventoryprocessing.ajax.php',
      data: {
         class_categ: class_categ,
          type: type
      },
      dataType: 'json',
      success: function(data){
          $.each(data, function(index, item){
             if(action == "add"){
                $('.class_list').append(item.card);
                $('#class_code').val(item.item_code);
              }
          });
      },
      error: function(){
          alert('Error fetching data');
      }
  });
}

$(".class_type").on("change", function(){ 
  $('#class_list').find('option').not(':first').remove();
  $('#class_categ').find('option').not(':first').remove();
  $('#class_code').val("");
  var class_type = $(this).val();
  var action = "add";
  handleClassType(class_type, action);
})

$(".class_categ").on("change", function(){
  $('#class_list').find('option').not(':first').remove();
  var class_categ = $(this).val();
  let class_list = $('.class_list').val();
    if(class_list == "COMPUTER SET"){
      $('.computer_set').removeClass('hide').addClass('show'); // Show div with transition
    }else{
      $('.computer_set').removeClass('show').addClass('hide'); // Hide div with transition
      $('.computer_list').val([]).trigger('change'); // Clear selection and update Select2
    }
  var action = "add";
  handleClassList(class_categ, action);
  $('.class_list').val('').trigger('change'); // Ensure Select2 updates to show default
})


$('.class_list').on("change", function() {
  let class_list = $(this).val();
  if (class_list.includes("COMPUTER SET")) {
      $('.computer_set').removeClass('hide').addClass('show'); // Show div with transition
  }else if(class_list.includes("CCTV SET")){
    $('.cctv_set').removeClass('hide').addClass('show'); // Show div with transition
  }
  else {
      $('.computer_set').removeClass('show').addClass('hide'); // Hide div with transition
      $('.cctv_set').removeClass('show').addClass('hide'); // Hide div with transition
      // Clear all selected items in the computer_list select box
      $('.computer_list').val([]).trigger('change'); // Clear selection and update Select2
      $('.cctv_list').val([]).trigger('change'); // Clear selection and update Select2
  }
});



$(".inventoryTable").on("click", "tbody .btnSet", function () {
  const idClient = $(this).attr("idClient");
  const class_code = $(this).attr("class_code");
  const type = "showItemSet";

  $('#setModal .modal-body').empty();

  $.ajax({
      url: 'ajax/inventoryprocessing.ajax.php',
      data: { id: idClient, class_code, type },
      dataType: 'json',
      success: function (data) {
          data.forEach(item => {
              const card = item.card;
              $('#setModal .modal-body').append(card);
              
          });

          $('#setModal').modal('show');
      },
      error: function () {
          alert('Error fetching data');
      }
  });
});

// Delegate event binding to dynamically added content
$('#setModal').on('click', '.btnSetAdd', function () {
   localStorage.clear();  // Clear localStorage on page load
  const item_location = $(this).attr("item_location");
  const type2 = "displayAdditional";
  $('#setModal').modal('hide');

  $.ajax({
      url: 'ajax/inventoryprocessing.ajax.php',
      data: { item_location, type: type2 },
      dataType: 'json',
      success: function (data) {
          $('#addSetModal .modal-body').empty();
          data.forEach(item => {
              $('#addSetModal .modal-body').append(item.card);
          });
          $('#addSetModal').modal('show');
      },
      error: function () {
          alert('Error fetching data');
      }
  });
});

    // Add item to localStorage and display
    $('#addSetModal').on('change','#myDatalist', function () {
      const selectedValue = this.value;
      if (!selectedValue) return;
      // Retrieve or initialize selected items
      const savedItems = JSON.parse(localStorage.getItem('selectedItems')) || [];
      // Add unique item to savedItems
      if (!savedItems.includes(selectedValue)) {
          savedItems.push(selectedValue);
          localStorage.setItem('selectedItems', JSON.stringify(savedItems));
      }
      // Clear input and display updated items
      this.value = "";
      displayItems();
    });

// Handle closing addSetModal and re-showing setModal
$('#addSetModal').on('hidden.bs.modal', function () {
  $('#setModal').modal('show');
});



// Submit selected set
$('#btnSubmitSet').on('click', function () {
  const class_code = $('#setClass_Code').val();
  const class_list = $('#setClass_List').val();
  const localSaves = JSON.parse(localStorage.getItem('selectedItems')) || [];
  const type = "saveAdditionalItem";
  // Make sure there's something to save
  if (localSaves.length === 0) {
    swal({
      type: "error",
      title: "ERROR",
      text: "No items selected to add.",
      showConfirmButton: true,
      confirmButtonText: "Ok"
  }).then(function(result) {
      if (result.isConfirmed) {
          // Optionally, you can redirect or perform another action here
      }
  });
    return;
  }

  $.ajax({
    url: 'ajax/inventoryprocessing.ajax.php',
    method: 'GET',  // Use the appropriate HTTP method, e.g., GET or POST
    data: { class_code, type, localSaves, class_list },
    dataType: 'json',
    success: function (data) {
      if (data.status === 'success') {
        swal({
          type: "success",
          title: "SUCCESS",
          text: data.message,
          showConfirmButton: true,
          confirmButtonText: "Ok"
        }).then((willReload) => {
          if (willReload) {
            window.location.href = "inventory";
          }
        });
      } else {
        // Display error message from the server
        swal({
          type: "error",
          title: "ERROR",
          text: data.message,
          showConfirmButton: true,
          confirmButtonText: "Ok"
      }).then(function(result) {
          if (result.isConfirmed) {
              // Optionally, you can redirect or perform another action here
          }
      });
      }
    },
    error: function () {
      alert('Error processing the request.');
    }
  });
});


  // Function to remove an item by index
  function removeItem(index) {
    let savedItems = JSON.parse(localStorage.getItem('selectedItems')) || [];

    // Remove the item at the given index
    savedItems.splice(index, 1);

    // Update localStorage with the new array
    localStorage.setItem('selectedItems', JSON.stringify(savedItems));

    // Update the displayed items
    displayItems();
}

function displayItems() {
  let savedItems = JSON.parse(localStorage.getItem('selectedItems')) || [];
  let displayBox = document.getElementById('displayBox');
  displayBox.innerHTML = ''; // Clear previous content

  if (savedItems.length > 0) {
      savedItems.forEach(function(item, index) {
          // Create a container for each selected item
          let itemDiv = document.createElement('div');
          itemDiv.classList.add('selected-item');
          itemDiv.innerHTML = item;

          // Create a remove button for each item
          let removeBtn = document.createElement('button');
          removeBtn.innerHTML = "X";
          removeBtn.classList.add('remove-btn');
          removeBtn.classList.add('ml-1');
          removeBtn.setAttribute('data-index', index);  // Store index to identify item
          removeBtn.addEventListener('click', function() {
              removeItem(index);  // Call removeItem when clicked
          });

          // Append item and remove button to the display box
          itemDiv.appendChild(removeBtn);
          displayBox.appendChild(itemDiv);
      });
  } else {
      displayBox.innerHTML = "No items selected";
  }
}

$('#subCamera').on('click', function(){
  let camerCount = $('#camerCount').val();
  $('#camera_count').val(camerCount);
  $('#cameraCountModal').modal('hide');

})

$('#setModal').on('click', '#removeSet', function () {
  let itemId = $(this).attr("itemId");
  let type = "dltItemSet";
  swal({
    type: "warning",
    title: "WARNING",
    text: "Do you want to remove this item from the set?",
    showCancelButton: true,  // Show the cancel button
    confirmButtonText: "Ok",
    cancelButtonText: "Cancel",
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33"
  }).then(function(result) {
    console.log(result);  // Debugging: Check the result object in the console
    // Check if the confirmation worked
    if (result.value == true) {
      
      $.ajax({
        url: 'ajax/inventoryprocessing.ajax.php',
        method: 'GET',  // Use the appropriate HTTP method, e.g., GET or POST
        data: { id: itemId, type: type },
        dataType: 'json',
        success: function (data) {
          if(data.status=="success"){
            swal({
              type: "success",
              title: "SUCCESS",
              text: "Item has been succesfully deleted!",
              showConfirmButton: true,
              confirmButtonText: "Ok"
          }).then(function(result) {
            window.location.href = "inventory"; 
          });
          }else{
            swal({
              type: "error",
              title: "ERROR",
              text: data.message,
              showConfirmButton: true,
              confirmButtonText: "Ok"
          }).then(function(result) {
              if (result.isConfirmed) {
                  // Optionally, you can redirect or perform another action here
              }
          });
          }
        }, 
        error: function () {
          alert('Error processing the request.');
        }
        })
    }
  }).catch(function(error) {
    console.log("Error: ", error);  // Log any errors that might occur
  });
});












  
