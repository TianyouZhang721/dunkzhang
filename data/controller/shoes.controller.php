<?php 
	require_once("../../init.php");
	function getShoesAll(){
		global $conn;
		$output=[
				"count"=>0,//总个数
				"pageSize"=>25,//每页9个
				"pageCount"=>0,//总页数
				"pageNo"=>1,//现在第几页
				"data"=>[]//商品列表
			];
		@$pno=(int)$_REQUEST["pno"];
		// @$style = $_REQUEST["style"];
		if($pno) $output["pageNo"]=$pno;
		$sql = "SELECT * FROM shoe_equipment";
//		 if($style==""){
//		 	$style = "";
//		 }else if($style!="undefined"){
//		 	$sql .= " WHERE style LIKE '%$style%'";
//		 }
		$sql .= " ORDER BY view DESC";
		$result = mysqli_query($conn,$sql);
		$products = mysqli_fetch_all($result,1);
		$output["count"] = count($products);
		$output["pageCount"] = ceil($output["count"]/$output["pageSize"]);
		$sql .= " LIMIT ".($output["pageNo"]-1)*$output["pageSize"].",".$output["pageSize"];
		$result = mysqli_query($conn,$sql);
		$output["data"] = mysqli_fetch_all($result,1);
		echo json_encode($output);
	}

	
 ?>