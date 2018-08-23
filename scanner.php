<?php 
    include 'function/print-HTML.php';
    include 'sql/sql-function.php';

    $conn = ConnectDatabse();

    $hostid = "0";
    if (isset($_REQUEST['hostid'])) {
        $hostid = $_REQUEST["hostid"];
    }

    // Write log
    WriteHistoryObjectVao($conn, $hostid);
?> 

<?php 
	CloseDatabase($conn);
?>
