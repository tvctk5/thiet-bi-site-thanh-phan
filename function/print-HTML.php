<?php

function WriteHtmlLog($log){
	echo "<div>" . $log . "</div>";
}

// Hien thi thong tin thiết bị đo
function PrintObjectDo($conn) {

	$sql = "SELECT d.id as deviceid, d.name as name,d.flavor as flavor,d.icon as icon,d.objid as objid, d.type as type, d.on_text, d.off_text, d.unit, dh.* ,dh.id as device_hostid  FROM device d join device_host dh on d.id = dh.deviceId and dh.hostId=" . $_SESSION['hostid'] . " and dh.status=1 where d.typeId=2 ORDER BY d.id";
	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
		// // output data of each row
		// $lastRow;
		// $arrayGroup = array(4,2,3);
		// $arrIndex = 0;
		// $itemIndex = 1;

	    // while($row = $result->fetch_assoc()) {
		// 	if($itemIndex == 1){
		// 		echo '<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">';
		// 	}
		// 	if(!isset($lastRow)){
		// 		$lastRow = $row;
		// 	}
		// 	PrintDo($row["id"], $row["type"], $row["name"], $row["state"], $row["flavor"], $row["amplitude"], $row["icon"], $row["objid"], $row["value"], $row["device_hostid"], $row["deviceid"], $row["hostId"], $row["on_text"], $row["off_text"], $conn);
			
		// 	if($itemIndex == $arrayGroup[$arrIndex]){
		// 		echo '</div>';
		// 		$itemIndex = 1;
		// 		$arrIndex = $arrIndex + 1;
		// 	}
		// }
		$data = [];
		while($row = $result->fetch_assoc()) {
			$data[] = $row;
		}

		$index = 0;
		// Group 1
		echo '<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 div-do-group">';
		echo '    <div class="col-sm-12 col-xs-12 div-do-row">';
		echo '    	<div class="col-sm-6 col-xs-6">'. $data[$index]["name"] . '</div>';
		echo '    	<div class="col-sm-6 col-xs-6">'. $data[$index]["value"] . $data[$index]["unit"] . ' - ' . $data[$index + 1]["value"] . $data[$index + 1]["unit"] . '</div>';
		echo '    </div>';
		echo '    <div class="col-sm-12 col-xs-12 div-do-row">';
		echo '    	<div class="col-sm-6 col-xs-6">'. $data[$index + 2]["name"] . '</div>';
		echo '    	<div class="col-sm-6 col-xs-6">'. $data[$index + 2]["value"] . $data[$index + 2]["unit"] . ' - ' . $data[$index + 3]["value"] . $data[$index + 3]["unit"] . '</div>';
		echo '    </div>';
		echo '    <div class="col-sm-12 col-xs-12 div-do-row">';
		echo '    	<div class="col-sm-6 col-xs-6">'. $data[$index + 4]["name"] . '</div>';
		echo '    	<div class="col-sm-6 col-xs-6">'. $data[$index + 4]["value"] . $data[$index + 4]["unit"] . ' - ' . $data[$index + 5]["value"] . $data[$index + 5]["unit"] . '</div>';
		echo '    </div>';
		echo '    <div class="col-sm-12 col-xs-12 div-do-row">';
		echo '    	<div class="col-sm-6 col-xs-6">'. $data[$index + 6]["name"] . '</div>';
		echo '    	<div class="col-sm-6 col-xs-6">'. $data[$index + 6]["value"] . $data[$index + 6]["unit"] . ' - ' . $data[$index + 7]["value"] . $data[$index + 7]["unit"] . '</div>';
		echo '    </div>';
		echo '</div>';

		
		// Group 2
		echo '<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 div-do-group">';
		echo '    <div class="col-sm-12 col-xs-12 div-do-row">';
		echo '    	<div class="col-sm-6 col-xs-6">'. $data[$index + 8]["name"] . '</div>';
		echo '    	<div class="col-sm-6 col-xs-6">'. $data[$index + 8]["value"] . $data[$index + 8]["unit"] . '</div>';
		echo '    </div>';
		echo '    <div class="col-sm-12 col-xs-12 div-do-row">';
		echo '    	<div class="col-sm-6 col-xs-6">'. $data[$index + 9]["name"] . '</div>';
		echo '    	<div class="col-sm-6 col-xs-6">'. $data[$index + 9]["value"] . $data[$index + 9]["unit"] . '</div>';
		echo '    </div>';
		echo '</div>';

		// Group 3
		echo '<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 div-do-group">';
		echo '    <div class="col-sm-12 col-xs-12 div-do-row">';
		echo '    	<div class="col-sm-6 col-xs-6">'. $data[$index + 10]["name"] . '</div>';
		echo '    	<div class="col-sm-6 col-xs-6">'. $data[$index + 10]["value"] . $data[$index + 10]["unit"] . '</div>';
		echo '    </div>';
		echo '    <div class="col-sm-12 col-xs-12 div-do-row">';
		echo '    	<div class="col-sm-6 col-xs-6">'. $data[$index + 11]["name"] . '</div>';
		echo '    	<div class="col-sm-6 col-xs-6">'. $data[$index + 11]["value"] . $data[$index + 11]["unit"] . '</div>';
		echo '    </div>';
		echo '    <div class="col-sm-12 col-xs-12 div-do-row">';
		echo '    	<div class="col-sm-6 col-xs-6">'. $data[$index + 12]["name"] . '</div>';
		echo '    	<div class="col-sm-6 col-xs-6">'. $data[$index + 12]["value"] . $data[$index + 12]["unit"] . '</div>';
		echo '    </div>';
		echo '</div>';

	} else {
	    echo "0 results";
	}
}

