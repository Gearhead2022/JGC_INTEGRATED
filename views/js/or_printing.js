
$(document).ready(function () {

  $(".generateList").on("click", function () {
    var collDate = document.getElementById('collDate').value;

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

    var table = $('.collectionDataList').DataTable();

    // Clear the existing data
    table.clear().draw();

    $.ajax({
      url: 'ajax/collectionList.ajax.php',
      type: 'GET',
      data: { collDate: collDate },
      dataType: 'json',
      success: function (data) {
        swal.close();

        if (data.data.length > 0) {
          // Add new data to the table
          table.rows.add(data.data).draw();
        } else {
          // Show a message or handle empty data as needed
          swal({
            type: "warning",
            title: 'No Records Found in Coll. Date<u> ' + collDate + '</u>',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'cancel',
            confirmButtonText: 'OK'
          }).then(function (result) {
            if (result.value) {

            }

          });
        }
      },
      error: function () {
        swal.close();
        swal({
          type: "warning",
          title: 'No Records Found in Coll. Date<u> ' + collDate + '</u>',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          cancelButtonText: 'cancel',
          confirmButtonText: 'OK'
        }).then(function (result) {
          if (result.value) {

          }

        });
      }
    });
  });


  $(".collectionDataList").on("click", "tbody .btnEditColl", function () {

    var account_id = $(this).attr("account_id");
    var cdate = $(this).attr("cdate");

    $('#editReceiptPrinting .modal-body').empty();

    $.ajax({
      url: 'ajax/editCollectionReceipt.ajax.php',
      data: {
        account_id: account_id, cdate: cdate
      },
      dataType: 'json',
      success: function (data) {

        $.each(data, function (index, item) {
          var card = item.card;
          $('#editReceiptPrinting .modal-body').append(card);
        });
        $('#editReceiptPrinting').modal('show');

      },
      error: function () {
        swal({
          type: "warning",
          title: 'No Records Found in ID <u>' + account_id + '</u>',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          cancelButtonText: 'cancel',
          confirmButtonText: 'OK'
        }).then(function (result) {
          if (result.value) {

          }

        });
      }
    });

  })

  $(".generateReceiptList").on("click", function () {
    var collDate = document.getElementById('collDate').value;

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
      url: 'ajax/collectionReceiptList.ajax.php',
      type: 'GET', // Use GET method as per your PHP code
      data: { collDate: collDate },
      dataType: 'json',
      success: function (data) {

        swal.close();
        if (data.data.length > 0) {
          var table = $('.receiptPrinting').DataTable();
          table.clear().draw(); // Clear existing table data
          table.rows.add(data.data); // Add new data to the table
          // table.columns.adjust().draw(); // Redraw the table
          table.order([0, 'desc']).draw();
        } else {
          // Show a message or handle empty data as needed
          $('.receiptPrinting').DataTable().clear().draw(); // Clear the table if there's no data
          swal({
            type: "warning",
            title: 'No Records Found in Coll. Date<u> ' + collDate + '</u>',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'cancel',
            confirmButtonText: 'OK'
          }).then(function (result) {
            if (result.value) {

            }

          });
        }
      },
      error: function () {
        swal.close();
        swal({
          type: "warning",
          title: 'No Records Found in Coll. Date<u> ' + collDate + '</u>',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          cancelButtonText: 'cancel',
          confirmButtonText: 'OK'
        }).then(function (result) {
          if (result.value) {

          }

        });
      }
    });
  });

  $(".receiptPrinting").on("click", "tbody .btnEditReceipt", function () {

    var account_id = $(this).attr("account_id");
    var tdate = $(this).attr("tdate");

    $('#printReceipts .modal-body').empty();

    $.ajax({
      url: 'ajax/printCollectionReceipt.ajax.php',
      data: {
        account_id: account_id, tdate: tdate
      },
      dataType: 'json',
      success: function (data) {

        $.each(data, function (index, item) {
          var card = item.card;
          $('#printReceipts .modal-body').append(card);
        });
        $('#printReceipts').modal('show');

      },
      error: function () {
        swal({
          type: "warning",
          title: 'No Records Found in ID <u>' + account_id + '</u>',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          cancelButtonText: 'cancel',
          confirmButtonText: 'OK'
        }).then(function (result) {
          if (result.value) {

          }

        });
      }
    });

  });

  $(".receiptPrinting").on("click", "tbody .btnDeleteReceipt", function () {

    var account_id = $(this).attr("account_id");
    var tdateString = $(this).attr("tdate");
    var id = $(this).attr("id");

    // Parse the date using Moment.js
    var tdate = moment(tdateString);

    // Format the date as a string
    var formattedDate = tdate.format('YYYY-MM-DD'); // Adjust the format as needed

    swal({
      title: 'Are you sure you want to delete account no.' + account_id + ' in collection date ' + formattedDate + '?',
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      cancelButtonText: 'cancel',
      confirmButtonText: 'Yes'
    }).then(function (result) {
      if (result.value) {
        window.location = "index.php?route=branchReceiptPrinting&tdate=" + tdateString + "&account_id=" + account_id + "&id=" + id;
      }
    });
  });

  $(".printOR").on("click", function () {
    var input2 = document.getElementById('account_id');
    var account_id = input2.value;
    var input1 = document.getElementById('tdate');
    var tdate = input1.value;
    var input3 = document.getElementById('branch_name');
    var branch_name = input3.value;
    // window.open("extensions/tcpdf/pdf/print_Officialreceipt.php?branch_name="+branch_name+"&account_id="+account_id+"&tdate="+tdate);

    var printOR = 'extensions/tcpdf/pdf/print_OfficialReceipt.php?branch_name=' + encodeURIComponent(branch_name) + '&account_id=' + encodeURIComponent(account_id) + '&tdate=' + encodeURIComponent(tdate);

    var iframe = document.createElement('iframe');
    iframe.style.display = 'none';
    iframe.src = printOR;
    document.body.appendChild(iframe);

    iframe.onload = function () {
      iframe.contentWindow.focus();
      iframe.contentWindow.print();
    };

  })

  $(".batchPrintOR").on("click", function () {
    var input2 = document.getElementById('batch_branch_name');
    var branch_name = input2.value;
    var input1 = document.getElementById('batch_coll_date');
    var tdate = input1.value;
    // window.open("extensions/tcpdf/pdf/print_BatchOfficialReceipt.php?branch_name="+branch_name+"&tdate="+tdate);

    var batchPrintOR = 'extensions/tcpdf/pdf/print_BatchOfficialReceipt.php?branch_name=' + encodeURIComponent(branch_name) + '&tdate=' + encodeURIComponent(tdate);

    var iframe = document.createElement('iframe');
    iframe.style.display = 'none';
    iframe.src = batchPrintOR;
    document.body.appendChild(iframe);

    iframe.onload = function () {
      iframe.contentWindow.focus();
      iframe.contentWindow.print();
    };

  })

  // Old Format 

  $(".printOROldFormat").on("click", function () {
    var input2 = document.getElementById('account_id');
    var account_id = input2.value;
    var input1 = document.getElementById('tdate');
    var tdate = input1.value;
    var input3 = document.getElementById('branch_name');
    var branch_name = input3.value;
    // window.open("extensions/tcpdf/pdf/print_OfficialReceiptOldFormat.php?branch_name="+branch_name+"&account_id="+account_id+"&tdate="+tdate);

    var printOROldFormat = 'extensions/tcpdf/pdf/print_OfficialReceiptOldFormat.php?branch_name=' + encodeURIComponent(branch_name) + '&account_id=' + encodeURIComponent(account_id) + '&tdate=' + encodeURIComponent(tdate);

    var iframe = document.createElement('iframe');
    iframe.style.display = 'none';
    iframe.src = printOROldFormat;
    document.body.appendChild(iframe);

    iframe.onload = function () {
      iframe.contentWindow.focus();
      iframe.contentWindow.print();
    };

  })

  $(".batchPrintOROldFormat").on("click", function () {
    var input2 = document.getElementById('batch_branch_name');
    var branch_name = input2.value;
    var input1 = document.getElementById('batch_coll_date');
    var tdate = input1.value;
    // window.open("extensions/tcpdf/pdf/print_BatchOfficialReceiptOldFormat.php?branch_name="+branch_name+"&tdate="+tdate);

    var batchPrintOROldFormat = 'extensions/tcpdf/pdf/print_BatchOfficialReceiptOldFormat.php?branch_name=' + encodeURIComponent(branch_name) + '&tdate=' + encodeURIComponent(tdate);

    var iframe = document.createElement('iframe');
    iframe.style.display = 'none';
    iframe.src = batchPrintOROldFormat;
    document.body.appendChild(iframe);

    iframe.onload = function () {
      iframe.contentWindow.focus();
      iframe.contentWindow.print();
    };
  })

  // For ELC BULACAN //
  $(".printELCORFormat").on("click", function () {
    var input2 = document.getElementById('account_id');
    var account_id = input2.value;
    var input1 = document.getElementById('tdate');
    var tdate = input1.value;
    var input3 = document.getElementById('branch_name');
    var branch_name = input3.value;
    // window.open("extensions/tcpdf/pdf/print_ELCOfficialReceipt.php?branch_name="+branch_name+"&account_id="+account_id+"&tdate="+tdate);

    var printELCORFormat = 'extensions/tcpdf/pdf/print_ELCOfficialReceipt.php?branch_name=' + encodeURIComponent(branch_name) + '&account_id=' + encodeURIComponent(account_id) + '&tdate=' + encodeURIComponent(tdate);

    var iframe = document.createElement('iframe');
    iframe.style.display = 'none';
    iframe.src = printELCORFormat;
    document.body.appendChild(iframe);

    iframe.onload = function () {
      iframe.contentWindow.focus();
      iframe.contentWindow.print();
    };
  })

  $(".printELCORFormat2").on("click", function () {
    var input2 = document.getElementById('account_id');
    var account_id = input2.value;
    var input1 = document.getElementById('tdate');
    var tdate = input1.value;
    var input3 = document.getElementById('branch_name');
    var branch_name = input3.value;
    // window.open("extensions/tcpdf/pdf/print_ELCOfficialReceipt2.php?branch_name="+branch_name+"&account_id="+account_id+"&tdate="+tdate);

    var printELCORFormat = 'extensions/tcpdf/pdf/print_ELCOfficialReceipt2.php?branch_name=' + encodeURIComponent(branch_name) + '&account_id=' + encodeURIComponent(account_id) + '&tdate=' + encodeURIComponent(tdate);

    var iframe = document.createElement('iframe');
    iframe.style.display = 'none';
    iframe.src = printELCORFormat;
    document.body.appendChild(iframe);

    iframe.onload = function () {
      iframe.contentWindow.focus();
      iframe.contentWindow.print();
    };
  })

  $(".printBatchELCORFormat").on("click", function () {
    var input2 = document.getElementById('batch_branch_name');
    var branch_name = input2.value;
    var input1 = document.getElementById('batch_coll_date');
    var tdate = input1.value;
    // window.open("extensions/tcpdf/pdf/print_BatchELCOfficialReceipt.php?branch_name="+branch_name+"&tdate="+tdate);

    var printBatchELCORFormat = 'extensions/tcpdf/pdf/print_BatchELCOfficialReceipt.php?branch_name=' + encodeURIComponent(branch_name) + '&tdate=' + encodeURIComponent(tdate);

    var iframe = document.createElement('iframe');
    iframe.style.display = 'none';
    iframe.src = printBatchELCORFormat;
    document.body.appendChild(iframe);

    iframe.onload = function () {
      iframe.contentWindow.focus();
      iframe.contentWindow.print();
    };
  })

  $(".printBatchELCORFormat2").on("click", function () {
    var input2 = document.getElementById('batch_branch_name');
    var branch_name = input2.value;
    var input1 = document.getElementById('batch_coll_date');
    var tdate = input1.value;
    // window.open("extensions/tcpdf/pdf/print_BatchELCOfficialReceipt2.php?branch_name="+branch_name+"&tdate="+tdate);

    var printBatchELCORFormat = 'extensions/tcpdf/pdf/print_BatchELCOfficialReceipt2.php?branch_name=' + encodeURIComponent(branch_name) + '&tdate=' + encodeURIComponent(tdate);

    var iframe = document.createElement('iframe');
    iframe.style.display = 'none';
    iframe.src = printBatchELCORFormat;
    document.body.appendChild(iframe);

    iframe.onload = function () {
      iframe.contentWindow.focus();
      iframe.contentWindow.print();
    };
  })

  // For M2 CARLOTA //
  $(".printM2ORFormat").on("click", function () {
    var input2 = document.getElementById('account_id');
    var account_id = input2.value;
    var input1 = document.getElementById('tdate');
    var tdate = input1.value;
    var input3 = document.getElementById('branch_name');
    var branch_name = input3.value;
    // window.open("extensions/tcpdf/pdf/print_M2OfficialReceipt.php?branch_name="+branch_name+"&account_id="+account_id+"&tdate="+tdate);

    var printM2ORFormat = 'extensions/tcpdf/pdf/print_M2OfficialReceipt.php?branch_name=' + encodeURIComponent(branch_name) + '&account_id=' + encodeURIComponent(account_id) + '&tdate=' + encodeURIComponent(tdate);

    var iframe = document.createElement('iframe');
    iframe.style.display = 'none';
    iframe.src = printM2ORFormat;
    document.body.appendChild(iframe);

    iframe.onload = function () {
      iframe.contentWindow.focus();
      iframe.contentWindow.print();
    };
  })

  $(".printBatchM2ORFormat").on("click", function () {
    var input2 = document.getElementById('batch_branch_name');
    var branch_name = input2.value;
    var input1 = document.getElementById('batch_coll_date');
    var tdate = input1.value;
    // window.open("extensions/tcpdf/pdf/print_BatchM2OfficalReceipt.php?branch_name="+branch_name+"&tdate="+tdate);

    var printBatchM2ORFormat = 'extensions/tcpdf/pdf/print_BatchM2OfficalReceipt.php?branch_name=' + encodeURIComponent(branch_name) + '&tdate=' + encodeURIComponent(tdate);

    var iframe = document.createElement('iframe');
    iframe.style.display = 'none';
    iframe.src = printBatchM2ORFormat;
    document.body.appendChild(iframe);

    iframe.onload = function () {
      iframe.contentWindow.focus();
      iframe.contentWindow.print();
    };
  })

  // For LA CARLOTA //
  $(".printLACORFormat").on("click", function () {
    var input2 = document.getElementById('account_id');
    var account_id = input2.value;
    var input1 = document.getElementById('tdate');
    var tdate = input1.value;
    var input3 = document.getElementById('branch_name');
    var branch_name = input3.value;
    // window.open("extensions/tcpdf/pdf/print_LACOfficialReceipt.php?branch_name="+branch_name+"&account_id="+account_id+"&tdate="+tdate);

    var printLACORFormat = 'extensions/tcpdf/pdf/print_LACOfficialReceipt.php?branch_name=' + encodeURIComponent(branch_name) + '&account_id=' + encodeURIComponent(account_id) + '&tdate=' + encodeURIComponent(tdate);

    var iframe = document.createElement('iframe');
    iframe.style.display = 'none';
    iframe.src = printLACORFormat;
    document.body.appendChild(iframe);

    iframe.onload = function () {
      iframe.contentWindow.focus();
      iframe.contentWindow.print();
    };
  })

  $(".printBatchLACORFormat").on("click", function () {
    var input2 = document.getElementById('batch_branch_name');
    var branch_name = input2.value;
    var input1 = document.getElementById('batch_coll_date');
    var tdate = input1.value;
    // window.open("extensions/tcpdf/pdf/print_BatchLACOfficialReceipt.php?branch_name="+branch_name+"&tdate="+tdate);

    var printBatchLACORFormat = 'extensions/tcpdf/pdf/print_BatchLACOfficialReceipt.php?branch_name=' + encodeURIComponent(branch_name) + '&tdate=' + encodeURIComponent(tdate);

    var iframe = document.createElement('iframe');
    iframe.style.display = 'none';
    iframe.src = printBatchLACORFormat;
    document.body.appendChild(iframe);

    iframe.onload = function () {
      iframe.contentWindow.focus();
      iframe.contentWindow.print();
    };
  })

  // For SAN CARLOS //
  $(".printSCAORFormat").on("click", function () {
    var input2 = document.getElementById('account_id');
    var account_id = input2.value;
    var input1 = document.getElementById('tdate');
    var tdate = input1.value;
    var input3 = document.getElementById('branch_name');
    var branch_name = input3.value;
    // window.open("extensions/tcpdf/pdf/print_SCAOfficialReceipt.php?branch_name="+branch_name+"&account_id="+account_id+"&tdate="+tdate);

    var printSCAORFormat = 'extensions/tcpdf/pdf/print_SCAOfficialReceipt.php?branch_name=' + encodeURIComponent(branch_name) + '&account_id=' + encodeURIComponent(account_id) + '&tdate=' + encodeURIComponent(tdate);

    var iframe = document.createElement('iframe');
    iframe.style.display = 'none';
    iframe.src = printSCAORFormat;
    document.body.appendChild(iframe);

    iframe.onload = function () {
      iframe.contentWindow.focus();
      iframe.contentWindow.print();
    };
  })

  $(".printBatchsCAORFormat").on("click", function () {
    var input2 = document.getElementById('batch_branch_name');
    var branch_name = input2.value;
    var input1 = document.getElementById('batch_coll_date');
    var tdate = input1.value;
    // window.open("extensions/tcpdf/pdf/print_BatchSCAOfficialReceipt.php?branch_name="+branch_name+"&tdate="+tdate);

    var printBatchsCAORFormat = 'extensions/tcpdf/pdf/print_BatchSCAOfficialReceipt.php?branch_name=' + encodeURIComponent(branch_name) + '&tdate=' + encodeURIComponent(tdate);

    var iframe = document.createElement('iframe');
    iframe.style.display = 'none';
    iframe.src = printBatchsCAORFormat;
    document.body.appendChild(iframe);

    iframe.onload = function () {
      iframe.contentWindow.focus();
      iframe.contentWindow.print();
    };
  })

  // For EMB MAMBUSAO //
  $(".printMAMORFormat").on("click", function () {
    var input2 = document.getElementById('account_id');
    var account_id = input2.value;
    var input1 = document.getElementById('tdate');
    var tdate = input1.value;
    var input3 = document.getElementById('branch_name');
    var branch_name = input3.value;
    // window.open("extensions/tcpdf/pdf/print_MAMOfficialReceipt.php?branch_name="+branch_name+"&account_id="+account_id+"&tdate="+tdate);

    var printMAMORFormat = 'extensions/tcpdf/pdf/print_MAMOfficialReceipt.php?branch_name=' + encodeURIComponent(branch_name) + '&account_id=' + encodeURIComponent(account_id) + '&tdate=' + encodeURIComponent(tdate);

    var iframe = document.createElement('iframe');
    iframe.style.display = 'none';
    iframe.src = printMAMORFormat;
    document.body.appendChild(iframe);

    iframe.onload = function () {
      iframe.contentWindow.focus();
      iframe.contentWindow.print();
    };
  })

  $(".printBatchMAMORFormat").on("click", function () {
    var input2 = document.getElementById('batch_branch_name');
    var branch_name = input2.value;
    var input1 = document.getElementById('batch_coll_date');
    var tdate = input1.value;
    // window.open("extensions/tcpdf/pdf/print_BatchMAMOfficialReceipt.php?branch_name="+branch_name+"&tdate="+tdate);

    var printBatchMAMORFormat = 'extensions/tcpdf/pdf/print_BatchSCAOfficialReceipt.php?branch_name=' + encodeURIComponent(branch_name) + '&tdate=' + encodeURIComponent(tdate);

    var iframe = document.createElement('iframe');
    iframe.style.display = 'none';
    iframe.src = printBatchMAMORFormat;
    document.body.appendChild(iframe);

    iframe.onload = function () {
      iframe.contentWindow.focus();
      iframe.contentWindow.print();
    };

  })

  // For FCH BRANCH //
  $(".printFCHORFormat").on("click", function () {
    var input2 = document.getElementById('account_id');
    var account_id = input2.value;
    var input1 = document.getElementById('tdate');
    var tdate = input1.value;
    var input3 = document.getElementById('branch_name');
    var branch_name = input3.value;
    // window.open("extensions/tcpdf/pdf/print_FCHOfficialReceipt.php?branch_name="+branch_name+"&account_id="+account_id+"&tdate="+tdate);

    var printFCHORFormat = 'extensions/tcpdf/pdf/print_FCHOfficialReceipt.php?branch_name=' + encodeURIComponent(branch_name) + '&account_id=' + encodeURIComponent(account_id) + '&tdate=' + encodeURIComponent(tdate);

    var iframe = document.createElement('iframe');
    iframe.style.display = 'none';
    iframe.src = printFCHORFormat;
    document.body.appendChild(iframe);

    iframe.onload = function () {
      iframe.contentWindow.focus();
      iframe.contentWindow.print();
    };
  })

  $(".printBatchFCHORFormat").on("click", function () {
    var input2 = document.getElementById('batch_branch_name');
    var branch_name = input2.value;
    var input1 = document.getElementById('batch_coll_date');
    var tdate = input1.value;
    // window.open("extensions/tcpdf/pdf/print_BatchFCHOfficialReceipt.php?branch_name="+branch_name+"&tdate="+tdate);

    var printBatchFCHORFormat = 'extensions/tcpdf/pdf/print_BatchFCHOfficialReceipt.php?branch_name=' + encodeURIComponent(branch_name) + '&tdate=' + encodeURIComponent(tdate);

    var iframe = document.createElement('iframe');
    iframe.style.display = 'none';
    iframe.src = printBatchFCHORFormat;
    document.body.appendChild(iframe);

    iframe.onload = function () {
      iframe.contentWindow.focus();
      iframe.contentWindow.print();
    };
  })

  $(".printFCHORBACFormat").on("click", function () {
    var input2 = document.getElementById('account_id');
    var account_id = input2.value;
    var input1 = document.getElementById('tdate');
    var tdate = input1.value;
    var input3 = document.getElementById('branch_name');
    var branch_name = input3.value;
    // window.open("extensions/tcpdf/pdf/print_FCHOfficialReceipt.php?branch_name="+branch_name+"&account_id="+account_id+"&tdate="+tdate);

    var printFCHORBACFormat = 'extensions/tcpdf/pdf/print_FCHBACOfficialReceipt.php?branch_name=' + encodeURIComponent(branch_name) + '&account_id=' + encodeURIComponent(account_id) + '&tdate=' + encodeURIComponent(tdate);

    var iframe = document.createElement('iframe');
    iframe.style.display = 'none';
    iframe.src = printFCHORBACFormat;
    document.body.appendChild(iframe);

    iframe.onload = function () {
      iframe.contentWindow.focus();
      iframe.contentWindow.print();
    };
  })

  $(".printBatchFCHORBACFormat").on("click", function () {
    var input2 = document.getElementById('batch_branch_name');
    var branch_name = input2.value;
    var input1 = document.getElementById('batch_coll_date');
    var tdate = input1.value;
    // window.open("extensions/tcpdf/pdf/print_BatchFCHOfficialReceipt.php?branch_name="+branch_name+"&tdate="+tdate);

    var printBatchFCHORFormat = 'extensions/tcpdf/pdf/print_BatchFCHBACOfficialReceipt.php?branch_name=' + encodeURIComponent(branch_name) + '&tdate=' + encodeURIComponent(tdate);

    var iframe = document.createElement('iframe');
    iframe.style.display = 'none';
    iframe.src = printBatchFCHORFormat;
    document.body.appendChild(iframe);

    iframe.onload = function () {
      iframe.contentWindow.focus();
      iframe.contentWindow.print();
    };
  })

  // For M2 Second OR Printer //
  $(".printM2SecORFormat").on("click", function () {
    var input2 = document.getElementById('account_id');
    var account_id = input2.value;
    var input1 = document.getElementById('tdate');
    var tdate = input1.value;
    var input3 = document.getElementById('branch_name');
    var branch_name = input3.value;
    // window.open("extensions/tcpdf/pdf/print_M2SecOfficialReceipt.php?branch_name="+branch_name+"&account_id="+account_id+"&tdate="+tdate);

    var printM2SecORFormat = 'extensions/tcpdf/pdf/print_M2SecOfficialReceipt.php?branch_name=' + encodeURIComponent(branch_name) + '&account_id=' + encodeURIComponent(account_id) + '&tdate=' + encodeURIComponent(tdate);

    var iframe = document.createElement('iframe');
    iframe.style.display = 'none';
    iframe.src = printM2SecORFormat;
    document.body.appendChild(iframe);

    iframe.onload = function () {
      iframe.contentWindow.focus();
      iframe.contentWindow.print();
    };
  })

  $(".printBatchM2SecORFormat").on("click", function () {
    var input2 = document.getElementById('batch_branch_name');
    var branch_name = input2.value;
    var input1 = document.getElementById('batch_coll_date');
    var tdate = input1.value;
    // window.open("extensions/tcpdf/pdf/print_BatchM2SecOfficialReceipt.php?branch_name="+branch_name+"&tdate="+tdate);

    var printBatchM2SecORFormat = 'extensions/tcpdf/pdf/print_BatchM2SecOfficialReceipt.php?branch_name=' + encodeURIComponent(branch_name) + '&tdate=' + encodeURIComponent(tdate);

    var iframe = document.createElement('iframe');
    iframe.style.display = 'none';
    iframe.src = printBatchM2SecORFormat;
    document.body.appendChild(iframe);

    iframe.onload = function () {
      iframe.contentWindow.focus();
      iframe.contentWindow.print();
    };
  })

  // For EMB TOLEDO OR Printer //
  $(".printTOLORFormat").on("click", function () {
    var input2 = document.getElementById('account_id');
    var account_id = input2.value;
    var input1 = document.getElementById('tdate');
    var tdate = input1.value;
    var input3 = document.getElementById('branch_name');
    var branch_name = input3.value;
    // window.open("extensions/tcpdf/pdf/print_TOLOfficialReceipt.php?branch_name="+branch_name+"&account_id="+account_id+"&tdate="+tdate);

    var printTOLORFormat = 'extensions/tcpdf/pdf/print_TOLOfficialReceipt.php?branch_name=' + encodeURIComponent(branch_name) + '&account_id=' + encodeURIComponent(account_id) + '&tdate=' + encodeURIComponent(tdate);

    var iframe = document.createElement('iframe');
    iframe.style.display = 'none';
    iframe.src = printTOLORFormat;
    document.body.appendChild(iframe);

    iframe.onload = function () {
      iframe.contentWindow.focus();
      iframe.contentWindow.print();
    };
  })

  $(".printBatchTOLORFormat").on("click", function () {
    var input2 = document.getElementById('batch_branch_name');
    var branch_name = input2.value;
    var input1 = document.getElementById('batch_coll_date');
    var tdate = input1.value;
    // window.open("extensions/tcpdf/pdf/print_BatchTOLOfficialReceipt.php?branch_name="+branch_name+"&tdate="+tdate);

    var printBatchTOLORFormat = 'extensions/tcpdf/pdf/print_BatchTOLOfficialReceipt.php?branch_name=' + encodeURIComponent(branch_name) + '&tdate=' + encodeURIComponent(tdate);

    var iframe = document.createElement('iframe');
    iframe.style.display = 'none';
    iframe.src = printBatchTOLORFormat;
    document.body.appendChild(iframe);

    iframe.onload = function () {
      iframe.contentWindow.focus();
      iframe.contentWindow.print();
    };
  })

  $(".printFCHMURCIAORFormat").on("click", function () {
    var input2 = document.getElementById('account_id');
    var account_id = input2.value;
    var input1 = document.getElementById('tdate');
    var tdate = input1.value;
    var input3 = document.getElementById('branch_name');
    var branch_name = input3.value;
    // window.open("extensions/tcpdf/pdf/print_FCHSecondOfficialReceipt.php?branch_name="+branch_name+"&account_id="+account_id+"&tdate="+tdate);

    var printFCHMURCIAORFormat = 'extensions/tcpdf/pdf/print_FCHSecondOfficialReceipt.php?branch_name=' + encodeURIComponent(branch_name) + '&account_id=' + encodeURIComponent(account_id) + '&tdate=' + encodeURIComponent(tdate);

    var iframe = document.createElement('iframe');
    iframe.style.display = 'none';
    iframe.src = printFCHMURCIAORFormat;
    document.body.appendChild(iframe);

    iframe.onload = function () {
      iframe.contentWindow.focus();
      iframe.contentWindow.print();
    };
  })

  $(".printBatchFCHMURCIAORFormat").on("click", function () {
    var input2 = document.getElementById('batch_branch_name');
    var branch_name = input2.value;
    var input1 = document.getElementById('batch_coll_date');
    var tdate = input1.value;
    // window.open("extensions/tcpdf/pdf/print_BatchFCHSecondOfficialReceipt.php?branch_name="+branch_name+"&tdate="+tdate);

    var printBatchFCHMURCIAORFormat = 'extensions/tcpdf/pdf/print_BatchFCHSecondOfficialReceipt.php?branch_name=' + encodeURIComponent(branch_name) + '&tdate=' + encodeURIComponent(tdate);

    var iframe = document.createElement('iframe');
    iframe.style.display = 'none';
    iframe.src = printBatchFCHMURCIAORFormat;
    document.body.appendChild(iframe);

    iframe.onload = function () {
      iframe.contentWindow.focus();
      iframe.contentWindow.print();
    };
  })
});

