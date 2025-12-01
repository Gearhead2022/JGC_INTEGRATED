$('.insuranceTable').DataTable({
    "ajax": "ajax/insurance.ajax.php", 
    "deferRender": true,
    "retrieve": true,
    "order": [[3, 'desc']],
    "processing": true
  });
 
  $(".insuranceTable").on("click", "tbody .btnEditClient", function(){
    var idClient = $(this).attr("idClient");
     $('#insuranceEditModal .modal-body').empty();
        $.ajax({
          url: 'ajax/insuranceedit.ajax.php',
          data: {
            idClient: idClient
          },
          dataType: 'json',
          success: function(data) {
              $.each(data, function(index, item) {
                  var card = item.card;
                  $('#insuranceEditModal .modal-body').append(card);
              });
              $('#insuranceEditModal').modal('show');
              $(".expire_date").on("change", function(){ 
                var age1 = document.getElementById('age');
                var age = age1.value;
                var avail_date1 = document.getElementById('avail_date');
                var avail_date = avail_date1.value;
                var expire_date1 = document.getElementById('expire_date');
                var expire_date = expire_date1.value;
                var birth_date1 = document.getElementById('birth_date');
                var birth_date = birth_date1.value;
                var ins_type = $('#ins_type1').val();
             
                // Ajax to process the expire date and terms 
                $.ajax({
                  url: 'ajax/insuranceprocess.ajax.php',
                  data: {
                    age: age,
                    birth_date: birth_date,
                    avail_date: avail_date,
                    expire_date: expire_date,
                    ins_type: ins_type
                  },
                  dataType: 'json',
                  success: function(data) {
                    var bday = new Date(birth_date);
                    var xdate = new Date(expire_date);
                    var ageInMilliseconds = xdate - bday;
                    var ageInYears = new Date(ageInMilliseconds).getFullYear() - 1970; // Subtract 1970 to get years
                    if(ins_type == "OONA"){
                    if(ageInYears >80){
                      swal({
                        type: "warning",
                        title: "It has reached the age limit of 80.",
                        showConfirmButton: true,
                        confirmButtonText: "Ok"
                      }).then(function(result){
                        if (result.value) {
                         
                        }
                      });
                    }else{
                      $.each(data, function(index, item) {
                        var ins_rate = item.amount;
                        var terms  = item.terms;
                        document.getElementById('ins_rate').value = ins_rate;
                        document.getElementById('terms').value = terms;
                      });
                    }
                  }else if(ins_type == "CBI"){
                    if(ageInYears >80){
                      swal({
                        type: "warning",
                        title: "It has reached the age limit of 80.",
                        showConfirmButton: true,
                        confirmButtonText: "Ok"
                      }).then(function(result){
                        if (result.value) {
                         
                        }
                      });
                    }else if(ageInYears > 70){
                      swal({
                        type: "warning",
                        title: "CBI insurance is not available for ages 71 and above.",
                        showConfirmButton: true,
                        confirmButtonText: "Ok"
                      }).then(function(result){
                        if (result.value) {
                         
                        }
                      });
                    }else{
                      $.each(data, function(index, item) {
                        var ins_rate = item.amount;
                        var terms  = item.terms;
                        document.getElementById('ins_rate').value = ins_rate;
                        document.getElementById('terms').value = terms;
                       var getDays1 =  getDays(avail_date, expire_date);
                       $(".days1").val(getDays1);
                      });
                    }
                  }else if(ins_type == "PHIL"){
                    if(ageInYears >80){
                      swal({
                        type: "warning",
                        title: "It has reached the age limit of 80.",
                        showConfirmButton: true,
                        confirmButtonText: "Ok"
                      }).then(function(result){
                        if (result.value) {
                         
                        }
                      });
                    }else{
                      $.each(data, function(index, item) {
                        var ins_rate = item.amount;
                        var terms  = item.terms;
                        document.getElementById('ins_rate').value = ins_rate;
                        document.getElementById('terms').value = terms;
                      });
                    }
                  }
                  },
                  error: function() {
                      alert('Error fetching data');
                  }
              });
            
                // END Ajax to process the expire date and terms 
              });

              $(".amount_loan").on("change", function(){  
                var amount_loan1 = document.getElementById('amount_loan');
                var amount_loan = amount_loan1.value;
                var ins_rate1 = document.getElementById('ins_rate');
                var ins_rate = ins_rate1.value;
                var amount1 = document.getElementById('amount');
                var amount = amount1.value;
                var age1 = document.getElementById('age');
                var age = age1.value;
                var ins_type1 = document.getElementById('ins_type1');
                var ins_type = ins_type1.value;
                var  amount3 =  parseFloat(amount).toFixed(2);
                var code = $('#cbi_illness1').val();
                var user_type = $('#user_type').val();
                if(ins_type == "CBI"){
                  const codeToFormulaMap = {
                    'HYP': 'IP = IPB + 200',
                    'HD': 'IP = IPB + 200%',
                    'HLP': 'IP = IPB + 100%',
                    'PULC': 'IP = IPB + 100%',
                    'FL': 'IP = IPB + 50%',
                    'KD': 'IP = IPB + 250%',
                    'LD': 'IP = IPB + 200%',
                    'LDPT': 'IP = IPB + 200%',
                    'LDE': 'IP = IPB + 200%',
                    'CTR': 'IP = IPB + 200%',
                    'DM39B': 'IP = IPB + 75%',
                    'DM39U': 'IP = IPB + 125%',
                    'DM40B': 'IP = IPB + 175%',
                    'DM40U': 'IP = IPB + 225%'
                };
                function calculateIP(IPB, formula) {
                  if (formula.includes('IP = IPB + ')) {
                      let addition = formula.replace('IP = IPB + ', '').trim();
                      
                      if (addition.includes('%')) {
                          let percentage = parseFloat(addition.replace('%', ''));
                          return parseFloat(IPB) + (IPB * (percentage / 100));
                      } else {
                          let additionValue = parseFloat(addition);
                          return parseFloat((IPB + additionValue).toFixed(2));
                      }
                  }
                  return null;
              }
              if(code ==""){
                var result = (amount_loan / 1000) * ins_rate;
              }else{
                var IPB = (amount_loan / 1000) * ins_rate;
                var formula = codeToFormulaMap[code];
                if (!formula) {
                  swal({
                    type: "warning",
                    title: "The code you entered is not in the list.",
                    showConfirmButton: true,
                    confirmButtonText: "Ok"
                  }).then(function(result){
                    if (result.value) {
                     
                    }
                  });
               
              }else{
                var result = calculateIP(IPB, formula);
              }
                
              }
          
          }else if(ins_type == "OONA" || ins_type == "PHIL"){
            var result =(amount_loan / 1000) * ins_rate;
          }
          result =   parseFloat(result).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })
          result = result.replace(/,/g, '');


                if(result != amount3){
                  console.log("Result 1 = " + result);
                  console.log("Result 3 = " + amount3);
                  swal({
                    type: "warning",
                    title: "The amount you entered for the insurance premium computation is incorrect.",
                    showConfirmButton: true,
                    confirmButtonText: "Ok"
                  }).then(function(result){
                    if (result.value) {
                      // if(user_type == "insurance_admin" || user_type == "admin" ){
                      //   $(".editInsurance").prop("disabled", false);
                      // }else{
                      //   $(".editInsurance").prop("disabled", true);
                      // }
                    }
                  });
                 
                }else{
                  $(".editInsurance").prop("disabled", false);
                  console.log("Result 1 = " + result);
                  console.log("Result 3 = " + amount3);
                }

           
            
              });

              $(".cbi_illness1").on("change", function(){  
                  const codeToFormulaMap = {
                    'HYP': 'IP = IPB + 200',
                    'HD': 'IP = IPB + 200%',
                    'HLP': 'IP = IPB + 100%',
                    'PULC': 'IP = IPB + 100%',
                    'FL': 'IP = IPB + 50%',
                    'KD': 'IP = IPB + 250%',
                    'LD': 'IP = IPB + 200%',
                    'LDPT': 'IP = IPB + 200%',
                    'LDE': 'IP = IPB + 200%',
                    'CTR': 'IP = IPB + 200%',
                    'DM39B': 'IP = IPB + 75%',
                    'DM39U': 'IP = IPB + 125%',
                    'DM40B': 'IP = IPB + 175%',
                    'DM40U': 'IP = IPB + 225%'
                };
                var code = $(".cbi_illness1").val().toUpperCase();
              
                var formula = codeToFormulaMap[code];
                if (!formula) {
                  swal({
                    type: "warning",
                    title: "The code you entered is not in the list.",
                    showConfirmButton: true,
                    confirmButtonText: "Ok"
                  }).then(function(result){
                    if (result.value) {
                     
                    }
                  });
               
              }
              
                });

                $("#dchs").on("change", function(){
                   // Manually trigger the change event
                   $(".amount_loan").trigger("change");
                })
          },
          error: function() {
              alert('Error fetching data');
          }
      });
  
  })




 
