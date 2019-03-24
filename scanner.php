<?php 
    include 'function/print-HTML.php';
    include 'sql/sql-function.php';

    $conn = ConnectDatabse();

    $hostid = "0";
    $willsendcms = true;
    if (isset($_REQUEST['hostid'])) {
        $hostid = $_REQUEST["hostid"];
    }

    if (isset($_REQUEST['sms'])) {
        $sms = $_REQUEST["sms"];

        if($sms == "0") {
            $willsendcms = false;
        }
    }

    // Write log
    WriteHistoryObjectVao($conn, $hostid, $willsendcms);

    WriteFileKqDoDinhMuc($conn, $hostid);
?> 

<?php 
	CloseDatabase($conn);
?>
