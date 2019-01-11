<?php 

header('Content-Type: text/html; charset=utf-8');

session_start();

include 'function/print-HTML.php';
include 'sql/sql-function.php';

$conn = ConnectDatabse();

//tiến hành kiểm tra là người dùng đã đăng nhập hay chưa
//nếu chưa, chuyển hướng người dùng ra lại trang đăng nhập
if (!isset($_SESSION['user']) || !isset($_SESSION['hostid'])) {
    $code = $_REQUEST["code"];
    $hostid = $_REQUEST["hostid"];
    if($code == "" || $hostid == ""){
       header('Location: expired.php');
       return;
    }

    // Lấy user
    $sql = "select * from user where code = '$code' and status=1 LIMIT 1";
    #echo $sql;

    $query = mysqli_query($conn,$sql);
    $num_rows = mysqli_num_rows($query);
    // echo $num_rows;
    if ($num_rows == 0) {
        header('Location: expired.php?type=statusis0');
        return;
    }

    while( $row = mysqli_fetch_assoc($query) ) { 
        $user = $row;
        break;
    }

    $_SESSION['user'] = $user;
    $_SESSION['username'] = $user["username"];
    $_SESSION['hostid'] = $hostid;

    // Kiểm tra quyền
    $sql = "select uh.*,h.name as host_name from user_host uh join host h on h.id=uh.hostId where uh.userId =". $user["Id"] . " and uh.hostId=". $hostid . " LIMIT 1";
    $num_rows = mysqli_num_rows($query);

    if ($num_rows == 0) {
        $_SESSION['username'] = NULL;
        $_SESSION['user'] = NULL;
        $_SESSION['hostid'] = NULL;

        header('Location: accessdenied.php?type=notfound');
        return;
    }

    $query = mysqli_query($conn,$sql);
    while( $row = mysqli_fetch_assoc($query) ) { 
        $user_host = $row;
        break;
    }

    $_SESSION['permission_view'] = $user_host["view"];
    $_SESSION['permission_control'] = $user_host["control"];
    $_SESSION['host_name'] = $user_host["host_name"];

    if($user_host["view"] == 0){
        $_SESSION['username'] = NULL;
        $_SESSION['user'] = NULL;
        $_SESSION['hostid'] = NULL;

        header('Location: accessdenied.php?type=viewis0');
        return;
    }

	 //header('Location: login.php');
}




?>

<!DOCTYPE html>
<html lang="en"> 
  <head>
    <meta charset="utf-8">
    <meta refreshpage="true" content="5">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <?php
        echo "<title>Trang chủ - Trạm: " . $_SESSION['host_name'] . "</title>"
    ?>
    
    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="css/google-font-css.css?family=Open+Sans">
    <link rel="stylesheet" type="text/css" href="fonts/font-awesome/css/font-awesome.min.css">
    <!-- Bootst192rap -->
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/jquery-ui.min.css">
    <link rel="stylesheet" type="text/css" href="css/index.css">
    
    <!-- JS -->
    <script type="text/javascript" src="js/ion.sound-3.0.7/ion.sound.min.js"></script>
    <script type="text/javascript" src="js/jquery/jquery.js"></script>
    <script type="text/javascript" src="js/jquery/jquery-ui.min.js"></script>
    <script type="text/javascript" src="js/jquery.ui.touch-punch.min.js"></script>
    <script type="text/javascript" src="js/jquery.tabletoCSV.js"></script>
    <script type="text/javascript" src="js/jquery.bpopup.min.js"></script>
    <script type="text/javascript" src="js/query.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

  </head>
  <body class="lazy-man">
   <!-- Element to pop up -->
   <div id="element_to_pop_up"><img src='loading.gif'/></div>
   <div id="element_to_pop_up_content" class="content" style="height: auto; width: auto;"></div>
    <!-- Fixed navbar -->
    <div class="container"></div>
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class='user-info'>
          <?php
          echo 'Xin chào <b style="color:yellow;">' . $_SESSION['username'] . '</b>'
          ?>
          <div><a href='logout.php' style='color: white !important;'>Thoát</a> -  <a href='changepassword.php'  style='color: white !important;'>Đổi mật khẩu</a></div>
        </div>
        <div class="navbar-header">
            <?php 
                echo "<div style='color: cyan !important;'> Điều khiển: <span class='host-name'>".$_SESSION['host_name']."</span> </div>";
                echo "<div class='host-name-mobile'><span>".$_SESSION['host_name']."</span> </div>";
            ?>
	    </div>
      </div>
    </nav>
    <!-- Conainer -->
    <div class="container">

<!--Hien thi dau vao  =============================================-->
<label for="name"></label>
<?php
function show(){
echo'<script type="text/javascript"> //alert("qwrwqrtwq");
function bam(){
// alert("bam");
// <?php bamphp(); ?>
}
</script>';
}
show();
/*
$path = '/var/www/lazy/file/vao1.txt';
$fp = @fopen($path, "r");

// Kiểm tra file mở thành công không
if (!$fp) {
    echo 'Mở file không thành công';
}
else{
 // Lặp qua từng dòng để đọc
    while(!feof($fp))
    {
        echo fgets($fp);
    }
}*/
echo "<input type='hidden' name='hostid' id='hostid' value='" . $_SESSION['hostid'] . "' />";
echo "<input type='hidden' name='permission_view' id='permission_view' value='" . $_SESSION['permission_view'] . "' />";
echo "<input type='hidden' name='permission_control' id='permission_control' value='" . $_SESSION['permission_control'] . "' />";
?>   
<!--========================================================-->

	 <div class="row">
     <div class="row device-group">
     <b>Thiết bị vào</b>
     </div>
     <?php

       PrintObjectVao($conn);

    ?>
     </div>


	 <div class="row">
     <?php
        if($_SESSION['permission_control'] == 1){
            echo '<div class="row device-group"><b>Thiết bị ra</b></div>';
        }
    ?>
     
    <div class="land-1">


<?php
    if($_SESSION['permission_control'] == 1){


       PrintObjectDatabase($conn);
    }

?>

<div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
<hr/>
<div class='col-lg-12 col-md-12 col-sm-12 col-xs-12' style='padding:10px;text-align:right; margin: 5px; background-color: #c9d9e0;'><!--button id="export" data-export="export">Export (Top 20)</button--> (<a href='export.php' target='_blank'> >> Xem thêm</a>)</div>
<hr/>
<table class='tbllistitem' id="export_table"> 
    <tr>
        <th>
            #
        </th>
        <!--th class='hidden'>
            Device Id
        </th -->
        <th>
            Cảnh báo
        </th>
        <th>
            Trạng thái
        </th>
        <th>
            T/g Bắt đầu
        </th>
        <th>
            T/g Kết thúc
        </th>
    </tr>
<?php

PrintList($conn, 20);

?>

</table>
</div>


<!--
//<?php
//	PrintObjectSend();

//?>
-->



          <div class="clearfix"></div>  
        </div>
      </div>
    </div>
	  <div class="log-box alert alert-danger" role="alert">
			<strong>Woop !</strong>
			<p class="log-text">test demo alert log</p>
		</div>
  </body>
</html>

<?php 
	CloseDatabase($conn);
?>
