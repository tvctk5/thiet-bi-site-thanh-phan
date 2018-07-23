<?php 
	
	include 'client.php';
	include '../sql/sql-function.php';
	
	$conn = ConnectDatabse();	// connect to database
	$path_dir = '../files/ra/';

	if( $_REQUEST["type"] ) {

		if($_REQUEST["type"]=="update") {

			$name = $_REQUEST["name"];
			$str = $_REQUEST["update"];
			$fileName = $_REQUEST["nameFile"];
			$device_hostid = $_REQUEST["device_hostid"];

			// ghi file
			$path = $path_dir . $fileName .'.txt';
			$fp = @fopen($path, "w+");
			fwrite($fp, $str);
  			
			// update to database
			UpdateObject($conn, $name, $str, $device_hostid);

			
		}
		else if($_REQUEST["type"]=="status") {
			$str = $_REQUEST["state"];
			$device_hostid = $_REQUEST["device_hostid"];
			// ghi file
			$path = $path_dir . 'typeState.txt';
			$fp = @fopen($path, "w+");
			fwrite($fp, $str);

			//SendCommandToMaster($str);
			}
		else if($_REQUEST["type"]=="dien") {
			$str = $_REQUEST["value"];
			$device_hostid = $_REQUEST["device_hostid"];
			
			// ghi file
			$path = $path_dir .'ra_cau_dao_value.txt';
			$fp = @fopen($path, "w+");
			fwrite($fp, $str);

			UpdateValueByObjId($conn, "ra_cau_dao", $str, $device_hostid);
		}
		else if($_REQUEST["type"]=="tudong_dieuhoa_quat") {
			$str = $_REQUEST["value"];
			$device_hostid = $_REQUEST["device_hostid"];
			
			// ghi file
			$path = $path_dir .'ra_cau_dao_value.txt';
			$fp = @fopen($path, "w+");
			fwrite($fp, $str);

			UpdateValueByObjId($conn, "ra_cau_dao", $str, $device_hostid);
		}
		else if($_REQUEST["type"]=="ra_1_tudong_dieuhoa_quat") {
			$str = $_REQUEST["value"];
			$device_hostid = $_REQUEST["device_hostid"];
			
			// ghi file
			$path = $path_dir .'ra_1_value.txt';
			$fp = @fopen($path, "w+");
			fwrite($fp, $str);

			UpdateValueByObjId($conn, "ra_1", $str, $device_hostid);
		}
		else if($_REQUEST["type"]=="mute") {
			$value = $_REQUEST["value"];
			$objtype = $_REQUEST["objtype"];
			$objid = $_REQUEST["objid"];
			$device_hostid = $_REQUEST["device_hostid"];

			UpdateMuteByObjId($conn, $objid, $objtype, $value, $device_hostid);
		}
		else if($_REQUEST["type"]=="range_demayno") {
			$value = $_REQUEST["value"];
			$id = $_REQUEST["id"];
			$device_hostid = $_REQUEST["device_hostid"];

			UpdateRangeDienMayNo($conn, $id, $value, $device_hostid);
		}
	}
	


	CloseDatabase($conn);
	
?>



