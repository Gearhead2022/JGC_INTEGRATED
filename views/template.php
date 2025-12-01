<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8"/>
  <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
  <meta name="description" content=""/>
  <meta name="author" content=""/>
  <title>JGC INTEGRATED</title>
  <link rel="icon" href="views/img/JGC.png" type="image/x-icon">
  <link href="views/assets/plugins/fullcalendar/css/fullcalendar.min.css" rel='stylesheet'/>

  <!-- simplebar CSS-->
  <link href="views/assets/plugins/simplebar/css/simplebar.css" rel="stylesheet"/>
  <link href="views/assets/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="views/assets/css/animate.css" rel="stylesheet" type="text/css"/>
  <link href="views/assets/css/icons.css" rel="stylesheet" type="text/css"/>
  <link href="views/assets/css/app-style.css" rel="stylesheet"/>
  <link href="views/assets/css/sidebar-menu.css" rel="stylesheet"/>
  <link href="views/assets/plugins/vectormap/jquery-jvectormap-2.0.2.css" rel="stylesheet"/>
  <link href="views/assets/css/myowncss.css" rel="stylesheet"/>
  <link href="views/assets/css/index.css" rel="stylesheet"/>
  <link href="views/assets/css/components.min.css" rel="stylesheet" type="text/css">
  <link href="views/assets/css/permit.css?v=1.0.0" rel="stylesheet"/>

 
  
  <link href="views/assets/plugins/bootstrap-datatable/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css">
  <link href="views/assets/plugins/bootstrap-datatable/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css">

  <link href="views/assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css">
  <link href="views/assets/plugins/bootstrap-touchspin/css/jquery.bootstrap-touchspin.css" rel="stylesheet" type="text/css">
  <link href="views/assets/plugins/inputtags/css/bootstrap-tagsinput.css" rel="stylesheet" />
  <link href="views/assets/plugins/jquery-multi-select/multi-select.css" rel="stylesheet" type="text/css">
  <link href="views/assets/plugins/select2/css/select2.min.css" rel="stylesheet"/>
  <link href="views/assets/plugins/switchery/css/switchery.min.css" rel="stylesheet" />
  <link href="views/assets/plugins/vectormap/jquery-jvectormap-2.0.2.css" rel="stylesheet"/>
  <script src="views/assets/plugins/sweetalert2/sweetalert2.all.js"></script>.
  
   <!-- google charts -->
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <style>
      .notification-main {
        position:absolute;
        top: 125px;
        left: 28rem;
        cursor: move;
        background-color: #23864e;
        padding: 7px;
        border-radius: 10px;
        color: white;
        z-index: 1000;
      }
      .notification-main p{
        margin: 0px;
      }

  .notification-main .counter {
    display: flex;
    justify-content: center;
    border-radius: 100%;
    background-color: red;
    padding: 5px;
    width: 35px;
    height: 40px;
    font-size: 1.4em;
    font-weight: bold;
}
.note-box{
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 5px;
}
.note-text{
  font-size: 1.1em;
}
@media (max-width: 639px) {
  .notification-main{
    top: 0.2rem;
    left: 3.5rem;
  }
}
  </style>

</head>

<script> 
const ws = new WebSocket('wss://jgcintegratedsystems.com/ws/');
const type = "<?= $_SESSION['type'] ?>"; // injected from PHP page
const username = "<?= $_SESSION['username'] ?>"; // injected from PHP page


if(username === "CGN"){
  setInterval(fetchNotifications1, 1500);
}

ws.onopen = () => {
    console.log("✅ Connected to WebSocket1");
    // ws.send(JSON.stringify({ message: "get_notification_count", type: type }));
};

// WebSocket event handler
// Enable voice after alert interaction
let voiceEnabled = false;

if (localStorage.getItem("voiceEnabled") === "true") {
  voiceEnabled = true;
} else {
  window.addEventListener("load", () => {
    setTimeout(() => {
      alert("Voice notifications will be enabled once you click OK.");
      voiceEnabled = true;
      localStorage.setItem("voiceEnabled", "true");
    }, 1000);
  });
}
ws.onmessage = (event) => {
    const data = JSON.parse(event.data);
    if (data.type === 'notification_count') {
        fetchNotifications1(); // Fetch sidebar or badge notifications
        // Update notification count badge
        // Reload or initialize DataTable
       
    }
};