// Print object
function PrintDo($name, $value0, $value1, $unit0, $unit1) {
	echo '<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">';
		echo '<div class="object '.$objType . ' ' . $objType . "-" . $stateViewLower . " " .$objFalvor. " " .$stateName.'" id="'. $objId .'" mute="' . $mute . '">';

		echo '</div>';
	echo '</div>';
	
}

// Hien thi thong tin vao
function PrintObjectVao($conn) {

	$sql = "SELECT d.id as deviceid, d.name as name,d.flavor as flavor,d.icon as icon,d.objid as objid, d.type as type, d.on_text, d.off_text, dh.* ,dh.id as device_hostid  FROM device d join device_host dh on d.id = dh.deviceId and dh.hostId=" . $_SESSION['hostid'] . " and dh.status=1 where d.typeId = 0";
	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
	    // output data of each row
	    while($row = $result->fetch_assoc()) {
	        PrintVao($row["id"], $row["type"], $row["name"], $row["state"], $row["flavor"], $row["amplitude"], $row["icon"], $row["objid"], $row["value"], $row["device_hostid"], $row["deviceid"], $row["hostId"], $row["on_text"], $row["off_text"], $conn);
	    }
	} else {
	    echo "0 results";
	}
}

// Print object
function PrintVao($id, $objType, $objName, $state, $objFalvor, $amplitude, $icon, $objId, $value, $device_hostid, $deviceid, $hostid, $on_text, $off_text, $conn) {

	$bg_cl = "background-color-off";
	$stateView =  $off_text; //"OFF";
	// $stateView =  "OFF";
	$stateViewLower = "off";
	$stateValue = "0";
	$stateName = "";
	$stateButton = "";

	if($state == 1) {
		$stateButton = "switch-on";
		$stateName = "turn-on";
	}

	$mute = $value;
	if($mute == null){
		$mute = '0';
	}
	
	if($state == 1) {
		$bg_cl = "background-color-on";
		$stateView = $on_text; //"ON";
		// $stateView = "ON";
		$stateViewLower = "on";
		$stateValue = "1";
	}

	echo '<div class="col-lg-3 col-md-4 col-sm-6 col-xs-6 ' . $bg_cl . ' parent-item" data-device_hostid="' . $device_hostid . '" data-deviceid="' . $deviceid . '" data-hostid="' . $hostid . '" data-type="' . $objType . '" data-objid="' . $objId . '">';
		echo '<div class="object '.$objType . ' ' . $objType . "-" . $stateViewLower . " " .$objFalvor. " " .$stateName.'" id="'. $objId .'" mute="' . $mute . '">';
			echo '<div class="obj-info">',
	                '<p class="obj-header">'.$objName.'</p>';

			echo ' <div class="clearfix"><b>' . $stateView . '</b></div>';

	        echo ' <div class="clearfix"></div>';
			echo '</div>';
		echo '</div>';
	echo '</div>';
	
}