//added 11-21-23

function convertAmountToWords(amount) {
  const number = parseFloat(amount).toFixed(2);
  const [wholeNumber, decimalPart] = number.split('.');
  let words = [];
  words.push(convertToWords(wholeNumber) + " PESOS");

  if (decimalPart !== '00') {
    words.push(convertToWords(decimalPart) + " CENTS");
  } else {
    words.push("ZERO CENTS");
  }

  return words.join(" and ");
}

function convertToWords(number) {
  number = parseInt(number, 10);
  let words = "";
  const units = ["", "THOUSAND", "MILLION", "BILLION", "TRILLION", "QUADRILLION"];

  const numLength = number.toString().length;
  const groups = Math.floor((numLength - 1) / 3) + 1;
  number = number.toString().padStart(groups * 3, "0");

  for (let i = 0; i < groups; i++) {
    const chunk = number.substr(i * 3, 3).replace(/^0+/, '');
    if (chunk !== "") {
      if (words !== "") {
        words += " ";
      }
      words += convertThreeDigitNumberToWords(chunk) + " " + units[groups - i - 1];
    }
  }

  return words !== "" ? words : "ZERO";
}

function convertThreeDigitNumberToWords(number) {
  const ones = ["", "ONE", "TWO", "THREE", "FOUR", "FIVE", "SIX", "SEVEN", "EIGHT", "NINE"];
  const teens = ["", "ELEVEN", "TWELVE", "THIRTEEN", "FOURTEEN", "FIFTEEN", "SIXTEEN", "SEVENTEEN", "EIGHTEEN", "NINETEEN"];
  const tens = ["", "TEN", "TWENTY", "THIRTY", "FORTY", "FIFTY", "SIXTY", "SEVENTY", "EIGHTY", "NINETY"];

  const digits = number.split('').reverse().map(Number);

  let words = "";
  if (digits[2]) {
    words += ones[digits[2]] + " HUNDRED ";
  }
  if (digits[1]) {
    if (digits[1] === 1 && digits[0] > 0) {
      words += teens[digits[0]];
    } else {
      words += tens[digits[1]] + " " + ones[digits[0]];
    }
  } else {
    words += ones[digits[0]];
  }

  return words.trim();
}