// Notification fetch function
function fetchNotifications1() {
    fetch('ajax/permit_notification_data.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ action: 'fetch_permit_notifications' })
    })
    .then(response => response.json())
    .then(result => {
        console.log('✅ Notifications:', result);
        const counter = document.querySelector("#notificationBox .counter");
        if(result.status === 'success' ){
             const count = result.notifications['total'];
             const total_pspmi = result.notifications['total_pspmi'];
             const total_mis = result.notifications['total_mis'];
             notificationProcess(count, total_pspmi, total_mis); 
             if (total_mis > 0) {
                $('#misBtnText').text(total_mis).show();
              } else {
                $('#misBtnText').hide();
              }

              if (total_pspmi > 0) {
                $('#pspmiBtnText').text(total_pspmi).show();
              } else {
                $('#pspmiBtnText').hide();
              }
            if (counter) {
               counter.textContent = count;
            }
        }
    })
    .catch(error => {
        console.error('❌ Fetch error:', error);
    });
}

function notificationProcess(count, total_psmi, total_mis) {
  const storedCount = sessionStorage.getItem("count");
  if (storedCount !== null) {
    if (count > storedCount) {
      console.log("new request");
      // New notification received
      speakMessage("You have a new request.");
      sessionStorage.setItem("count", count);
      sessionStorage.setItem("total_psmi", total_psmi);
      sessionStorage.setItem("total_mis", total_mis);
      if ($.fn.dataTable.isDataTable('.permitTable')) {
            $('.permitTable').DataTable().ajax.reload();
        } else {
            $('.permitTable').DataTable({
                "ajax": "ajax/permit.ajax.php",
                "deferRender": true,
                "retrieve": true,
                "processing": true,
                "order": [[1, 'desc']]
            });
        }
    } else if (storedCount === count) {
        console.log("no new request same");
      speakMessage("You have no new notifications at the moment. Please check back later.");
    }else if (count < storedCount) {
      console.log("no new request");
      // No new notification
      sessionStorage.setItem("count", count);
    }
  } else {
    // First time setup
    console.log("Setting initial count in localStorage:", count);
    if(count > 0) {
      // If there are notifications, set the count
      console.log("New request on first load");
    } else {
      console.log("No new requests on first load");
    }
    sessionStorage.setItem("count", count);
  }
}

 
function speakMessage(message) {
  if (!voiceEnabled || !message) return;

  const synth = window.speechSynthesis;
  const utter = new SpeechSynthesisUtterance(message);
  utter.lang = "en-US";

  const loadAndSpeak = () => {
    const voices = synth.getVoices();

    let selectedVoice = voices.find(voice =>
      voice.lang.startsWith("en") &&
      /female|woman|Google US English/i.test(voice.name)
    ) || voices.find(voice => voice.lang.startsWith("en"));

    if (selectedVoice) {
      utter.voice = selectedVoice;
    }

    synth.cancel(); // Cancel *just* before speaking
    synth.speak(utter);
  };

  // If voices are not loaded, wait for them
  if (synth.getVoices().length === 0) {
    const fallback = setTimeout(() => {
      console.warn("Voice load timeout, using fallback");
      loadAndSpeak();
    }, 1000);

    synth.onvoiceschanged = () => {
      clearTimeout(fallback);
      loadAndSpeak();
    };
  } else {
    loadAndSpeak();
  }
}


  function fetchNotifications() {
      fetch('api/get_notifications.php', {
          method: 'POST',
          headers: {
              'Content-Type': 'application/json'
          },
          body: JSON.stringify({
              type: 'wp_approve' // or whatever type you need
          })
      })
      .then(response => response.json())
      .then(data => {
          console.log("📥 Full notifications:", data);
          // Optionally render the data in a UI component
      })
      .catch(error => {
          console.error("❌ Error fetching notifications:", error);
      });
  }



</script>

<?php 
// Array of restriction routes
$wp_user = array('clients','clientedit','clientadd','fch','pspmi','rlc','registrations','blacklist','blacklistedit',
'blacklistadd','accounts','accountedit');

$hr_user = array('registrations','blacklist','blacklistedit',
'blacklistadd','accounts','accountedit','workingpermit','workingpermitedit','workingpermitadd','request','requestedit',
'requestadd','showrequest','showrequests');

$pdr_user = array('clients','clientedit','clientadd','fch','pspmi','rlc','registrations','accounts','accountedit','workingpermit','workingpermitedit','workingpermitadd','request','requestedit',
'requestadd','showrequest','showrequests');
$type = $_SESSION['type'];