function getDays(avail_date,expire_date){
 

  var availDate1 = new Date(avail_date);
  var expireDate1 = new Date(expire_date);
  var daysDifference = Math.floor((expireDate1 - availDate1) / (1000 * 60 * 60 * 24));

  return daysDifference;
  // console.log('Days between avail date and expiry date: ' + daysDifference);
}


  $(".insuranceTable").on("click", "tbody .btnDeleteClient", function(){
    var idClient = $(this).attr("idClient");
    var account_id = $(this).attr("account_id");
  
    swal({
          title: 'Do you want to delete account ID <u>' + account_id+'</u> ?',
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          cancelButtonText: 'cancel',
          confirmButtonText: 'Yes'
        }).then(function(result){
          if (result.value) {
              window.location = "index.php?route=insurance&idClient="+idClient;
          }
    })
  })


  $("#insuranceReport").on("click", function(){ 
    var rep_date1 = document.getElementById('rep_date');
    var rep_date = rep_date1.value;
    var branch1 = document.getElementById('branch');
    var branch = branch1.value;
    var ins_type = $("#ins_type1").val();
    if(ins_type == "OONA"){
      swal({
        title: "Generating",
        text: "Please wait...",
        allowOutsideClick: false,
        allowEscapeKey: false,
        onOpen: () => {
          swal.showLoading();
          setTimeout(function() {
            window.location = "email/export_daily_summary.php?date=" + rep_date+"&branch="+branch;
            swal.close();
          }, 1500);
      
        } 
      });
    }else if(ins_type == "CBI"){ 
      swal({
        title: "Generating",
        text: "Please wait...",
        allowOutsideClick: false,
        allowEscapeKey: false,
        onOpen: () => {
          swal.showLoading();
          setTimeout(function() {
            window.location = "email/export_cbi_summary.php?date=" + rep_date+"&branch="+branch;
            swal.close();
          }, 1500);
      
        }
      });
    }else if(ins_type == "PHIL"){ 
      swal({
        title: "Generating",
        text: "Please wait...",
        allowOutsideClick: false,
        allowEscapeKey: false,
        onOpen: () => {
          swal.showLoading();
          setTimeout(function() {
            window.location = "email/export_phil_summary.php?date=" + rep_date+"&branch="+branch;
            swal.close();
          }, 1500);
      
        }
      });
    }
    // Display loading screen
    
});