function getQuota($dataQuotaHost, $hostId, $deviceId, $month){
	foreach ($dataQuotaHost as $row){
		if($row["hostId"] == $hostId && $row["deviceId"] == $deviceId && strpos($row["months"], ',' . $month . ',') !== false){
			return $row;
		}
	}
}


// Hien thi thong tin vao
function WriteHistoryObjectVao($conn, $hostid) {
	// quota for host
	$dataQuotaHost[] = null;
	$sqlquotahost = "SELECT d.*, c.months FROM device_host_quota d join calendar c on d.calendarId=c.id  WHERE d.hostId=" . $hostid;
	$qquotahost = mysqli_query($conn, $sqlquotahost) or die("error to fetch tot hosts data; Query: " .$sqlquotahost . '; Error:'. $conn->error);
	while( $row = mysqli_fetch_assoc($qquotahost) ) { 
		$dataQuotaHost[] = $row;
	}

	$sql = "SELECT d.id as deviceid, d.name as name,d.flavor as flavor,d.icon as icon,d.objid as objid, d.type as type, d.typeId as typeId, dh.* ,dh.id as device_hostid  FROM device d join device_host dh on d.id = dh.deviceId and dh.hostId=" . $hostid . " and dh.status=1 where d.typeId=0 OR d.typeId=2";
	
	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
		// output data of each row
		while($row = $result->fetch_assoc()) {
			// Thiết bị Vào
			if($row["typeId"] == 0){
				WriteHistory($row["id"], $row["type"], $row["name"], $row["state"], $row["flavor"], $row["amplitude"], $row["icon"], $row["objid"], $row["value"], $row["device_hostid"], $row["deviceid"], $row["hostId"], $conn, $dataQuotaHost);
				continue;
			}
			// Kết quả đo
			if($row["typeId"] == 2){
				UpdateStateKqDo($conn, $row["objid"], $row["device_hostid"]);
				continue;
			}	
		}
	} else {
		echo "0 results";
	}
}


// Print object
function UpdateStateKqDo($conn, $objId, $device_hostid) {
	$value = "0";

	$link = 'files/do/' . $objId .'.txt';

	$content = file_get_contents($link);

	if($content[0] == "") { return;}

	$value = $content;
	
	// Update device_host
	$sql = "UPDATE device_host SET value='" . $value . "', updatedate=SYSDATE() WHERE id=$device_hostid";
	if ($conn->query($sql) === TRUE){
		echo "<div>device_host[typeId=2]: Record updated successfully" . PHP_EOL .'</div>';
	}
	else
	    echo "<div>device_host[typeId=2]: Error updating record: SQL: " . $sql . "; ERROR: " . $conn->error . PHP_EOL . '</div>';
}

