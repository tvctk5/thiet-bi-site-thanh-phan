<!-- 	Nguyen Hai Duong, September 2016 
 			GNU LESSER GENERAL PUBLIC LICENSE Version 2.1, February 1999
-->

<?php 

session_start();

include 'function/print-HTML.php';
include 'sql/sql-function.php';

//tiến hành kiểm tra là người dùng đã đăng nhập hay chưa
//nếu chưa, chuyển hướng người dùng ra lại trang đăng nhập
if (!isset($_SESSION['username'])) {
	 header('Location: login.php');
}

$conn = ConnectDatabse();

?>

<!DOCTYPE html>
<html lang="en"> 
  <head>
    <meta charset="utf-8">
    <meta http-equiv="refresh" content="10000">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>History export</title>
    
    <!-- CSS -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans">
    <link rel="stylesheet" type="text/css" href="fonts/font-awesome/css/font-awesome.min.css">
    <!-- Bootst192rap -->
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/jquery-ui.min.css">
    <link rel="stylesheet" type="text/css" href="css/index.css">
    
    <!-- JS -->
    <script type="text/javascript" src="js/jquery/jquery.js"></script>
    <script type="text/javascript" src="js/jquery/jquery-ui.min.js"></script>
    <script type="text/javascript" src="js/jquery.ui.touch-punch.min.js"></script>
    <script type="text/javascript" src="js/query.js"></script>
    <script type="text/javascript" src="js/jquery.tabletoCSV.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

  </head>
  <body class="lazy-man">
<!--========================================================-->

<div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
<hr/>
<div class='col-lg-12 col-md-12 col-sm-12 col-xs-12' style='padding:10px;text-align:right; margin: 5px; background-color: #c9d9e0;'><button id="export" data-export="export">Export</button></div>
<hr/>
<table class='tbllistitem' id="export_table"> 
    <tr>
        <th>
            Id
        </th>
        <!--th>
            Device Id
        </th-->
        <th>
            Name
        </th>
        <th>
            Status
        </th>
        <th>
            Start Date
        </th>
        <th>
            Finish Date
        </th>
    </tr>
<?php

PrintList($conn, 20);

?>

</table>
</div>

  </body>
</html>

<?php 
	CloseDatabase($conn);
?>
