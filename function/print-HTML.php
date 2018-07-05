<?php 

function PrintObjectDatabase($conn) {

	$sql = "SELECT *  FROM device where type <> 'obj-vao'";
	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
	    // output data of each row
	    while($row = $result->fetch_assoc()) {
	        PrintObject($row["type"], $row["name"], $row["state"], $row["flavor"], $row["amplitude"], $row["icon"], $row["objid"], $row["value"]);
	    }
	} else {
	    echo "0 results";
	}
}

// Print object
function PrintObject($objType, $objName, $state, $objFalvor, $amplitude, $icon, $objId, $value) {

	if($state) {
		$stateButton = "switch-on";
		$stateName = "turn-on";
	}
$buttonUpDown = "";
if($objType == "obj-de-may-no"){
	$buttonUpDown = 'obj-button-up-down-icon';
	$objFalvor = '';
}

	echo '<div class="col-lg-3 col-md-4 col-sm-6 col-xs-6">';
		echo '<div class="object '.$objType . " " .$objFalvor. " " .$stateName.'" id="'. $objId .'">';
			echo '<div class="obj-info">',
	                '<p class="obj-header">'.$objName.'</p>';

	            if( $objType != "obj-button")
	            echo'<p class="obj-counter-percent">', 
	                	//'<i class="fa '.$icon.'"></i>',
	                	//'<b class="counter">'.$amplitude.'</b>',
	                '</p>';
			echo  '</div>';
			
			if($objType == "obj-radiobutton"){
				echo '<div class="obj-timer ignore-onclick">';
				echo '<div class="switch-button '.$stateButton.'"></div>';
				echo '</div>';
			} else {
				echo '<div class="obj-timer '. $buttonUpDown .'">
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
echo '<label for="dien-may-no"><input id="dien-may-no" name="ra_cau_dao" type="radio"' . $selected_dienmayno .' value="0" class="" /> Dien may no</label>';
echo '</div>';

echo '<div class="radio">';
echo '<label for="dien-luoi"><input id="dien-luoi" name="ra_cau_dao" type="radio" ' . $selected_dienluoi .' value="1" /> Dien luoi</label>';
echo '</div>';

echo '</div>';
}

break;

case "obj-................":


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

	$sql = "SELECT *  FROM device where type='obj-vao'";
	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
	    // output data of each row
	    while($row = $result->fetch_assoc()) {
	        PrintVao($row["id"], $row["type"], $row["name"], $row["state"], $row["flavor"], $row["amplitude"], $row["icon"], $row["objid"], $row["value"], $conn);
	    }
	} else {
	    echo "0 results";
	}
}

// Print object
function PrintVao($id, $objType, $objName, $state, $objFalvor, $amplitude, $icon, $objId, $value, $conn) {

	$bg_cl = "background-color-off";
	$stateView = "OFF";
	$stateViewLower = "off";
	$stateValue = "0";

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
	
	if($content[0] == "1") {
		$bg_cl = "background-color-on";
		$stateView = "ON";
		$stateViewLower = "on";
		$stateValue = "1";
	}

	// Check history
	CheckAndCreateUpdateHistory($conn, $id, $stateValue);

	echo '<div class="col-lg-3 col-md-4 col-sm-6 col-xs-6 ' . $bg_cl . '">';
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
function CheckAndCreateUpdateHistory($conn, $objId, $statusValue) {
	// Start ON
	if($statusValue == '1'){
		// echo 'statusValue = 1';

		$sql = "SELECT * FROM history WHERE deviceid='". $objId . "' AND startdate is NOT NULL and enddate is NULL ORDER BY id LIMIT 1";
		$result = $conn->query($sql);
		if ($result->num_rows <= 0) {
			//echo '$result->num_rows <= 0';
			// Create new
			$sql = "INSERT INTO history(deviceid,value,startdate,createdate) VALUES($objId, '$statusValue', SYSDATE(),SYSDATE())";
			if ($conn->query($sql) === TRUE){}
				// echo "Record inserted successfully";
			else
				echo "Error inserting record: " . $conn->error;

		}
	}
	else{
		// echo 'statusValue = 0';
		// = 0
		$sql = "SELECT * FROM history WHERE deviceid='$objId' AND startdate is NOT NULL and enddate is NULL ORDER BY id LIMIT 1";
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
			 // output data of each row
			 while($row = $result->fetch_assoc()) {
				$sql = "UPDATE history SET value='$statusValue', enddate=SYSDATE(), updatedate=SYSDATE() WHERE deviceid=$objId";
				if ($conn->query($sql) === TRUE){}
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
		$sql = "SELECT h.id, h.startdate, h.enddate, h.value, h.value as state, d.name, d.id as deviceid, d.objid FROM history h left join device d on h.deviceid = d.id ORDER BY h.id DESC, h.startdate DESC";
	}else{
		$sql = "SELECT h.id, h.startdate, h.enddate, h.value, h.value as state, d.name, d.id as deviceid, d.objid FROM history h left join device d on h.deviceid = d.id ORDER BY h.id DESC, h.startdate DESC LIMIT " . $count;
	}

	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
	    // output data of each row
	    while($row = $result->fetch_assoc()) {
	        PrintLine($row["id"], $row["type"], $row["name"], $row["state"], $row["flavor"], $row["amplitude"], $row["icon"], $row["deviceid"], $row["objid"], $row["value"], $row["startdate"], $row["enddate"]);
	    }
	} else {
	    echo "0 row";
	}
}

// Print object
function PrintLine($Id, $objType, $objName, $state, $objFalvor, $amplitude, $icon, $deviceid, $objId, $value, $startdate, $enddate) {
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
?>