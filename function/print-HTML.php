<?php 

function PrintObjectDatabase($conn) {

	// $sql = "SELECT *  FROM device where type <> 'obj-vao'";
	$sql = "SELECT d.id as deviceid, d.name as name,d.flavor as flavor,d.icon as icon,d.objid as objid, d.type as type, dh.* ,dh.id as device_hostid  FROM device d join device_host dh on d.id = dh.deviceId and dh.hostId=" . $_SESSION['hostid'] . " and dh.status=1 where d.type <> 'obj-vao'";
//die($sql);
// return;
	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
	    // output data of each row
	    while($row = $result->fetch_assoc()) {
	        PrintObject($row["type"], $row["name"], $row["state"], $row["flavor"], $row["amplitude"], $row["icon"], $row["objid"], $row["value"], $row["device_hostid"], $row["deviceid"], $row["hostId"]);
	    }
	} else {
	    echo "0 results";
	}
}

// Print object
function PrintObject($objType, $objName, $state, $objFalvor, $amplitude, $icon, $objId, $value, $device_hostid, $deviceid, $hostid) {
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

// Hien thi thong tin vao
function PrintObjectVao($conn) {

	$sql = "SELECT d.id as deviceid, d.name as name,d.flavor as flavor,d.icon as icon,d.objid as objid, d.type as type, d.on_text, d.off_text, dh.* ,dh.id as device_hostid  FROM device d join device_host dh on d.id = dh.deviceId and dh.hostId=" . $_SESSION['hostid'] . " and dh.status=1 where d.type = 'obj-vao'";
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


// Hien thi thong tin vao
function WriteHistoryObjectVao($conn, $hostid) {
	
	$sql = "SELECT d.id as deviceid, d.name as name,d.flavor as flavor,d.icon as icon,d.objid as objid, d.type as type, dh.* ,dh.id as device_hostid  FROM device d join device_host dh on d.id = dh.deviceId and dh.hostId=" . $hostid . " and dh.status=1 where d.typeId=0";
	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
		// output data of each row
		while($row = $result->fetch_assoc()) {
			WriteHistory($row["id"], $row["type"], $row["name"], $row["state"], $row["flavor"], $row["amplitude"], $row["icon"], $row["objid"], $row["value"], $row["device_hostid"], $row["deviceid"], $row["hostId"], $conn);
		}
	} else {
		echo "0 results";
	}
}


// Print object
function WriteHistory($id, $objType, $objName, $state, $objFalvor, $amplitude, $icon, $objId, $value, $device_hostid, $deviceid, $hostid, $conn) {
	
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
	CheckAndCreateUpdateHistory($conn, $deviceid, $stateValue, $hostid, $device_hostid);
}

// Hien thi thong tin vao
function CheckAndCreateUpdateHistory($conn, $objId, $statusValue, $hostid, $device_hostId) {
	$deviceId = $objId;
	$sms_groupId = 1; // Warning group
	// Update device_host
	$sql = "UPDATE device_host SET state=" . $statusValue . ", updatedate=SYSDATE() WHERE id=" . $device_hostId;
	if ($conn->query($sql) === TRUE){
		echo "device_host: Record updated successfully" . PHP_EOL ;
	}
	else
	    echo "device_host: Error updating record: " . $conn->error . PHP_EOL;

	// Create history
	// Start ON
	if($statusValue == '1'){
		// echo 'statusValue = 1';

		$sql = "SELECT * FROM history WHERE hostid=$hostid AND deviceid='". $objId . "' AND startdate is NOT NULL and enddate is NULL ORDER BY id DESC LIMIT 1";
		$result = $conn->query($sql);
		if ($result->num_rows <= 0) {
			//echo '$result->num_rows <= 0';
			// Create new
			$sql = "INSERT INTO history(hostid,deviceid,value,startdate,createdate) VALUES($hostid,$objId, '$statusValue', SYSDATE(),SYSDATE())";
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
		$sql = "SELECT * FROM history WHERE hostid=$hostid AND deviceid='$objId' AND startdate is NOT NULL and enddate is NULL ORDER BY id DESC LIMIT 1";
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
			 // output data of each row
			 while($row = $result->fetch_assoc()) {
				$id = $row["id"];
				$sql = "UPDATE history SET value='$statusValue', enddate=SYSDATE(), updatedate=SYSDATE() WHERE id=$id";

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
		$sql = "SELECT h.id, h.startdate, h.enddate, h.value, h.value as state, d.name, d.id as deviceid, d.objid FROM history h join device d on h.deviceid = d.id where h.hostid=" . $_SESSION['hostid'] . " ORDER BY h.id DESC, h.startdate DESC";
	}else{
		$sql = "SELECT h.id, h.startdate, h.enddate, h.value, h.value as state, d.name, d.id as deviceid, d.objid FROM history h join device d on h.deviceid = d.id where h.hostid=" . $_SESSION['hostid'] . " ORDER BY h.id DESC, h.startdate DESC LIMIT " . $count;
	}

	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
	    // output data of each row
	    while($row = $result->fetch_assoc()) {
	        PrintLine($row["id"], $row["name"], $row["state"], $row["startdate"], $row["enddate"]);
	    }
	} else {
	    echo "0 row";
	}
}

// Print object
function PrintLine($Id, $objName, $state, $startdate, $enddate) {
	$statuName = 'OFF';
	if($state == "1"){
		$statuName = 'ON';
	}
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
	</tr>";
}


// Print object: Export page
function PrintLine_ExportPage($Id, $objName, $state, $startdate, $enddate, $hostid, $host_name, $note) {
	$statuName = 'OFF';
	if($state == "1"){
		$statuName = 'ON';
	}
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
		<td style='display:none;'>
			$statuName
		</td>
		<td>
			$startdate
		</td>
		<td>
			$enddate
		</td>
		<td>
			
		</td>
		<td>
			$note
		</td>
	</tr>";
}
?>