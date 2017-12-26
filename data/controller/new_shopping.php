<?php 
	require("../../init.php");
	function getNewShopping(){
		global $conn;
		@$time = $_REQUEST["time"];
		$sql = "SELECT * FROM publish_time";
		if($time==""){
			$time="";
		}else if($time!="undefined"){
			$sql .= " WHERE publish_time='$time'";
		}
		$result = mysqli_query($conn,$sql);
		$product = mysqli_fetch_all($result,1);
		echo json_encode($product);
	}

 ?>