$(".addBIRRECRecords").on("click", function (event) {
  event.preventDefault();

  const name = $('#name').val();
  const amount = $('#amount').val();
  const desc = $('#desc').val();
  const account_id = $('#account_id').val();
  const cdate = $('#cdate').val();
  const branch_name = $('#branch_name').val();

  const amtwrd = convertAmountToWords(amount);
  const vat = parseFloat(amount) * 0.12; // Example VAT calculation (12%)
  const tdate = new Date(cdate);
  const rdate = new Date();
  const ttime = rdate.toLocaleTimeString('en-US', { hour12: true });

  var data = {
    "rdate": rdate.toISOString().split('T')[0],
    "name": name,
    "amtwrd": amtwrd,
    "amount": amount,
    "birsales": '----',
    "biramt": vat.toFixed(2),
    "birdue": amount,
    "tdate": tdate.toISOString().split('T')[0],
    "ttime": ttime,
    "desc": desc,
    "account_id": account_id,
    "month": tdate.toLocaleString('default', { month: 'short' }),
    "day": ('0' + tdate.getDate()).slice(-2),
    "yr": tdate.getFullYear().toString().substr(-2),
    "branch_name": branch_name
  };

  $.ajax({
    type: "GET",
    url: "ajax/addBIRCRecords.ajax.php", // Replace with your actual server endpoint
    data: data,
    success: function (response) {
      console.log("Success:", response);
      swal({
        type: "success",
        title: "Records Update Succesfully!",
        showConfirmButton: true,
        confirmButtonText: "Ok"
      }).then(function (result) {
        if (result.value) {

          $('#editReceiptPrinting').modal('hide');

          document.getElementById('yourFormId').reset();

          // console.log("Account ID:", account_id);

          var $button = $("button[account_id='" + account_id + "']");
          if ($button.length) {
            // console.log("Button found:", $button);

            $button.removeClass('btn-info').addClass('btn-danger').text('Re-Edit');
          } else {
            console.log("Button not found for account_id:", account_id);
          }
        }
      });
    },
    error: function (xhr, status, error) {
      console.error("Error:", error);
      swal({
        type: "success",
        title: "An error occurred while adding the record.",
        showConfirmButton: true,
        confirmButtonText: "Ok"
      }).then(function (result) {
        if (result.value) {
          $('#editReceiptPrinting').modal('hide');
          document.getElementById('yourFormId').reset();
        }
      });
    }

  });
});





