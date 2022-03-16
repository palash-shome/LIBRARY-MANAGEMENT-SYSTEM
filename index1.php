<?php
include "connection.php";
include "config.php";

if (isset($_GET['rfid'])) {
	
	$rfid = $_GET['rfid'];
	echo $rfid;
	
$sql= "SELECT * FROM book WHERE rfid='$rfid'";
if($link->query($sql)==TRUE)	
{
	$query = "insert into rfid (tag) values('$rfid')";
	if($connection->query($query))
	{
		echo "inserted";
	}
	else{
		echo "Not scanned";
	}
}
	
elseif($link->query($sql)==FALSE){
	echo "Book not Found";

}
else{
	echo"error";
}

}
?>