// Print object
function WriteHistory($id, $objType, $objName, $state, $objFalvor, $amplitude, $icon, $objId, $value, $device_hostid, $deviceid, $hostid, $conn, $dataQuotaHost) {
	
	$bg_cl = "background-color-off";
	$stateView = "OFF";
	$stateViewLower = "off";
	$stateValue = "0";
	$stateName = "";
	$stateButton = "";

	if($state) {
		$stateButton = "switch-on";
		$stateName = "turn-on";
	}
	$link = 'files/vao/' . $objId .'.txt';
	// echo $link .'<br>';
	$content = file_get_contents($link);
		// echo 'dâta: '. $content[0] . '<br>';

	$mute = $value;
	if($mute == null){
		$mute = '0';
	}

	if($content[0] != "1" && $content[0] != "0") { return;}
	
	if($content[0] == "1") {
		$bg_cl = "background-color-on";
		$stateView = "ON";
		$stateViewLower = "on";
		$stateValue = "1";
	}

	if($objId == "vao_dien_luoi" || $objId == "vao_tong_dai") {
		if($content[0] == "0") {
			$bg_cl = "background-color-on";
			$stateView = "ON";
			$stateViewLower = "on";
			$stateValue = "1";
		} else{
			$bg_cl = "background-color-off";
			$stateView = "OFF";
			$stateViewLower = "off";
			$stateValue = "0";
		}
	}

	// Check history
	CheckAndCreateUpdateHistory($conn, $deviceid, $stateValue, $hostid, $device_hostid, $dataQuotaHost);
}

// Hien thi thong tin vao
function CheckAndCreateUpdateHistory($conn, $objId, $statusValue, $hostid, $device_hostId, $dataQuotaHost) {
	$deviceId = $objId;
	$sms_groupId = 1; // Warning group
	// Update device_host
	$sql = "UPDATE device_host SET state=" . $statusValue . ", updatedate=SYSDATE() WHERE id=" . $device_hostId;
	if ($conn->query($sql) === TRUE){
		WriteHtmlLog("device_host[typeId=0]: Record updated successfully" . PHP_EOL);
	}
	else
		WriteHtmlLog("device_host[typeId=0]: Error updating record: " . $conn->error . PHP_EOL);

	// Create history
	// Start ON
	if($statusValue == '1'){
		// echo 'statusValue = 1';

		$sql = "SELECT * FROM history WHERE hostid=$hostid AND deviceid='". $objId . "' AND startdate is NOT NULL and enddate is NULL ORDER BY id DESC LIMIT 1";
		$result = $conn->query($sql);
		if ($result->num_rows <= 0) {
			//echo '$result->num_rows <= 0';
			// Create new
			$sql = "INSERT INTO history(hostid,deviceid,device_hostid,value,startdate,createdate,month_of_log) VALUES($hostid, $objId, $device_hostId, '$statusValue', SYSDATE(),SYSDATE(),MONTH(SYSDATE()))";
			if ($conn->query($sql) === TRUE){
				// SMS
				$sql = "INSERT INTO sms(hostId, deviceId, device_hostId, type, sms_groupId) VALUES ($hostid, $deviceId,$device_hostId, $deviceId". $statusValue .",". $sms_groupId .")";
				if ($conn->query($sql) === TRUE){}
			}
				// echo "Record inserted successfully";
			else
				echo "Error inserting record: " . $conn->error;

		}
	}
	else{
		// echo 'statusValue = 0';
		// = 0
		$sql = "SELECT *, TIME_TO_SEC(TIMEDIFF(SYSDATE(), startdate))/3600 as hours_u, TIME_TO_SEC(TIMEDIFF(SYSDATE(), startdate))/60 as minutes_u, TIME_TO_SEC(TIMEDIFF(SYSDATE(), startdate)) as seconds_u 
				FROM history WHERE hostid=$hostid AND deviceid='$objId' AND startdate is NOT NULL and enddate is NULL ORDER BY id DESC LIMIT 1";
		// echo "SQL: " . $sql;
		$result = $conn->query($sql) or die("SQL: " . $sql . "; Error: " . $conn->error);
		if ($result->num_rows > 0) {
			 // output data of each row
			 while($row = $result->fetch_assoc()) {
				$id = $row["id"];
				$month_of_log = $row["month_of_log"];
				$deviceid = $row["deviceid"];
				$hours_u = $row["hours_u"];
				$minutes_u = $row["minutes_u"];
				$seconds_u = $row["seconds_u"];

				// Định mức
				$quotaItem = getQuota($dataQuotaHost, $hostid, $deviceid, $month_of_log);
				$quota = $quotaItem["quota"];
				$operator = $quotaItem["operator"];

				$time = '';
				$result = '';
				
				$time = $hours_u;

				if($operator == "*"){
					$result = $time * $quota;
				} else {
					$result = $quota - $time;
				}

				$sql = "UPDATE history SET value='$statusValue', enddate=SYSDATE(), updatedate=SYSDATE(),  
					hours=$hours_u, minutes=$minutes_u, seconds=$seconds_u, quota=$quota, operator='$operator', result=$result
					WHERE id=$id";

				if ($conn->query($sql) === TRUE){
					// SMS
					$sql = "INSERT INTO sms(hostId, deviceId, device_hostId, type, sms_groupId) VALUES ($hostid, $deviceId,$device_hostId, $deviceId". $statusValue .",". $sms_groupId .")";
					if ($conn->query($sql) === TRUE){}
				}
					//echo "Record updated successfully";
				else
					echo "Error updating record: " . $conn->error;
			}
		} 
		/*else{
			// create new 
			$sql = "INSERT INTO history(deviceid,value,enddate) VALUES($objId, '$statusValue', SYSDATE())";
			if ($conn->query($sql) === TRUE)
				echo "Record inserted successfully";
			else
				echo "Error inserting record: " . $conn->error;
		}*/
	}
}


