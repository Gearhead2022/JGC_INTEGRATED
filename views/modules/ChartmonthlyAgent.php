<?php

require_once "models/connection.php";
$connection = new Connection();
$pdo = $connection->connect();

$charts = (new Connection)->connect()->query("SELECT

        (SELECT SUM(agents) FROM monthly_agent WHERE MONTH(mdate) = '01' AND YEAR(mdate) = YEAR(CURRENT_DATE)) AS total_jan_agents,
        (SELECT SUM(agents) FROM monthly_agent WHERE MONTH(mdate) = '02' AND YEAR(mdate) = YEAR(CURRENT_DATE)) AS total_feb_agents,
        (SELECT SUM(agents) FROM monthly_agent WHERE MONTH(mdate) = '03' AND YEAR(mdate) = YEAR(CURRENT_DATE)) AS total_mar_agents,
        (SELECT SUM(agents) FROM monthly_agent WHERE MONTH(mdate) = '04' AND YEAR(mdate) = YEAR(CURRENT_DATE)) AS total_apr_agents,
        (SELECT SUM(agents) FROM monthly_agent WHERE MONTH(mdate) = '05' AND YEAR(mdate) = YEAR(CURRENT_DATE)) AS total_may_agents,
        (SELECT SUM(agents) FROM monthly_agent WHERE MONTH(mdate) = '06' AND YEAR(mdate) = YEAR(CURRENT_DATE)) AS total_jun_agents,
        (SELECT SUM(agents) FROM monthly_agent WHERE MONTH(mdate) = '07' AND YEAR(mdate) = YEAR(CURRENT_DATE)) AS total_jul_agents,
        (SELECT SUM(agents) FROM monthly_agent WHERE MONTH(mdate) = '08' AND YEAR(mdate) = YEAR(CURRENT_DATE)) AS total_aug_agents,
        (SELECT SUM(agents) FROM monthly_agent WHERE MONTH(mdate) = '09' AND YEAR(mdate) = YEAR(CURRENT_DATE)) AS total_sep_agents,
        (SELECT SUM(agents) FROM monthly_agent WHERE MONTH(mdate) = '10' AND YEAR(mdate) = YEAR(CURRENT_DATE)) AS total_oct_agents,
        (SELECT SUM(agents) FROM monthly_agent WHERE MONTH(mdate) = '11' AND YEAR(mdate) = YEAR(CURRENT_DATE)) AS total_nov_agents,
        (SELECT SUM(agents) FROM monthly_agent WHERE MONTH(mdate) = '12' AND YEAR(mdate) = YEAR(CURRENT_DATE)) AS total_dec_agents,

        (SELECT SUM(sales) FROM monthly_agent WHERE MONTH(mdate) = '01' AND YEAR(mdate) = YEAR(CURRENT_DATE)) AS total_jan_sales,
        (SELECT SUM(sales) FROM monthly_agent WHERE MONTH(mdate) = '02' AND YEAR(mdate) = YEAR(CURRENT_DATE)) AS total_feb_sales,
        (SELECT SUM(sales) FROM monthly_agent WHERE MONTH(mdate) = '03' AND YEAR(mdate) = YEAR(CURRENT_DATE)) AS total_mar_sales,
        (SELECT SUM(sales) FROM monthly_agent WHERE MONTH(mdate) = '04' AND YEAR(mdate) = YEAR(CURRENT_DATE)) AS total_apr_sales,
        (SELECT SUM(sales) FROM monthly_agent WHERE MONTH(mdate) = '05' AND YEAR(mdate) = YEAR(CURRENT_DATE)) AS total_may_sales,
        (SELECT SUM(sales) FROM monthly_agent WHERE MONTH(mdate) = '06' AND YEAR(mdate) = YEAR(CURRENT_DATE)) AS total_jun_sales,
        (SELECT SUM(sales) FROM monthly_agent WHERE MONTH(mdate) = '07' AND YEAR(mdate) = YEAR(CURRENT_DATE)) AS total_jul_sales,
        (SELECT SUM(sales) FROM monthly_agent WHERE MONTH(mdate) = '08' AND YEAR(mdate) = YEAR(CURRENT_DATE)) AS total_aug_sales,
        (SELECT SUM(sales) FROM monthly_agent WHERE MONTH(mdate) = '09' AND YEAR(mdate) = YEAR(CURRENT_DATE)) AS total_sep_sales,
        (SELECT SUM(sales) FROM monthly_agent WHERE MONTH(mdate) = '10' AND YEAR(mdate) = YEAR(CURRENT_DATE)) AS total_oct_sales,
        (SELECT SUM(sales) FROM monthly_agent WHERE MONTH(mdate) = '11' AND YEAR(mdate) = YEAR(CURRENT_DATE)) AS total_nov_sales,
        (SELECT SUM(sales) FROM monthly_agent WHERE MONTH(mdate) = '12' AND YEAR(mdate) = YEAR(CURRENT_DATE)) AS total_dec_sales,

        (SELECT SUM(sales) FROM monthly_agent WHERE YEAR(mdate) = YEAR(CURRENT_DATE) AND branch_name LIKE 'EMB%') AS total_emb_sales,
        (SELECT SUM(agents) FROM monthly_agent WHERE YEAR(mdate) = YEAR(CURRENT_DATE) AND branch_name LIKE 'EMB%') AS total_emb_agents,

        (SELECT SUM(sales) FROM monthly_agent WHERE YEAR(mdate) = YEAR(CURRENT_DATE) AND branch_name LIKE 'FCH%' AND  branch_name != 'FCH PARANAQUE' AND branch_name != 'FCH MUNTINLUPA') AS total_fchN_sales,
        (SELECT SUM(agents) FROM monthly_agent WHERE YEAR(mdate) = YEAR(CURRENT_DATE) AND branch_name LIKE 'FCH%' AND branch_name != 'FCH PARANAQUE' AND branch_name != 'FCH MUNTINLUPA') AS total_fchN_agents,

        (SELECT SUM(sales) FROM monthly_agent WHERE YEAR(mdate) = YEAR(CURRENT_DATE) AND branch_name LIKE 'FCH%' AND  branch_name != 'FCH BACOLOD' AND branch_name != 'FCH SILAY' AND branch_name != 'FCH MURCIA' AND branch_name != 'FCH HINIGARAN' AND branch_name != 'FCH BINALBAGAN' AND branch_name != 'FCH BURGOS' AND branch_name != 'FCH BAGO') AS total_fchM_sales,
        (SELECT SUM(agents) FROM monthly_agent WHERE YEAR(mdate) = YEAR(CURRENT_DATE) AND branch_name LIKE 'FCH%' AND branch_name != 'FCH BACOLOD' AND branch_name != 'FCH SILAY' AND branch_name != 'FCH MURCIA' AND branch_name != 'FCH HINIGARAN' AND branch_name != 'FCH BINALBAGAN' AND branch_name != 'FCH BURGOS' AND branch_name != 'FCH BAGO') AS total_fchM_agents,

        (SELECT SUM(sales) FROM monthly_agent WHERE YEAR(mdate) = YEAR(CURRENT_DATE) AND branch_name LIKE 'RLC%') AS total_rlc_sales,
        (SELECT SUM(agents) FROM monthly_agent WHERE YEAR(mdate) = YEAR(CURRENT_DATE) AND branch_name LIKE 'RLC%') AS total_rlc_agents,

        (SELECT SUM(sales) FROM monthly_agent WHERE YEAR(mdate) = YEAR(CURRENT_DATE) AND branch_name LIKE 'ELC%') AS total_elc_sales,
        (SELECT SUM(agents) FROM monthly_agent WHERE YEAR(mdate) = YEAR(CURRENT_DATE) AND branch_name LIKE 'ELC%') AS total_elc_agents,

        (SELECT SUM(sales) FROM monthly_agent WHERE YEAR(mdate) = YEAR(CURRENT_DATE) - 1 AND branch_name LIKE 'EMB%') AS total_beg_emb_sales,
        (SELECT SUM(agents) FROM monthly_agent WHERE YEAR(mdate) = YEAR(CURRENT_DATE) - 1 AND branch_name LIKE 'EMB%') AS total_beg_emb_agents,

        (SELECT SUM(sales) FROM monthly_agent WHERE YEAR(mdate) = YEAR(CURRENT_DATE) -1 AND branch_name LIKE 'FCH%' AND  branch_name != 'FCH PARANAQUE' AND branch_name != 'FCH MUNTINLUPA') AS total_beg_fchN_sales,
        (SELECT SUM(agents) FROM monthly_agent WHERE YEAR(mdate) = YEAR(CURRENT_DATE) -1 AND branch_name LIKE 'FCH%' AND  branch_name != 'FCH PARANAQUE' AND branch_name != 'FCH MUNTINLUPA') AS total_beg_fchN_agents,

        (SELECT SUM(sales) FROM monthly_agent WHERE YEAR(mdate) = YEAR(CURRENT_DATE) -1 AND branch_name LIKE 'FCH%' AND branch_name != 'FCH BACOLOD' AND branch_name != 'FCH SILAY' AND branch_name != 'FCH MURCIA' AND branch_name != 'FCH HINIGARAN' AND branch_name != 'FCH BINALBAGAN' AND branch_name != 'FCH BURGOS' AND branch_name != 'FCH BAGO') AS total_beg_fchM_sales,
        (SELECT SUM(agents) FROM monthly_agent WHERE YEAR(mdate) = YEAR(CURRENT_DATE) - 1 AND branch_name LIKE 'FCH%' AND branch_name != 'FCH BACOLOD' AND branch_name != 'FCH SILAY' AND branch_name != 'FCH MURCIA' AND branch_name != 'FCH HINIGARAN' AND branch_name != 'FCH BINALBAGAN' AND branch_name != 'FCH BURGOS' AND branch_name != 'FCH BAGO') AS total_beg_fchM_agents,

        (SELECT SUM(sales) FROM monthly_agent WHERE YEAR(mdate) = YEAR(CURRENT_DATE) -1 AND branch_name LIKE 'RLC%') AS total_beg_rlc_sales,
        (SELECT SUM(agents) FROM monthly_agent WHERE YEAR(mdate) = YEAR(CURRENT_DATE) -1 AND branch_name LIKE 'RLC%') AS total_beg_rlc_agents,

        (SELECT SUM(sales) FROM monthly_agent WHERE YEAR(mdate) = YEAR(CURRENT_DATE) - 1 AND branch_name LIKE 'ELC%') AS total_beg_elc_sales,
        (SELECT SUM(agents) FROM monthly_agent WHERE YEAR(mdate) = YEAR(CURRENT_DATE) - 1 AND branch_name LIKE 'ELC%') AS total_beg_elc_agents,


        (SELECT SUM(sales) FROM monthly_agent WHERE MONTH(mdate) = '01' AND YEAR(mdate) = YEAR(CURRENT_DATE) - 1) AS total_jan_sales_last,
        (SELECT SUM(agents) FROM monthly_agent WHERE MONTH(mdate) = '01' AND YEAR(mdate) = YEAR(CURRENT_DATE) - 1) AS total_jan_agents_last,
        
        (SELECT SUM(sales) FROM monthly_agent WHERE MONTH(mdate) = '02' AND YEAR(mdate) = YEAR(CURRENT_DATE) - 1) AS total_feb_sales_last,
        (SELECT SUM(agents) FROM monthly_agent WHERE MONTH(mdate) = '02' AND YEAR(mdate) = YEAR(CURRENT_DATE) - 1) AS total_feb_agents_last,

        (SELECT SUM(sales) FROM monthly_agent WHERE MONTH(mdate) = '03' AND YEAR(mdate) = YEAR(CURRENT_DATE) - 1) AS total_mar_sales_last,
        (SELECT SUM(agents) FROM monthly_agent WHERE MONTH(mdate) = '03' AND YEAR(mdate) = YEAR(CURRENT_DATE) - 1) AS total_mar_agents_last,

        (SELECT SUM(sales) FROM monthly_agent WHERE MONTH(mdate) = '04' AND YEAR(mdate) = YEAR(CURRENT_DATE) - 1) AS total_apr_sales_last,
        (SELECT SUM(agents) FROM monthly_agent WHERE MONTH(mdate) = '04' AND YEAR(mdate) = YEAR(CURRENT_DATE) - 1) AS total_apr_agents_last,

        (SELECT SUM(sales) FROM monthly_agent WHERE MONTH(mdate) = '05' AND YEAR(mdate) = YEAR(CURRENT_DATE) - 1) AS total_may_sales_last,
        (SELECT SUM(agents) FROM monthly_agent WHERE MONTH(mdate) = '05' AND YEAR(mdate) = YEAR(CURRENT_DATE) - 1) AS total_may_agents_last,

        (SELECT SUM(sales) FROM monthly_agent WHERE MONTH(mdate) = '06' AND YEAR(mdate) = YEAR(CURRENT_DATE) - 1) AS total_jun_sales_last,
        (SELECT SUM(agents) FROM monthly_agent WHERE MONTH(mdate) = '06' AND YEAR(mdate) = YEAR(CURRENT_DATE) - 1) AS total_jun_agents_last,

        (SELECT SUM(sales) FROM monthly_agent WHERE MONTH(mdate) = '07' AND YEAR(mdate) = YEAR(CURRENT_DATE) - 1) AS total_jul_sales_last,
        (SELECT SUM(agents) FROM monthly_agent WHERE MONTH(mdate) = '07' AND YEAR(mdate) = YEAR(CURRENT_DATE) - 1) AS total_jul_agents_last,
     
        (SELECT SUM(sales) FROM monthly_agent WHERE MONTH(mdate) = '08' AND YEAR(mdate) = YEAR(CURRENT_DATE) - 1) AS total_aug_sales_last,
        (SELECT SUM(agents) FROM monthly_agent WHERE MONTH(mdate) = '08' AND YEAR(mdate) = YEAR(CURRENT_DATE) - 1) AS total_aug_agents_last,

        (SELECT SUM(sales) FROM monthly_agent WHERE MONTH(mdate) = '09' AND YEAR(mdate) = YEAR(CURRENT_DATE) - 1) AS total_sep_sales_last,
        (SELECT SUM(agents) FROM monthly_agent WHERE MONTH(mdate) = '09' AND YEAR(mdate) = YEAR(CURRENT_DATE) - 1) AS total_sep_agents_last,

        (SELECT SUM(sales) FROM monthly_agent WHERE MONTH(mdate) = '10' AND YEAR(mdate) = YEAR(CURRENT_DATE) - 1) AS total_oct_sales_last,
        (SELECT SUM(agents) FROM monthly_agent WHERE MONTH(mdate) = '10' AND YEAR(mdate) = YEAR(CURRENT_DATE) - 1) AS total_oct_agents_last,

        (SELECT SUM(sales) FROM monthly_agent WHERE MONTH(mdate) = '11' AND YEAR(mdate) = YEAR(CURRENT_DATE) - 1) AS total_nov_sales_last,
        (SELECT SUM(agents) FROM monthly_agent WHERE MONTH(mdate) = '11' AND YEAR(mdate) = YEAR(CURRENT_DATE) - 1) AS total_nov_agents_last,

        (SELECT SUM(sales) FROM monthly_agent WHERE MONTH(mdate) = '12' AND YEAR(mdate) = YEAR(CURRENT_DATE) - 1) AS total_dec_sales_last,
        (SELECT SUM(agents) FROM monthly_agent WHERE MONTH(mdate) = '12' AND YEAR(mdate) = YEAR(CURRENT_DATE) - 1) AS total_dec_agents_last
        

 
 ")->fetch(PDO::FETCH_ASSOC);

 $total_agents_jan = $charts['total_jan_agents'];
 $total_agents_feb = $charts['total_feb_agents'];
 $total_agents_mar = $charts['total_mar_agents'];
 $total_agents_apr = $charts['total_apr_agents'];
 $total_agents_may = $charts['total_may_agents'];
 $total_agents_jun = $charts['total_jun_agents'];
 $total_agents_jul = $charts['total_jul_agents'];
 $total_agents_aug = $charts['total_aug_agents'];
 $total_agents_sep = $charts['total_sep_agents'];
 $total_agents_oct = $charts['total_oct_agents'];
 $total_agents_nov = $charts['total_nov_agents'];
 $total_agents_dec = $charts['total_dec_agents'];

 $total_sales_jan = $charts['total_jan_sales'];
 $total_sales_feb = $charts['total_feb_sales'];
 $total_sales_mar = $charts['total_mar_sales'];
 $total_sales_apr = $charts['total_apr_sales'];
 $total_sales_may = $charts['total_may_sales'];
 $total_sales_jun = $charts['total_jun_sales'];
 $total_sales_jul = $charts['total_jul_sales'];
 $total_sales_aug = $charts['total_aug_sales'];
 $total_sales_sep = $charts['total_sep_sales'];
 $total_sales_oct = $charts['total_oct_sales'];
 $total_sales_nov = $charts['total_nov_sales'];
 $total_sales_dec = $charts['total_dec_sales'];

 $total_emb_sales = $charts['total_emb_sales'];
 $total_emb_agents = $charts['total_emb_agents'];
 $total_fchN_sales = $charts['total_fchN_sales'];
 $total_fchN_agents = $charts['total_fchN_agents'];
 $total_fchM_sales = $charts['total_fchM_sales'];
 $total_fchM_agents = $charts['total_fchM_agents'];
 $total_rlc_sales = $charts['total_rlc_sales'];
 $total_rlc_agents = $charts['total_rlc_agents'];
 $total_elc_sales = $charts['total_elc_sales'];
 $total_elc_agents = $charts['total_elc_agents'];


//  by branch  last year agents and sales
 $total_beg_sales_emb = $charts['total_beg_emb_sales'];
 $total_beg_agents_emb = $charts['total_beg_emb_agents'];
 $total_beg_sales_fchN = $charts['total_beg_fchN_sales'];
 $total_beg_agents_fchN = $charts['total_beg_fchN_agents'];
 $total_beg_sales_fchM = $charts['total_beg_fchM_sales'];
 $total_beg_agents_fchM = $charts['total_beg_fchM_agents'];
 $total_beg_sales_rlc = $charts['total_beg_rlc_sales'];
 $total_beg_agents_rlc = $charts['total_beg_rlc_agents'];
 $total_beg_sales_elc = $charts['total_beg_elc_sales'];
 $total_beg_agents_elc = $charts['total_beg_elc_agents'];
//  end by branch  last year agents and sales

 $total_last_jan_sales = $charts['total_jan_sales_last'];
 $total_last_jan_agents = $charts['total_jan_agents_last'];
 
 $total_last_feb_sales = $charts['total_feb_sales_last'];
 $total_last_feb_agents = $charts['total_feb_agents_last'];

 $total_last_mar_sales = $charts['total_mar_sales_last'];
 $total_last_mar_agents = $charts['total_mar_agents_last'];

 $total_last_apr_sales = $charts['total_apr_sales_last'];
 $total_last_apr_agents = $charts['total_apr_agents_last'];

 $total_last_may_sales = $charts['total_may_sales_last'];
 $total_last_may_agents = $charts['total_may_agents_last'];

 $total_last_jun_sales = $charts['total_jun_sales_last'];
 $total_last_jun_agents = $charts['total_jun_agents_last'];

 $total_last_jul_sales = $charts['total_jul_sales_last'];
 $total_last_jul_agents = $charts['total_jul_agents_last'];

 $total_last_aug_sales = $charts['total_aug_sales_last'];
 $total_last_aug_agents = $charts['total_aug_agents_last'];
 
 $total_last_sep_sales = $charts['total_sep_sales_last'];
 $total_last_sep_agents = $charts['total_sep_agents_last'];
 
 $total_last_oct_sales = $charts['total_oct_sales_last'];
 $total_last_oct_agents = $charts['total_oct_agents_last'];

 $total_last_nov_sales = $charts['total_nov_sales_last'];
 $total_last_nov_agents = $charts['total_nov_agents_last'];

 $total_last_dec_sales = $charts['total_dec_sales_last'];
 $total_last_dec_agents = $charts['total_dec_agents_last'];

?>

<style>
  .ds{
  font-size:.8rem;
}
  .modal-content {
    width: 1000px;
    margin-left: -221px;
}
.fs{
  color:black;
}
.carousel-control-prev-icon {
    background-image: url('./views/img/leftarrow.png');
}
.carousel-control-next-icon {
    background-image: url('./views/img/rightarrow.png'); 
}



</style>
<div class="clearfix">
  
<div class="content-wrapper" >
   <div class="container-fluid" >
     <div class="row pt-2 pb-2" >
        <div class="col-sm-12">
          <h4 class="page-title"></h4>
        </div>
     </div>

 

     <div class="row">
        <div class="col-lg-12" >
        <a href="monthlyagentAdmin" class="btn btn-light btn-round waves-effect waves-light ml-1 mb-4"><i class="fa fa-arrow-left"></i> <span>&nbsp;Back</span></a>
        <div style="color:white;font-weight:bold;text-align:center;"> </div>
          <div class="card" style="background-color:#ffff;">
      
            <div class="card-header float-sm-right" >
      

            <div class="row">
            <div class="col-12">

            <div id="chart_div" style="width: 100%; height: 230px;"></div>

            </div>
            
            <div class="row"></div>

            </div>

            <div class="row">
                <div class="col-12">
                <div id="chart_div2" style="width: 100%; height: 230px;"></div>
                </div>
            </div>



        <div class="row mt-5 ml-5">
            <div class="col-12 mt-4">
            <div id="barchart_material" style="width: 100%; height:240px;"></div>
            </div>
        </div>


        
        <div class="row mt-5 ml-5">
            <div class="col-12 mt-4">
            <div id="barchart_material2" style="width: 100%; height:240px;"></div>
            </div>
        </div>


        <div class="row">
            <div class="col-12">dfd<br>sdf</div>
        </div>







</div>
</div>

</div>
</div>

</div>
</div>
</div>




<script>

google.charts.load("current", {"packages":["corechart"]});
google.charts.setOnLoadCallback(drawChart);


function drawChart() {
    var data = new google.visualization.DataTable();
    data.addColumn("string", "Category");
    data.addColumn("number", "Agent Data");
    data.addColumn("number", "Sales Data");

    data.addRows([
        ["JANUARY", <?php echo intval($total_agents_jan)?>, <?php echo intval($total_sales_jan) ?>],
        ["FEBRUARY", <?php echo intval($total_agents_feb)?>,<?php echo intval($total_sales_feb) ?> ],
        ["MARCH", <?php echo intval($total_agents_mar)?>, <?php echo intval($total_sales_mar) ?>],
        ["APRIL", <?php echo intval($total_agents_apr)?>,<?php echo intval($total_sales_apr) ?>],
        ["MAY", <?php echo intval($total_agents_may)?>,<?php echo intval($total_sales_may) ?>],
        ["JUNE", <?php echo intval($total_agents_jun)?>,<?php echo intval($total_sales_jun) ?> ],
        ["JULY", <?php echo intval($total_agents_jul)?>,<?php echo intval($total_sales_jul) ?> ],
        ["AUGUST", <?php echo intval($total_agents_aug)?>,<?php echo intval($total_sales_aug) ?> ],
        ["SEPTEMBER",<?php echo intval($total_agents_sep)?>, <?php echo intval($total_sales_sep) ?> ],
        ["OCTOBER", <?php echo intval($total_agents_oct)?>,<?php echo intval($total_sales_oct) ?>],
        ["NOVEMBER",<?php echo intval($total_agents_nov)?>, <?php echo intval($total_sales_nov) ?> ],
        ["DECEMBER", <?php echo intval($total_agents_dec)?>, <?php echo intval($total_sales_dec) ?> ],
    ]);

    var options = {
        title: "Current Agents and Sales Data Monthly",
       
        hAxis: {
        
          titleTextStyle:{
            fontSize:14
          },
          textStyle: {
            fontSize: 10
        }
        },
        seriesType: "bars", 
        series: {
          0:{
              color: "green"
          },
          1: {
            type: "line",
            color: "#AC1F07",
            lineWidth:3,
            pointSize:8
          }} ,
          legend:{
            textStyle:{
              fontSize:11
            }
          }

    };

    var chart = new google.visualization.ComboChart(document.getElementById("chart_div"));
    chart.draw(data, options);
}



</script>


<script>
// chart 2
google.charts.load("current", {"packages":["corechart"]});
google.charts.setOnLoadCallback(drawChart);


function drawChart() {
    var data = new google.visualization.DataTable();
    data.addColumn("string", "Category");
    data.addColumn("number", "Agent Data");
    data.addColumn("number", "Sales Data");

    data.addRows([
      ["JANUARY",<?php echo intval($total_last_jan_agents) ?>, <?php echo intval($total_last_jan_sales) ?>],
        ["FEBRUARY", <?php echo intval($total_last_feb_agents) ?>, <?php echo intval($total_last_feb_sales) ?>],
        ["MARCH",<?php echo intval($total_last_mar_agents) ?>, <?php echo intval($total_last_mar_sales) ?>],
        ["APRIL", <?php echo intval($total_last_apr_agents) ?>, <?php echo intval($total_last_apr_sales) ?>],
        ["MAY", <?php echo intval($total_last_may_agents) ?>, <?php echo intval($total_last_may_sales) ?>],
        ["JUNE", <?php echo intval($total_last_jun_agents) ?>, <?php echo intval($total_last_jun_sales) ?>],
        ["JULY", <?php echo intval($total_last_jul_agents) ?>, <?php echo intval($total_last_jul_sales) ?> ],
        ["AUGUST",  <?php echo intval($total_last_aug_agents) ?>, <?php echo intval($total_last_aug_sales)?>],
        ["SEPTEMBER", <?php echo intval($total_last_sep_agents) ?>, <?php echo intval($total_last_sep_sales) ?>],
        ["OCTOBER", <?php echo intval($total_last_oct_agents) ?>,<?php echo intval($total_last_oct_sales)?>],
        ["NOVEMBER", <?php echo intval($total_last_nov_agents) ?>, <?php echo intval($total_last_nov_sales) ?>],
        ["DECEMBER", <?php echo intval($total_last_dec_agents) ?>, <?php echo intval($total_last_dec_sales) ?>],
    ]);

    var options = {
        title: "Last Year Agents and Sales Data Monthly",
       
        hAxis: {
        
          titleTextStyle:{
            fontSize:14
          },
          textStyle: {
            fontSize: 10
        }
        },
        seriesType: "bars", 
        series: {
          0:{
              color: "green"
          },
          1: {
            type: "line",
            color: "#AC1F07",
            lineWidth:3,
            pointSize:8
          }} ,
          legend:{
            textStyle:{
              fontSize:11
            }
          }

    };

    var chart = new google.visualization.ComboChart(document.getElementById("chart_div2"));
    chart.draw(data, options);
}
</script>




<script>
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['BRANCH', 'Agents', 'Sales'],
          ['EMB', <?php echo $total_emb_agents ?>, <?php echo $total_emb_sales ?>],
          ['FCH NEGROS', <?php echo intval($total_fchN_agents) ?>, <?php echo intval($total_fchN_sales) ?>],
          ['FCH MANILA',<?php echo intval($total_fchM_agents) ?> , <?php echo intval($total_fchM_sales) ?>],
          ['RLC', <?php echo $total_rlc_agents ?>, <?php echo $total_rlc_sales ?>],
          ['ELC', <?php echo $total_elc_agents ?>, <?php echo $total_elc_sales ?>],
        ]);

        var options = {
          chart: {
            title: 'Currrent Agents and Sales By Branch',
        
          },
           titleTextStyle:{
                color: 'black',
                
           },
          bars: 'horizontal'
        
        };

        var chart = new google.charts.Bar(document.getElementById('barchart_material'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }
    </script>











<script>
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['BRANCH', 'Agents', 'Sales'],
          ['EMB',<?php echo intval($total_beg_agents_emb) ?>, <?php echo intval($total_beg_sales_emb) ?>],
          ['FCH NEGROS', <?php echo intval($total_beg_agents_fchN) ?>, <?php echo intval($total_beg_sales_fchN) ?>],
          ['FCH MANILA', <?php echo intval($total_beg_agents_fchM) ?>, <?php echo intval($total_beg_sales_fchM) ?>],
          ['RLC', <?php echo intval($total_beg_agents_rlc) ?>, <?php echo intval($total_beg_sales_rlc) ?>],
          ['ELC', <?php echo intval($total_beg_agents_elc) ?>, <?php echo intval($total_beg_sales_elc) ?>]
        ]);

        var options = {
          chart: {
            title: 'Last Year Agents and Sales By Branch',
        
          },
           titleTextStyle:{
                color: 'black',
                
           },
          bars: 'horizontal'
        
        };

        var chart = new google.charts.Bar(document.getElementById('barchart_material2'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }
    </script>