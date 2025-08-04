<?PHP
//include "Config/config.php";
//include "Lib/lib.php";
$user = $_SESSION['User'];


$cn = ConnectDB();
$LastExpenceQuery = "SELECT  TOP (1) ID, UserName, NumberOfSMS, Date FROM   ExpenceHistory WHERE  (UserName='$User') ORDER BY Date DESC";
$result_LastExpence = odbc_fetch_array(odbc_exec($cn, $LastExpenceQuery));
$NumberOfSMS = $result_LastExpence['NumberOfSMS'];
$Date = $result_LastExpence['Date'];

$LastpaymentQuery = "SELECT   TOP (1) UserName, NumberOfSMS, Amount, CONVERT(date, TransactionDate) as TransactionDate  FROM   TransactionHistory WHERE        (UserName = '$User') ORDER BY TransactionDate DESC";
$result_LastPayment = odbc_fetch_array(odbc_exec($cn, $LastpaymentQuery));
$PurchaseAmount = $result_LastPayment['NumberOfSMS'];
$Amount = $result_LastPayment['Amount'];
$TransactionDate = $result_LastPayment['TransactionDate'];

$LastExpenceTopQuery = "SELECT        TOP (20) ID, UserName, NumberOfSMS, Date FROM            ExpenceHistory WHERE        (UserName = '$User') ORDER BY Date DESC";
$LastTopExpenceRS = odbc_exec($cn, $LastExpenceTopQuery);

$i = 1;
$colorArray = array('#FF6633', '#FFB399', '#FF33FF', '#FFFF99', '#00B3E6',
    '#E6B333', '#3366E6', '#999966', '#99FF99', '#B34D4D',
    '#80B300', '#809900', '#E6B3B3', '#6680B3', '#66991A',
    '#FF99E6', '#CCFF1A', '#FF1A66', '#E6331A', '#33FFCC',
    '#66994D', '#B366CC', '#4D8000', '#B33300', '#CC80CC',
    '#66664D', '#991AFF', '#E666FF', '#4DB3FF', '#1AB399',
    '#E666B3', '#33991A', '#CC9999', '#B3B31A', '#00E680',
    '#4D8066', '#809980', '#E6FF80', '#1AFF33', '#999933',
    '#FF3380', '#CCCC00', '#66E64D', '#4D80CC', '#9900B3',
    '#E64D66', '#4DB380', '#FF4D4D', '#99E6E6', '#6666FF');
?>


<script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
<script src="js/export.min.js"></script>
<link rel="stylesheet" href="CSS/export.css" type="text/css" media="all" />
<script src="js/light.js"></script>

<div id="page-content">
    <div id='wrap'>

        <div class="container">                 
            <div class="row">

                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-4 col-xs-12 col-sm-6">
                            <a class="info-tiles tiles-toyo" href="#">
                                <div class="tiles-heading">Available SMS Balance</div>                                
                                <div class="tiles-body-alt">                                    
                                    <i class="fa fa-bar-chart-o"></i>
                                    <div class="text-right"><span class="text-top"> <?php echo $_SESSION['CurrentSMSBalance']; ?> SMS  on <br/>  <?php echo date('d-M-Y'); ?></span></div> 
                                    <small> </small>
                                </div>                              
                            </a>
                        </div>

                        <div class="col-md-4 col-xs-12 col-sm-6">
                            <a class="info-tiles tiles-success" href="#">
                                <div class="tiles-heading">Last SMS Sent Record</div>
                                <div class="tiles-body-alt">
                                    <i class="fa fa-comments-o"></i>
                                    <div class="text-right"><span class="text-top">   Total  <?php echo $NumberOfSMS; ?>  SMS <br/> Sent On <?php echo $Date; ?></span></div>                                   
                                </div>                            
                            </a>
                        </div>                        
                        <div class="col-md-4 col-xs-12 col-sm-6">
                            <a class="info-tiles tiles-orange" href="#">
                                <div class="tiles-heading">Last Payment Record</div>
                                <div class="tiles-body-alt">
                                    <i class="fa fa-money"></i>
                                    <div class="text-right"> <span class="text-top">  TK.  <?php echo $Amount; ?> on <br/> <?php echo $TransactionDate; ?>   for   <?php echo $PurchaseAmount; ?>  SMS</span></div>  
                                </div>                            
                            </a>
                        </div>
                    </div>
                </div>


                <div class="col-md-12 col-lg-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">  <h4>SMS sending report chart</h4> </div>
                        <div class="panel-body">                            
                            <div id="chart" style="width: 100%; height: 500px;"></div>                            
                        </div>
                    </div>
                </div>
            </div>


        </div> <!-- row -->
    </div> <!-- container -->
</div> <!-- wrap -->
</div> <!-- page-content -->




<style>
    #chartdiv {
        width: 100%;
        height: 500px;
    }

    .amcharts-export-menu-top-right {
        top: 10px;
        right: 0;
    }
</style>

<!-- Resources -->

<script src="js/serial.js"></script>

<!-- Chart code -->
<script>

            var chart = AmCharts.makeChart("chart", {
            "type": "serial",
                    "theme": "light",
                    "marginRight": 70,
                    "dataProvider": [<?php
                    while ($row = db_fetch_array($LastTopExpenceRS)) {
                        ?>
                                            {"country":"<?php echo $row['Date']; ?>", "visits": <?php echo $row['NumberOfSMS']; ?>, "color": "<?php echo $colorArray[rand(0, count($colorArray) + 1)] ?>"}
                        <?php
                        if ($i <= db_num_rows($LastTopExpenceRS)) {
                            echo ",";
                            $i++;
                        }
                    }
                    ?> ],
                    "valueAxes": [{
                    "axisAlpha": 0,
                            "position": "left",
                            "title": "Number of SMS"
                    }],
                    "startDuration": 1,
                    "graphs": [{
                    "balloonText": "<b> Sent SMS: [[value]]</b>",
                            "fillColorsField": "color",
                            "fillAlphas": 0.9,
                            "lineAlpha": 0.2,
                            "type": "column",
                            "valueField": "visits"
                    }],
                    "chartCursor": {
                    "categoryBalloonEnabled": false,
                            "cursorAlpha": 0,
                            "zoomable": false
                    },
                    "categoryField": "country",
                    "categoryAxis": {
                    "gridPosition": "start",
                            "labelRotation": 45
                    },
                    "export": {
                    "enabled": true
                    }

            });
</script>