function PrintList($conn, $count) {
	$sql = '';

	if($count == 0){
		// Get all
		$sql = "SELECT h.id, h.startdate, h.enddate, h.value, h.value as state, d.name, d.id as deviceid, d.objid, h.hours, h.minutes, h.seconds, h.month_of_log, h.quota, h.operator, h.result 
		FROM history h join device d on h.deviceid = d.id where h.hostid=" . $_SESSION['hostid'] . " ORDER BY h.id DESC, h.startdate DESC";
	}else{
		$sql = "SELECT h.id, h.startdate, h.enddate, h.value, h.value as state, d.name, d.id as deviceid, d.objid, h.hours, h.minutes, h.seconds, h.month_of_log, h.quota, h.operator, h.result 
		FROM history h join device d on h.deviceid = d.id where h.hostid=" . $_SESSION['hostid'] . " ORDER BY h.id DESC, h.startdate DESC LIMIT " . $count;
	}

	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
	    // output data of each row
	    while($row = $result->fetch_assoc()) {
	        PrintLine($row["id"], $row["name"], $row["state"], $row["startdate"], $row["enddate"], $row);
	    }
	} else {
	    echo "0 row";
	}
}

// Print object
function PrintLine($Id, $objName, $state, $startdate, $enddate, $row) {
	$statuName = 'OFF';
	if($state == "1"){
		$statuName = 'ON';
	}
	$time = $row["hours"];
	$quota = $row["quota"];
	$result = $row["result"];
	
	// <td class='hidden'>
	// $deviceid
	// </td>
	echo "<tr>
		<td>
			$Id
		</td>		
		<td>
			$objName
		</td>
		<td>
			$statuName
		</td>
		<td>
			$startdate
		</td>
		<td>
			$enddate
		</td>
		<td class='td-text-right'>
			$time
		</td>
		<td class='td-text-right'>
			$quota
		</td>
		<td class='td-text-right'>
			$result
		</td>
	</tr>";
}


// Print object: Export page
function PrintLine_ExportPage($Id, $objName, $state, $startdate, $enddate, $hostid, $host_name, $note, $row) {
	$statuName = 'OFF';
	if($state == "1"){
		$statuName = 'ON';
	}
	
	$time = $row["hours"];
	$quota = $row["quota"];
	$result = $row["result"];
	
	// <td class='hidden'>
	// $deviceid
	// </td>
	echo "<tr>
		<td>
			$Id
		</td>
		<td>
			$hostid
		</td>
		<td>
			$host_name
		</td>
		<td>
			$objName
		</td>
		<td>
			$startdate
		</td>
		<td>
			$enddate
		</td>
		<td class='td-text-right'>
			$time
		</td>
		<td class='td-text-right'>
			$quota
		</td>
		<td class='td-text-right'>
			$result
		</td>
	</tr>";
}


