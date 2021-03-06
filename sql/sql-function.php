<?php 

define("serverName", "localhost");
define("userName", "root");
define("password", "");
define("dbName", "dieukhien");
define("TABLE", " device_host "); // need space between 'device'
define("tenBang", " DieuKhien ");

function ConnectToSql() {
	$conn = mysqli_connect(serverName, userName, password);
	if (!$conn)
	    die("Connection failed: " . mysqli_connect_error()) . PHP_EOL;
	else;
		// echo "Connection to mysql success !" . PHP_EOL;
	mysqli_set_charset($conn, 'UTF8');
	return $conn;
}

function CloseSql($conn) {
	mysqli_close($conn);
}

// Create connection to database 'home'
function ConnectDatabse() {
	$conn = mysqli_connect(serverName, userName, password, dbName);
	// Check connection
	if (!$conn)
	    die("Connection failed: " . mysqli_connect_error());
	else;
		// echo "Connection database success !\n";

	mysqli_set_charset($conn, 'UTF8');
	return $conn;
}

// Disconnect to database
function CloseDatabase($conn) {
	mysqli_close($conn);
}

// function create a table if not exist

function CreateTable($conn, $table) {

	$tableName = $table;

	$sql = "CREATE TABLE IF NOT EXISTS $tableName (
		id INT(32) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
		type VARCHAR(30) NOT NULL DEFAULT 'obj-slider',
		name VARCHAR(50) NOT NULL,
		state BOOLEAN NOT NULL DEFAULT 0,
		flavor VARCHAR(20) DEFAULT NULL,
		amplitude INT(6) DEFAULT 0,
		icon VARCHAR(15) DEFAULT 'fa-wrench'
	)";
	if (mysqli_query($conn, $sql)) {
	    echo "Table 'device' created successfully\n";
	} else {
	    echo "Error creating table: " . mysqli_error($conn);
	}
}

function TaoBang($conn, $table) {

	$tableName = $table;

	$sql = "CREATE TABLE IF NOT EXISTS $tableName (
		id INT(32) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
		donVi VARCHAR(50) NOT NULL DEFAULT 'HDG',
		tenTram VARCHAR(50) NOT NULL,
		tenCanhBao VARCHAR(50) NOT NULL,
		trangThai BOOLEAN NOT NULL DEFAULT 0,
		ngayBD DATE,
		gioBD TIME,
		ngayKT DATE,
		gioKT TIME
	)";
	if (mysqli_query($conn, $sql)) {
	    echo "Table 'DieuKhien' created successfully\n";
	} else {
	    echo "Error creating table: " . mysqli_error($conn);
	}
}

// function insert object to table
function InsertObject($conn, $objType, $objName, $state, $objFalvor, $amplitude, $icon="fa-wrench") {
	
	$sql = "INSERT INTO " . TABLE . " (type, name, state, flavor, amplitude, icon)
	VALUES ('$objType', '$objName', '$state', '$objFalvor', '$amplitude', '$icon')";
	// echo $sql . PHP_EOL;
	if ($conn->query($sql) === TRUE)
	    echo "Create a new object successfully" . PHP_EOL;
	else
	    echo "Error: " . $sql . " : " . $conn->error . PHP_EOL;
}

// them dong vao bang DieuKhien
function themDong($conn, $donVi, $tenTram, $tenCanhBao, $trangThai, $ngayBD, $gioBD,$ngayKT, $gioKT) {
	
	$sql = "INSERT INTO " . tenBangggg . " (donVi, tenTram, tenCanhBao, trangThai, ngayBD, gioBD, ngayKT, gioKT)
	VALUES ('$donVi', '$tenTram', '$tenCanhBao', '$trangThai', '$ngayBD', '$gioBD', '$ngayKT', '$gioKT')";
	// echo $sql . PHP_EOL;
	if ($conn->query($sql) === TRUE)
	    echo "Create a new object successfully" . PHP_EOL;
	else
	    echo "Error: " . $sql . " : " . $conn->error . PHP_EOL;
}
// Delete object 
// ex : DeleteObject($conn, "objName-light");
function DeleteObject($conn, $objName) {

	$sql = "DELETE FROM " . TABLE . " WHERE name='$objName' ";
	// echo $sql . PHP_EOL;
	if ($conn->query($sql) === TRUE)
	    echo "Record deleted successfully" . PHP_EOL;
	else
	    echo "Error deleting record: " . $conn->error . PHP_EOL;
}

// Update object
function UpdateObject($conn, $objName, $propChange, $device_hostid) {
	$sql = "UPDATE " . TABLE . " SET $propChange WHERE id=$device_hostid ";

	echo $sql . PHP_EOL;
	if ($conn->query($sql) === TRUE){
		echo "Record updated successfully" . PHP_EOL ;
	}
	else
	    echo "Error updating record: " . $conn->error . PHP_EOL;
}

// Update value - dien
function UpdateValueByObjId($conn, $objId, $value, $device_hostid) {

	$sql = "UPDATE " . TABLE . " SET value= $value WHERE id=$device_hostid ";
	echo $sql . PHP_EOL;
	if ($conn->query($sql) === TRUE)
	    echo "Record updated successfully" . PHP_EOL ;
	else
	    echo "Error updating record: " . $conn->error . PHP_EOL;
}

// Update value mute
function UpdateMuteByObjId($conn, $objId, $objtype,$value, $device_hostid) {

	$sql = "UPDATE " . TABLE . " SET value= $value WHERE id='$device_hostid'";
	echo $sql . PHP_EOL;
	if ($conn->query($sql) === TRUE)
	    echo "Record updated successfully" . PHP_EOL ;
	else
	    echo "Error updating record: " . $conn->error . PHP_EOL;
}

// Update range value
function UpdateRangeValue($conn, $Id, $value, $device_hostid) {

	$sql = "UPDATE " . TABLE . " SET amplitude= $value WHERE id=$device_hostid";
	echo $sql . PHP_EOL;
	if ($conn->query($sql) === TRUE)
	    echo "Range Dien may no updated successfully" . PHP_EOL ;
	else
	    echo "Error updating Range Dien may no: " . $conn->error . PHP_EOL;
}

?>