$("#insuranceBranchReport").on("click", function(){ 
  var ins_type = $('#ins_type2').val();
  var branch_names1 = document.getElementById('branch_names');
  var branch_names = branch_names1.value;

  var branch_date1 = document.getElementById('branch_date');
  var branch_date = branch_date1.value;
  if(ins_type == "OONA"){
      // Display loading screen
    swal({
      title: "Generating",
      text: "Please wait...",
      allowOutsideClick: false,
      allowEscapeKey: false,
      onOpen: () => {
        swal.showLoading();
        setTimeout(function() {
          window.location = "email/export_branch_summary.php?date=" + branch_date +"&branch_name="+branch_names;
          swal.close();
        }, 1500);
    
      }
    });
    
  }else if(ins_type == "PHIL"){
    // Display loading screen
  swal({
    title: "Generating",
    text: "Please wait...",
    allowOutsideClick: false,
    allowEscapeKey: false,
    onOpen: () => {
      swal.showLoading();
      setTimeout(function() {
        window.location = "email/export_phil_branch_summary.php?date=" + branch_date +"&branch_name="+branch_names;
        swal.close();
      }, 1500);
  
    }
  });
  
}else if(ins_type == "CBI"){
      swal({
        title: "Generating",
        text: "Please wait...",
        allowOutsideClick: false,
        allowEscapeKey: false,
        onOpen: () => {
          swal.showLoading();
          setTimeout(function() {
            window.location = "email/export_cbi_branch_summary.php?date=" + branch_date +"&branch_name="+branch_names;
            swal.close();
          }, 1500);
      
        }
      });
  }

});