// Hien thi thong tin vao
function WriteFileKqDoDinhMuc($conn, $hostid) {
	// quota for host
	$dataQuotaHost = [];
	$rootPath = 'files/do';
	$prefix = '_quota.txt';

	// Kết quả đo
	$sqlquotahost = "SELECT dhq.*, d.objid, d.typeId FROM device_host_quota dhq join device d on d.id=dhq.deviceId AND d.typeId=2  WHERE dhq.hostId=" . $hostid . " AND dhq.edited=1";
	$qquotahost = mysqli_query($conn, $sqlquotahost) or die("error to fetch tot hosts data; Query: " .$sqlquotahost . '; Error:'. $conn->error);
	while( $row = mysqli_fetch_assoc($qquotahost) ) { 
		$dataQuotaHost[] = $row;
	}

	foreach ($dataQuotaHost as $row){
		CreateFile($row["objid"] . $prefix, $rootPath, $row["quota"]);

		$sql = 'UPDATE device_host_quota SET edited=0
				WHERE id='. $row["id"];

		if ($conn->query($sql) === TRUE){
			WriteHtmlLog("[CreateFile -  TypeId=2]Record updated successfully");
		}
		else
			WriteHtmlLog("[CreateFile -  TypeId=2] Error updating record: " . $conn->error);
	}
}

function CreateFile($name, $path, $content){
	$fullPath = $path . '/' . $name;
	
	if (!file_exists($path)) {
		if(mkdir($path, 0777, true)){
		}
	}

	$myfile = fopen($fullPath, "w") or die("Unable to open file!");
	$txt = $content. "";
	fwrite($myfile, $txt);
	fclose($myfile);
}


function PrintObjectDatabaseByTypeId($conn, $typeId) {
	// $sql = "SELECT *  FROM device where type <> 'obj-vao'";
	$sql = "SELECT d.id as deviceid, d.name as name,d.flavor as flavor,d.icon as icon,d.objid as objid, d.type as type, d.typeId as typeId, dh.* ,dh.id as device_hostid  FROM device d join device_host dh on d.id = dh.deviceId and dh.hostId=" . $_SESSION['hostid'] . " and dh.status=1 where d.typeId = " . $typeId;
	//die($sql);
	// return;
	// WriteHtmlLog($sql);
	$result = $conn->query($sql) or die("EXEC error! Query: " . $sql . "; error: ". $conn->error);

	if ($result->num_rows > 0) {
	    // output data of each row
	    while($row = $result->fetch_assoc()) {
	        PrintObjectByTypeId($row["type"], $row["name"], $row["state"], $row["flavor"], $row["amplitude"], $row["icon"], $row["objid"], $row["value"], $row["device_hostid"], $row["deviceid"], $row["hostId"], $row["typeId"]);
	    }
	} else {
	    echo "0 results";
	}
}