$mode = $_SESSION['mode'];
if($mode=="dark"){?>
  <body class="bg-theme bg-theme9" data-user-type="<?= htmlspecialchars($type, ENT_QUOTES, 'UTF-8') ?>">
    
    <?php
}else{ ?>

   <body class="bg-theme bg-theme7" data-user-type="<?= htmlspecialchars($type, ENT_QUOTES, 'UTF-8') ?>">
<?php } ?>

<?php if($type !== "backup_user"){?>
    <div class="notification-main" id="notificationBox" onclick="openLedgerModal()">
      <div class="note-box" id="simulateBtn">
          <div class="counter">
              0
          </div>
         <div class="note-text">
             Working Permit Request
         </div>
         <!-- <button onclick="notificationProcess(10)">Test Notification</button> -->
      </div>
    </div>

     <!-- CHECKER MODAL1 -->
     <div class="modal fade notif-modal" id="notifationData" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
              <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Working Permit Notification</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                          </button>
                  </div>
                  <div class="modal-body">
                      <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped">
                          <thead>
                            <tr>
                              <th>Action</th>
                              <th>REF NO.</th>
                              <th>Branch</th>
                              <th>Status</th>
                              <th>Date Requested</th>
                            </tr>
                          </thead>
                          <tbody class="notif-tbody">
                            <tr>
                              <td><button class="btn btn-success">VIEW</button></td>
                              <td>EMB BRANCH</td>
                              <td>July 2, 2025</td>
                              <td>Pending</td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  <div class="modal-footer">
                      <button type="button"  class="btn btn-secondary" data-dismiss="modal">Close</button>
                  </div>
                </div>
            </div>
          </div>
          <!-- END MODAL  -->

<?php } ?>



   <?php
    echo '<div id="wrapper">';  
      include "modules/header.php";
      include "modules/sidebar.php"; 
      if(isset($_GET["route"])){
             $user =  $_SESSION['type'];
             $pagenow =$_GET['route'];

            if(in_array( $pagenow, $wp_user )){
              // Now check the current user
              if ( $user == 'wp_user' || $user == 'wp_admin') {
                echo '<script>window.location = "404"</script>';
              }
            }

            if(in_array( $pagenow, $hr_user )){
              // Now check the current user
              if ( $user == 'hr_user' || $user == 'hr_admin') {
                echo '<script>window.location = "404"</script>';
              }
            }

            if(in_array( $pagenow, $pdr_user )){
              // Now check the current user
              if ( $user == 'pdr_user' || $user == 'pdr_admin') {
                echo '<script>window.location = "404"</script>';
              }
            }


        if ($_GET["route"] == 'home' || 
            $_GET["route"] == 'logout' ||
            $_GET["route"] == 'registrations' ||
            $_GET["route"] == 'clients' || 
            $_GET["route"] == 'login' ||        
            $_GET["route"] == 'clientadd' ||
            $_GET["route"] == 'pspmi' ||
            $_GET["route"] == 'fch' ||
            $_GET["route"] == 'rlc' ||
            $_GET["route"] == 'blacklist' || 
            $_GET["route"] == 'blacklistadd' ||
            $_GET["route"] == 'blacklistedit' ||
            $_GET["route"] == 'workingpermitadd' ||
            $_GET["route"] == 'workingpermit' ||
            $_GET["route"] == 'workingpermitedit' ||
            $_GET["route"] == 'showrequest' ||
            $_GET["route"] == 'showrequests' ||
            $_GET["route"] == 'requestadd' ||
            $_GET["route"] == 'request' ||
            $_GET["route"] == 'accounts' ||
            $_GET["route"] == 'accountedit' ||
            $_GET["route"] == 'requestedit' ||
            $_GET["route"] == 'showbackup' ||
            $_GET["route"] == 'backups' ||
            $_GET["route"] == 'backupedit' ||
            $_GET["route"] == 'backupadd' ||
            $_GET["route"] == 'backupfilter' ||
            $_GET["route"] == 'backupreport' ||
            $_GET["route"] == 'fullypaid' ||
            $_GET["route"] == 'fullypaidadd' ||
            $_GET["route"] == 'fullypaidedit' ||
            $_GET["route"] == 'fullypaidreport1' ||
            $_GET["route"] == 'fullypaidreport2' ||
            $_GET["route"] == 'showfullypaid' ||
             $_GET["route"] == 'fullpaidreport' ||
              $_GET["route"] == 'ticket' ||
              $_GET["route"] == 'showTicketDetails' ||
               $_GET["route"] == 'ticketarchive' ||
            $_GET["route"] == 'download' ||
             $_GET["route"] == 'documentadd' ||
             $_GET["route"] == 'filesadd' ||
            $_GET["route"] == 'try' ||
             $_GET["route"] == 'operations' ||
            $_GET["route"] == 'operationlsor' ||
            $_GET["route"] == 'operationreport' ||
            $_GET["route"] == 'operationlsoradd' ||
            $_GET["route"] == 'operationlsoredit' ||
            $_GET["route"] == 'operationlsorreport' ||
            $_GET["route"] == 'operationreturnee' ||
            $_GET["route"] == 'operationloansaging' ||
            $_GET["route"] == 'checklistadd' ||
            $_GET["route"] == 'adminStatistics' ||
            $_GET["route"] == 'statistics' ||
            $_GET["route"] == 'monthlyagentAdmin' ||
            $_GET["route"] == 'monthlyagent' ||
            $_GET["route"] == 'ChartmonthlyAgent' ||
            $_GET["route"] == 'pastdueaccntsummary' ||
            $_GET["route"] == 'adminPenStatistics' ||
            $_GET["route"] == 'branchPenStatistics' ||
            $_GET["route"] == 'branchPensionerList' ||
            $_GET["route"] == 'operationSP' ||
            $_GET["route"] == 'operationSPList' ||
            $_GET["route"] == 'branchSP' ||
            $_GET["route"] == 'operationAPH' ||
            $_GET["route"] == 'operationACOME' ||
            $_GET["route"] == 'branchAPH' ||
            $_GET["route"] == 'insurance' ||
            $_GET["route"] == 'branchAnnualTargetList' ||
            $_GET["route"] == 'clientedit' ||
            $_GET["route"] == 'branchDTRUpload' ||
            $_GET["route"] == 'branchTimeInDTRUpload' ||
            $_GET["route"] == 'hrDTRDownload' ||
            $_GET["route"] == 'hrTimeInDTRDownLoad' ||
            $_GET["route"] == 'access' ||
            $_GET["route"] == 'branchReceiptPrinting' ||
            $_GET["route"] == 'branchCollectionReceipt' ||
            $_GET["route"] == 'sqltodbf' ||
            $_GET["route"] == 'branchPDRColl' ||
            $_GET["route"] == 'branchPDRCollArchive' ||
            $_GET["route"] == 'branchPDRLedger' ||
            $_GET["route"] == 'branchPDRShowLedger' ||
            $_GET["route"] == 'branchSOA' ||
            $_GET["route"] == 'pastdue'||
     	      $_GET["route"] == 'ledger'||
      	    $_GET["route"] == 'badaccounts'||
       	    $_GET["route"] == 'pastdueaccntsummary'||
      	    $_GET["route"] == 'pastdueadd'||
      	    $_GET["route"] == 'pastdueclassreport'||
            $_GET["route"] == 'pastdueedit'||
     	      $_GET["route"] == 'pastdueledger'||
      	    $_GET["route"] == 'pastduesummary'||
      	    $_GET["route"] == 'pastduetarget'||
      	    $_GET["route"] == 'pastdueweeklyreport'||
            $_GET["route"] == 'showpastdue'||
            $_GET["route"] == 'adminBackupDelete'||
            $_GET["route"] == 'inventory' ||
              $_GET["route"] == 'adminrequest' ||
            $_GET["route"] == 'fernet' || 
            $_GET["route"] == 'dataBackup'){
                
          include "modules/".$_GET["route"].".php";
        }else{
           include "modules/404.php";
        }
      }else{
        include "modules/home.php";
      }
    echo '</div>';
  ?>

  <script src="views/assets/js/jquery.min.js"></script>
  <script src="views/assets/js/popper.min.js"></script>
  <script src="views/assets/js/bootstrap.min.js"></script>
  <script src="views/assets/js/sidebar-menu.js"></script>
  <script src="views/assets/js/app-script.js"></script>
  
  
  

  <script src="views/assets/js/myownjs.js"></script>
  <script src="views/assets/plugins/apexcharts/apexcharts.js"></script>
  <script src="views/assets/plugins/bootstrap-datatable/js/jquery.dataTables.min.js"></script>
  <script src="views/assets/plugins/bootstrap-datatable/js/dataTables.bootstrap4.min.js"></script>
  <script src="views/assets/plugins/bootstrap-datatable/js/dataTables.buttons.min.js"></script>
  <script src="views/assets/plugins/bootstrap-datatable/js/buttons.bootstrap4.min.js"></script>
  <script src="views/assets/plugins/bootstrap-datatable/js/jszip.min.js"></script>
  <script src="views/assets/plugins/bootstrap-datatable/js/pdfmake.min.js"></script>
  <script src="views/assets/plugins/bootstrap-datatable/js/vfs_fonts.js"></script>
  <script src="views/assets/plugins/bootstrap-datatable/js/buttons.html5.min.js"></script>
  <script src="views/assets/plugins/bootstrap-datatable/js/buttons.print.min.js"></script>
  <script src="views/assets/plugins/bootstrap-datatable/js/buttons.colVis.min.js"></script>


  <script src="views/assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>

  <script src="views/assets/plugins/bootstrap-touchspin/js/jquery.bootstrap-touchspin.js"></script>
  <script src="views/assets/plugins/bootstrap-touchspin/js/bootstrap-touchspin-script.js"></script>  
  <script src="views/assets/plugins/bootstrap-switch/bootstrap-switch.min.js"></script>

  <script src="views/assets/plugins/Chart.js/Chart.min.js"></script>
  <script src="views/assets/plugins/inputtags/js/bootstrap-tagsinput.js"></script>
  <script src="views/assets/plugins/jquery.easy-pie-chart/jquery.easypiechart.min.js"></script>

  <script src="views/assets/plugins/jquery-multi-select/jquery.multi-select.js"></script>
  <script src="views/assets/plugins/jquery-multi-select/jquery.quicksearch.js"></script>

  <script src="views/assets/plugins/jquery-knob/excanvas.js"></script>
  <script src="views/assets/plugins/jquery-knob/jquery.knob.js"></script>
  <script src="views/assets/plugins/number/jquery.number.js"></script>

  <script src="views/assets/plugins/select2/js/select2.min.js"></script>
  <script src="views/assets/plugins/simplebar/js/simplebar.js"></script>
  <script src="views/assets/plugins/sparkline-charts/jquery.sparkline.min.js"></script>
  <script src="views/assets/plugins/switchery/js/switchery.min.js"></script>
  <script src="views/assets/plugins/vectormap/jquery-jvectormap-2.0.2.min.js"></script>
  <script src="views/assets/plugins/vectormap/jquery-jvectormap-world-mill-en.js"></script>

  <script src="views/js/backup.js"></script>
  <script src="views/js/login.js"></script>
  <script src="views/js/insurance.js"></script>
   <script src="views/js/ticket.js"></script>
    <script src="views/js/fullypaid.js"></script>
  <script src="views/js/clients.js"></script>
  <script src="views/js/account.js"></script>
  <script src="views/js/request.js"></script>
  <script src="views/js/permit.js?v=1.0.0"></script>
  <script src="views/js/blacklist.js"></script>
  <script src="views/js/rlc.js"></script>
  <script src="views/js/pspmi.js"></script>
  <script src="views/js/fch.js"></script>
  <script src="views/js/index.js"></script>
  <script src="views/js/try.js"></script>
 <script src="views/js/operations.js"></script>
  <script src="views/js/operation_john.js"></script>
  <script src="views/js/pensioner.js"></script>
   <script src="views/js/dtr.js"></script>
    <script src="views/js/or_printing.js"></script>
     <script src="views/js/pdrcollection.js"></script>
      <script src="views/js/soa.js"></script>
      <script src="views/js/pastdue.js"></script>
      <script src="views/js/inventory.js"></script>
      <script src="views/js/data_backup.js"></script>

  <script>
     $(document).ready(function() {
      fetchNotifications1();
      //Default data table
       $('#default-datatable').DataTable();


       var table = $('#example').DataTable( {
        lengthChange: false,
        buttons: [ 'copy', 'excel', 'pdf', 'print', 'colvis' ]
      } );
 
     table.buttons().container()
        .appendTo( '#example_wrapper .col-md-6:eq(0)' );
      
      } );

      //For Draggin

