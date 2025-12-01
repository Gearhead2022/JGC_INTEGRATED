let currentType = "";


const userType = document.body.dataset.userType;
// Optional assignment

if(userType === "wp_pspmi" || userType === "wp_pspmi_admin" ){
  currentType = "PSPMI";
  // redirectWithType(userType);
}

  var permitTable = $('.permitTable').DataTable({
    "ajax": {
      "url": "ajax/permit.ajax.php",
      "type": "GET",
      "data": function (d) {
        // this will be updated before each reload
        d.filterDate = document.getElementById('filterDate').value;
        d.filterType = currentType; // send the selected type
      }
    },
    "deferRender": true,
    "retrieve": true,
    "processing": true,
    "order": [1, 'desc']
  });

$("#rlc_add").on("click", function(){

  window.location = "index.php?route=clientadd&type=RLC";
})
$(".permitTable").on("click", "tbody .btnShowRequest", function(){
  var idClient = $(this).attr("idClient");
  window.location = "index.php?route=showrequest&idClient="+idClient;
})
$(".permitTable").on("click", "tbody .btnEditShowClient", function(){
  var idClient = $(this).attr("idClient");
  window.location = "index.php?route=showrequest&idClient="+idClient;
})

$(".permitTable").on("click", "tbody .btnEditClient", function(){
  var idClient = $(this).attr("idClient");
  var type = $(this).attr("type");
  window.location = "index.php?route=workingpermitedit&idClient="+idClient;
})

$(".rlcTable").on("click", "tbody .btnEditShowClient", function(){
  var idClient = $(this).attr("idClient");
  var type = $(this).attr("type");
  $.ajax({
    url: 'ajax/clients.show.php',
    type: 'post',
    data: {idClient: idClient, type: type},
    success: function(response){ 
       // Add response in Modal body
       $('.modal-body').html(response);

       // Display Modal
       $('#empModal').modal('show'); 
    }
 });
 
})

$(".permitTable").on("click", "tbody .btnDeleteClient", function(){
  var idClient = $(this).attr("idClient");
  var ref_id = $(this).attr("ref_id");
  swal({
        title: 'Do you want to delete this account?',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'cancel',
        confirmButtonText: 'Yes'
      }).then(function(result){
        if (result.value) { 
          window.location = "index.php?route=workingpermit&idClient="+idClient+"&ref_id="+ref_id;
        }


  })
})
$(".dlt_img").on("click", function(){
  var img_name = $(this).attr("img_name");
  var idClient = $(this).attr("idClient");
  swal({
        title: 'Do you want to delete this image?',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'cancel',
        confirmButtonText: 'Yes'
      }).then(function(result){
        if (result.value) {
            window.location = "index.php?route=workingpermitedit&img_name="+img_name+"&idClient="+idClient;
        }
  })
})
$("#done_records").on("click", function(){
  var idClient = $(this).attr("idClient");
  var status = $(this).attr("status");
  var wp_remarks = document.getElementById("wp_remarks").value;
  swal({
        title: 'Are you sure that this request is already done?',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'cancel',
        confirmButtonText: 'Yes'
      }).then(function(result){
        if (result.value) {
          window.location = "index.php?route=showrequest&idClient="+idClient+"&status="+status+"&wp_remarks="+wp_remarks;
        }
  })
})


$("#btn_rlc").on("click", function(){

  var company = "RLC";

 window.open("extensions/tcpdf/pdf/emb_report.php?company="+company);
  
})


$("#approve_records").on("click", function(){
  var idClient = $(this).attr("idClient");
  var user = $(this).attr("user");
  swal({
        title: 'Are you sure you want to approve this request?',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'cancel',
        confirmButtonText: 'Yes'
      }).then(function(result){
        if (result.value) {
          window.location = "index.php?route=showrequest&idClient="+idClient+"&user="+user;
        }
  })
})
$("#check_records").on("click", function(){
  var idClient = $(this).attr("idClient");
  var user = $(this).attr("user");
  swal({
        title: 'Are you sure you want to approve this request?',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'cancel',
        confirmButtonText: 'Yes'
      }).then(function(result){
        if (result.value) {
          window.location = "index.php?route=showrequest&idClient="+idClient+"&chk=ok";
        }
  })
})