// Print object
function PrintObjectByTypeId($objType, $objName, $state, $objFalvor, $amplitude, $icon, $objId, $value, $device_hostid, $deviceid, $hostid, $typeId) {
	if($typeId == 3){
		switch($objType){
			case "obj-radiobutton": 
				if($objId == "nhan_cong_tu_dong"){
					$selected_0 = "";
					$selected_1 = "";
		
					if($value == "0") {
						$selected_0 = "checked";
					}else{
						$selected_1 = "checked";
					}
					echo '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 class-nhan_cong_tu_dong" data-device_hostid="' . $device_hostid . '" data-deviceid="' . $deviceid . '" data-hostid="' . $hostid . '" data-type="' . $objType . '" data-objid="' . $objId . '">';
		
					// echo '<div class="class-nhan_cong_tu_dong">';
					echo '<label class="font-weight-bold">'. $objName . ': </label>';
					echo '<label class="radio-inline" for="nhan_cong_tu_dong_0"><input id="nhan_cong_tu_dong_0" name="nhan_cong_tu_dong" type="radio"' . $selected_0 .' value="0" class="" />Nhân công</label>';
		
					echo '<label class="radio-inline" for="nhan_cong_tu_dong_1"><input id="nhan_cong_tu_dong_1" name="nhan_cong_tu_dong" type="radio" ' . $selected_1 .' value="1" />Tự động</label>';
		
					echo '</div>';
				} 
			break;
		
			case "obj-................":
		
		
			break;
		
			case "obj-................":
		
		
			break;
		
			case "obj-................":
		
		
			break;
		
		}

	} else {
		$stateName = "";
		$stateButton = "";
		// echo "----------:". $state;
		if($state) {
			$stateButton = "switch-on";
			$stateName = "turn-on";
		}
		$buttonUpDown = "";
		if($objType == "obj-de-may-no" || $objType == "obj-ra-say-may-no" || $objType == "obj-ra-tat-may-no"){
			$buttonUpDown = 'obj-button-up-down-icon';
			$objFalvor = '';
			$stateName = "";
		}

		echo '<div class="col-lg-3 col-md-4 col-sm-6 col-xs-6 parent-item" data-device_hostid="' . $device_hostid . '" data-deviceid="' . $deviceid . '" data-hostid="' . $hostid . '" data-type="' . $objType . '" data-objid="' . $objId . '">';
			echo '<div class="object '.$objType . " " .$objFalvor. " " .$stateName.'" id="'. $objId .'">';
				echo '<div class="obj-info">',
						'<p class="obj-header">'.$objName.'</p>';

					if( $objType != "obj-button") {
						echo'<p class="obj-counter-percent">', 
								//'<i class="fa '.$icon.'"></i>',
								//'<b class="counter">'.$amplitude.'</b>',
							'</p>';
						echo  '</div>';
					}
				
				if($objType == "obj-radiobutton"){
					echo '<div class="obj-timer ignore-onclick">';
					echo '<div class="switch-button '.$stateButton.'"></div>';
					echo '</div>';
				} else {
					echo '<div class="obj-timer '. $buttonUpDown .'" id="up-down-button-'. $device_hostid .'" rangeInputId="'. $device_hostid .'">
							<svg class="timer-progress" viewbox="0 0 82 82">
								<circle class="progress-bg" r="39" cx="41" cy="41" stroke-dasharray="245"></circle>
								<circle class="progress-bar" r="39" cx="41" cy="41" stroke-dasharray="245"></circle>
							</svg>',
							'<i class="obj-icon fa '.$icon.'"></i>',
							'</div>';
				}
				if($objType == "obj-ra")
					echo '<div class="switch-button '.$stateButton.'"></div>';
				
			else if( $objType == "obj-button")
					echo '<div class="switch-button '.$stateButton.'" id-sub="'. $objId .'"></div>';
				else if( $objType == "obj-turn obj-slider" ) {
					echo '<div class="switch-button type-turn"></div>
							//<div class="obj-off"><i class="fa fa-close"></i></div>
							//<div class="slider-range-min"></div>';

				}
				
			// if($objType == "obj-de-may-no"){
			// 	echo '<div class="obj-de-may-no" style="padding-left: 20px;color:yellow">';
			// 	echo 'Thời gian: <input style="width: 50px;color:red !important" type="text" id="obj-de-may-no-input" name="obj-de-may-no-input" value="' . $amplitude . '"/> (giây)';
			// 	echo '</div>';

			// 	echo '<div class="slidecontainer">
			// 	<input type="range" min="3" max="15" value="' . $amplitude . '" class="slider" id="deMayNo" deviceId="'.$deviceid.'">
			// 	</div>';
			// }


	switch($objType){
		case "obj-radiobutton": 
			if($objId == "ra_cau_dao"){
				$selected_dienmayno = "";
				$selected_dienluoi = "";

				if($value == "0") {
					$selected_dienmayno = "checked";
				}else{
					$selected_dienluoi = "checked";
				}

				echo '<div class="class-ra_cau_dao">';

				echo '<div class="radio">';
				echo '<label for="dien-may-no"><input id="dien-may-no" name="ra_cau_dao" type="radio"' . $selected_dienmayno .' value="0" class="" />Điện máy nổ</label>';
				echo '</div>';

				echo '<div class="radio">';
				echo '<label for="dien-luoi"><input id="dien-luoi" name="ra_cau_dao" type="radio" ' . $selected_dienluoi .' value="1" />Điện lưới</label>';
				echo '</div>';

				echo '</div>';
			} else{
				if($objId == "ra_1"){
					$selected_tudong = "";
					$selected_dieuhoa = "";
					$selected_quat = "";
					
					if($value == "0") {
						$selected_tudong = "checked";
					}else{
						if($value == "1") {
							$selected_dieuhoa = "checked";
						} else{
							$selected_quat = "checked";
						}
					}
					
					echo '<div class="class-ra-objradiobutton class-ra_1">';
					
					echo '<div class="radio">';
					echo '<label for="tu-dong"><input id="tu-dong" name="ra_1" type="radio"' . $selected_tudong .' value="0" class="" /> Tự động</label>';
					echo '</div>';
					
					echo '<div class="radio">';
					echo '<label for="dieu-hoa"><input id="dieu-hoa" name="ra_1" type="radio" ' . $selected_dieuhoa .' value="1" /> Điều hòa</label>';
					echo '</div>';
					
					echo '<div class="radio">';
					echo '<label for="quat"><input id="quat" name="ra_1" type="radio" ' . $selected_quat .' value="2" /> Quạt</label>';
					echo '</div>';
					
					echo '</div>';
					}
			}

			break;

		case "obj-de-may-no":
			echo '<div class="obj-de-may-no" style="padding-left: 20px;color:yellow">';
			echo 'Thời gian: <input style="width: 50px;color:red !important" type="text" id="obj-de-may-no-input" name="obj-de-may-no-input" value="' . $amplitude . '" class="range-value-input range-value-input-'. $device_hostid .'"/> (giây)';
			echo '</div>';

			echo '<div class="slidecontainer">
			<input type="range" min="3" max="15" value="' . $amplitude . '" class="slider slider-change-range-max-min" id="deMayNo" deviceId="'.$deviceid.'" textViewId="obj-de-may-no-input">
			</div>';

		break;

		case "obj-ra-say-may-no":
			echo '<div class="obj-ra-say-may-no" style="padding-left: 20px;color:yellow">';
			echo 'Thời gian: <input style="width: 50px;color:red !important" type="text" id="obj-ra-say-may-no-input" name="obj-ra-say-may-no-input" value="' . $amplitude . '" class="range-value-input range-value-input-'. $device_hostid .'"/> (giây)';
			echo '</div>';

			echo '<div class="slidecontainer">
			<input type="range" min="3" max="15" value="' . $amplitude . '" class="slider slider-change-range-max-min" id="sayMayNo" deviceId="'.$deviceid.'" textViewId="obj-ra-say-may-no-input">
			</div>';

		break;

		case "obj-ra-tat-may-no":
			echo '<div class="obj-ra-tat-may-no" style="padding-left: 20px;color:yellow">';
			echo 'Thời gian: <input style="width: 50px;color:red !important" type="text" id="obj-ra-tat-may-no-input" name="obj-ra-tat-may-no-input" value="' . $amplitude . '" class="range-value-input range-value-input-'. $device_hostid .'"/> (giây)';
			echo '</div>';

			echo '<div class="slidecontainer">
			<input type="range" min="3" max="15" value="' . $amplitude . '" class="slider slider-change-range-max-min" id="tatMayNo" deviceId="'.$deviceid.'" textViewId="obj-ra-tat-may-no-input">
			</div>';

		break;

		case "obj-................":


		break;

		case "obj-................":


		break;

		case "obj-................":


		break;

	}
						

				echo ' <div class="clearfix"></div>';
			echo '</div>';
		echo '</div>';

	}
	
}

?>