const box = document.getElementById("notificationBox");
  let offsetX, offsetY, isDragging = false;

  // Load saved position from localStorage
  const savedPosition = JSON.parse(localStorage.getItem("notificationBoxPos"));
  if (savedPosition) {
    box.style.left = savedPosition.left + "px";
    box.style.top = savedPosition.top + "px";
  }

  // Mouse down: start dragging
  box.addEventListener("mousedown", (e) => {
    isDragging = true;
    offsetX = e.clientX - box.offsetLeft;
    offsetY = e.clientY - box.offsetTop;
  });

  // Mouse move: update position
  document.addEventListener("mousemove", (e) => {
    if (isDragging) {
      const left = e.clientX - offsetX;
      const top = e.clientY - offsetY;
      box.style.left = left + "px";
      box.style.top = top + "px";

      // Save position temporarily during drag
      localStorage.setItem("notificationBoxPos", JSON.stringify({ left, top }));
    }
  });

  // Mouse up: stop dragging
  document.addEventListener("mouseup", () => {
    isDragging = false;
  });
  </script> 

  <script>
      $(function() {
          $(".knob").knob();
      });
  </script> 

  <script>
    $('#default-datepicker').datepicker({
      todayHighlight: true
    });
    $('#autoclose-datepicker').datepicker({
      autoclose: true,
      todayHighlight: true
    });

    $('#inline-datepicker').datepicker({
       todayHighlight: true
    });

    $('#dateragne-picker .input-daterange').datepicker({
     });
  </script>

  <script>
      $(document).ready(function() {
          $('.single-select').select2();
          $('.multiple-select').select2();

          $('#my_multi_select1').multiSelect();
          $('#my_multi_select2').multiSelect({
              selectableOptgroup: true
          });

          $('#my_multi_select3').multiSelect({
              selectableHeader: "<input type='text' class='form-control search-input' autocomplete='off' placeholder='search...'>",
              selectionHeader: "<input type='text' class='form-control search-input' autocomplete='off' placeholder='search...'>",
              afterInit: function (ms) {
                  var that = this,
                      $selectableSearch = that.$selectableUl.prev(),
                      $selectionSearch = that.$selectionUl.prev(),
                      selectableSearchString = '#' + that.$container.attr('id') + ' .ms-elem-selectable:not(.ms-selected)',
                      selectionSearchString = '#' + that.$container.attr('id') + ' .ms-elem-selection.ms-selected';

                  that.qs1 = $selectableSearch.quicksearch(selectableSearchString)
                      .on('keydown', function (e) {
                          if (e.which === 40) {
                              that.$selectableUl.focus();
                              return false;
                          }
                      });

                  that.qs2 = $selectionSearch.quicksearch(selectionSearchString)
                      .on('keydown', function (e) {
                          if (e.which == 40) {
                              that.$selectionUl.focus();
                              return false;
                          }
                      });
              },
              afterSelect: function () {
                  this.qs1.cache();
                  this.qs2.cache();
              },
              afterDeselect: function () {
                  this.qs1.cache();
                  this.qs2.cache();
              }
          });

       $('.custom-header').multiSelect({
            selectableHeader: "<div class='custom-header'>Selectable items</div>",
            selectionHeader: "<div class='custom-header'>Selection items</div>",
            selectableFooter: "<div class='custom-header'>Selectable footer</div>",
            selectionFooter: "<div class='custom-header'>Selection footer</div>"
          });

        });
  </script>  

  <!--Switchery Js-->
  <script>
    var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
    $('.js-switch').each(function() {
          new Switchery($(this)[0], $(this).data());
     });
  </script>
  
  <!--Bootstrap Switch Buttons-->
  <script>
    
    $(".bt-switch input[type='checkbox'], .bt-switch input[type='radio']").bootstrapSwitch();
    var radioswitch = function() {
        var bt = function() {
            $(".radio-switch").on("switch-change", function() {
                $(".radio-switch").bootstrapSwitch("toggleRadioState")
            }), $(".radio-switch").on("switch-change", function() {
                $(".radio-switch").bootstrapSwitch("toggleRadioStateAllowUncheck")
            }), $(".radio-switch").on("switch-change", function() {
                $(".radio-switch").bootstrapSwitch("toggleRadioStateAllowUncheck", !1)
            })
        };
        return {
            init: function() {
                bt()
            }
        }
    }();
    $(document).ready(function() {
        radioswitch.init()
    });
  </script>


<!--   Activating this JS file will result to:
    1. Go to top button visible only on home.php
    2. header remain transparent when scrolling page upward - except home.php --> 


  <script src='views/assets/plugins/fullcalendar/js/moment.min.js'></script>
  <script src='views/assets/plugins/fullcalendar/js/fullcalendar.min.js'></script>
  <script src="views/assets/plugins/fullcalendar/js/calendaring.js"></script>  
  <!-- <script src="views/js/calendaring.js"></script>   -->

</body>
</html>