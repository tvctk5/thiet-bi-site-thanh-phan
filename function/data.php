<?php 
	
	include 'client.php';
	include '../sql/sql-function.php';
	
	$conn = ConnectDatabse();	// connect to database
	$path_dir = '../files/ra/';
	$path_dir_khac = '../files/khac/';

	if (!file_exists($path_dir)) {
		if(mkdir($path_dir, 0777, true)){
		}
	}
	if (!file_exists($path_dir_khac)) {
		if(mkdir($path_dir_khac, 0777, true)){
		}
	}

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
			fclose($fp);
  			
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
			fclose($fp);

			//SendCommandToMaster($str);
			}
		else if($_REQUEST["type"]=="dien") {
			$str = $_REQUEST["value"];
			$device_hostid = $_REQUEST["device_hostid"];
			
			// ghi file
			$path = $path_dir .'ra_cau_dao_value.txt';
			$fp = @fopen($path, "w+");
			fwrite($fp, $str);
			fclose($fp);

			UpdateValueByObjId($conn, "ra_cau_dao", $str, $device_hostid);
		}
		else if($_REQUEST["type"]=="tudong_dieuhoa_quat") {
			$str = $_REQUEST["value"];
			$device_hostid = $_REQUEST["device_hostid"];
			
			// ghi file
			$path = $path_dir .'ra_cau_dao_value.txt';
			$fp = @fopen($path, "w+");
			fwrite($fp, $str);
			fclose($fp);

			UpdateValueByObjId($conn, "ra_cau_dao", $str, $device_hostid);
		}
		else if($_REQUEST["type"]=="ra_1_tudong_dieuhoa_quat") {
			$str = $_REQUEST["value"];
			$device_hostid = $_REQUEST["device_hostid"];
			
			// ghi file
			$path = $path_dir .'ra_1_value.txt';
			$fp = @fopen($path, "w+");
			fwrite($fp, $str);
			fclose($fp);

			UpdateValueByObjId($conn, "ra_1", $str, $device_hostid);
		} else if($_REQUEST["type"]=="typeId_3_nhan_cong_tu_dong") {
			$str = $_REQUEST["value"];
			$device_hostid = $_REQUEST["device_hostid"];
			
			// ghi file
			$path = $path_dir_khac .'nhan_cong_tu_dong_value.txt';
			$fp = @fopen($path, "w+");
			fwrite($fp, $str);
			fclose($fp);

			UpdateValueByObjId($conn, "nhan_cong_tu_dong", $str, $device_hostid);
		}
		else if($_REQUEST["type"]=="mute") {
			$value = $_REQUEST["value"];
			$objtype = $_REQUEST["objtype"];
			$objid = $_REQUEST["objid"];
			$device_hostid = $_REQUEST["device_hostid"];

			UpdateMuteByObjId($conn, $objid, $objtype, $value, $device_hostid);
		}
		else if($_REQUEST["type"]=="range_change") {
			$value = $_REQUEST["value"];
			$id = $_REQUEST["id"];
			$device_hostid = $_REQUEST["device_hostid"];

			UpdateRangeValue($conn, $id, $value, $device_hostid);
		}
	}
	


	CloseDatabase($conn);
	
?>