$("#insuranceChecklistReport").on("click", function(){ 
  var chk_date1 = document.getElementById('chk_date');
  var chk_date = chk_date1.value;
  var ins_type = $('#ins_type4').val();


  // Display loading screen
  swal({
    title: "Generating",
    text: "Please wait...",
    allowOutsideClick: false,
    allowEscapeKey: false,
    onOpen: () => {
      swal.showLoading();
      setTimeout(function() {
        window.open("email/insurance_summary.php?date="+chk_date+"&type="+ins_type);
        swal.close();
      }, 1500);
  
    }
  });
 
});



$("#amountSummaryReport").on("click", function(){ 
  var ins_type = $('#ins_type3').val();
  var amt_date1 = document.getElementById('amt_date');
  var amt_date = amt_date1.value;
if(ins_type!=""){
  // Display loading screen
  swal({
    title: "Generating",
    text: "Please wait...",
    allowOutsideClick: false,
    allowEscapeKey: false,
    onOpen: () => {
      swal.showLoading();
      setTimeout(function() {
        window.open("email/amount_summary.php?date="+amt_date+"&type="+ins_type);
        swal.close();
      }, 1500);
  
    }
  });
}else{
  swal({
    type: "warning",
    title: "Please select an insurance type first!",
    showConfirmButton: true,
    confirmButtonText: "Ok"
  }).then(function(result){
    if (result.value) {
     
    }
  });
}
 
});


$(".insuranceCheckerReport").on("blur", function () {
  var date = document.getElementById('insuranceCheckerReport');
  var avail_date = date.value;
  $('.checkerBody1').empty();
  swal({
    title: "Generating",
    text: "Please wait...",
    allowOutsideClick: false,
    allowEscapeKey: false,
    onOpen: () => {
      swal.showLoading(2);
    }
  });

  $.ajax({
    url: 'ajax/insurancechecker.ajax.php',
    data: {
      avail_date: avail_date
    },
    dataType: 'json',
    success: function (data) {
      // Simulate a delay of 1 second
      setTimeout(function () {
        swal.close();
        $.each(data, function (index, item) {
          var card = item.card;
          $('#insuranceCheckerModal .modal-body tbody').append(card);
        });
        $('#insuranceCheckerModal').modal('show');
      }, 1000); // 1000 milliseconds = 1 second
    },
    error: function () {
      // Simulate a delay of 1 second
      setTimeout(function () {
        swal.close();
        alert('Error fetching data');
      }, 1000); // 1000 milliseconds = 1 second
    }
  });
});