$("#reject_records").on("click", function(){
  var idClient = $(this).attr("idClient");
  var user = $(this).attr("user");
  swal({
        title: 'Are you sure you want to reject this request?',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'cancel',
        confirmButtonText: 'Yes'
      }).then(function(result){
        if (result.value) {
          window.location = "index.php?route=showrequest&idClient="+idClient+"&reject=ok";
        }
  })
})

$('.filterButton').on('click', function(){
  var filterDate1 = document.getElementById('filterDate');
      $('.permitTable').DataTable().ajax.reload();
});


$('#receive_records').on('click', function(){
  const idClient = $(this).attr("idClient");
  const user = $(this).attr("user");

  swal({
    title: 'Are you sure you want to receive this request?',
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    cancelButtonText: 'cancel',
    confirmButtonText: 'Yes'
  }).then(function(result){
    if (result.value) {
      window.location = "index.php?route=showrequest&idClient="+idClient+"&user="+user+"&receive=ok";
    }
})
})



function openLedgerModal() {
  $('#notifationData').modal('show');
  $('.notif-tbody').empty();
 $.ajax({
  url: 'API/permit.api.php?action=fetch_permits', // Adjust path as needed
  method: 'GET',
  dataType: 'json',
  success: function(response) {
    const type = response.type;
    const permits = response.permits;
    permits.forEach(function(item) {
      const status = item.status;
      const formattedDate = item.wp_date.split(' ').slice(0, 3).join(' ');
      let btn ="";
      let $statusDisplay = "";
        if( type === "wp_accounting" 
            || type === "wp_operation"
            || type === "wp_hrom" 
            || type === "wp_financial"
            || type === "wp_audit"
            || type === "wp_credit"
            || type === "wp_grcd"
            || type === "wp_pspmi")
            {
         btn = `<button class="btn btn-sm btn-info btnEditClient1" idClient="${item.id}">   VERIFY  </button>`;
        }else{
         btn = `<button class="btn btn-success btn-sm btnShowRequest1" idClient="${item.id}">   VIEW  </button>`;
        }

        if (status === "Pending") {
          statusDisplay = "<span class='badge badge-danger'>Pending</span>";
        }else if (status === "P-Approved" || status === "Inprogress") {
          statusDisplay = "<span class='badge badge-info'>Inprogress</span>";
        }
      let row = `
        <tr>
         <td>
            ${btn}
        </td>
          <td>${item.ref_id}</td>
          <td>${item.branch}</td>
          <td>${statusDisplay}</td>
          <td>${formattedDate}</td>
        </tr>
      `;
      $('.notif-tbody').append(row);
    });
  },
  error: function(xhr, status, error) {
    $('.notif-tbody').append(`<tr><td colspan="4">Failed to load data</td></tr>`);
    console.error(error);
  }
});

}


$(document).on('click', '.btnShowRequest1', function () {
var idClient = $(this).attr('idClient');
window.location.href = "index.php?route=showrequest&idClient=" + idClient;
});

$(document).on('click', '.btnEditClient1', function () {
var idClient = $(this).attr('idClient');
window.location = "index.php?route=workingpermitedit&idClient="+idClient;
});



function redirectWithType(type) {
  currentType = type;
  if(currentType === "MIS"){
    $('.approveChange').text('Approved by EGG');
  }else{
    $('.approveChange').text('Approved by MRMG');
  }

  document.querySelectorAll('.btnCategory').forEach(btn => {
    btn.classList.remove('active-category');
  });

  const clickedBtn = document.querySelector(`.btnCategory[onclick="redirectWithType('${type}')"]`);
  if (clickedBtn) clickedBtn.classList.add('active-category');

  $('.permitTable').DataTable().ajax.reload();
}

$('#wp_to').on('change', function () {
  const wp_to = $(this).val();
  let ref_id = $('#ref_id').val();
  let  wp_app_by1 = $('#wp_app_by1').val();

  if (wp_to === "MIS DEPARTMENT") {
    ref_id = ref_id.replace(/^PF/, 'WP');
    wp_app_by1 = "Edgardo G. Guerrero Jr.";
  } else {
      ref_id = ref_id.replace(/^WP/, 'PF');
      wp_app_by1 = "Ma. Rizza M. Guino-o";
  }

  $('#ref_id').val(ref_id); 
  $('#wp_app_by1').val(wp_app_by1); 
});
