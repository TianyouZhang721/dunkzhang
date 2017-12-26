<?php 
	require_once("../../init.php");
    function getNewsAll(){
        global $conn;
        $output=[
        		"count"=>0,//总个数
        		"pageSize"=>9,//每页9个
        		"pageCount"=>0,//总页数
        		"pageNo"=>1,//现在第几页
        		"data"=>[]//商品列表
        	];
        @$pno=(int)$_REQUEST["pno"];
        @$style = $_REQUEST["style"];
        if($pno) $output["pageNo"]=$pno;
        $sql = "SELECT * FROM news";
        if($style==""){
        	$style = "";
        }else if($style!="undefined"){
        	$sql .= " WHERE style LIKE '%$style%'";
        }
        $sql .= " ORDER BY view DESC";
        $result = mysqli_query($conn,$sql);
        $news = mysqli_fetch_all($result,1);
        $output["count"]=count($news);
        $output["pageCount"]=
        		ceil($output["count"]/$output["pageSize"]);
        $sql.=" LIMIT ".(($output["pageNo"]-1)*$output["pageSize"]).",".$output["pageSize"];
        $result = mysqli_query($conn,$sql);
	    $output["data"]=mysqli_fetch_all($result,1);


        echo json_encode($output);
    }
	function newAll(){
		global $conn;
		@$hid = $_REQUEST["hid"];
		if($hid){
			$sql = "SELECT * FROM news WHERE hid=$hid";
			$result = mysqli_query($conn,$sql);
			$news = mysqli_fetch_all($result,1);
			echo json_encode($news);
		}
	}

	function getNewFashion(){
		global $conn;
		// $hid = $_REQUEST["hid"];
		$sql = "SELECT * FROM news ORDER BY view DESC LIMIT 0,3";
		$result = mysqli_query($conn,$sql);
		$news = mysqli_fetch_all($result,1);
		echo json_encode($news);
	}
	function getNewFashionAll(){
		global $conn;
		// $hid = $_REQUEST["hid"];
		$sql = "SELECT * FROM news ORDER BY view DESC LIMIT 0,6";
		$result = mysqli_query($conn,$sql);
		$news = mysqli_fetch_all($result,1);
		echo json_encode($news);
	}
	function viewAdd(){
		global $conn;
		@$hid = $_REQUEST["hid"];
		$sql = "SELECT view FROM news WHERE hid=$hid";
		$result = mysqli_query($conn,$sql);
		$view = mysqli_fetch_all($result,1);
		$count = $view[0]["view"]+1;
		$sql = "UPDATE news SET view=$count WHERE hid=$hid";
		$result = mysqli_query($conn,$sql);
		$row = mysqli_affected_rows($conn);
		if($row>=0){
			echo '{"code":1,"msg":"修改成功"}';
		}else{
			echo '{"code":-1,"msg":"修改失败"}';
		}
	}


	// function getNewsByStyle(){
	// 	global $conn;
	// 	$output=[
	// 			"count"=>0,//总个数
	// 			"pageSize"=>9,//每页9个
	// 			"pageCount"=>0,//总页数
	// 			"pageNo"=>1,//现在第几页
	// 			"data"=>[]//商品列表
	// 		];
	// 	$style = $_REQUEST["style"];
	// 	$sql = "SELECT * FROM news WHERE style LIKE '%$style%'";
	// 	$result = mysqli_query($conn,$sql);
	// 	$news = mysqli_fetch_all($result,1);
	// 	$output["count"]=count($news);
	// 	$output["pageCount"]=
	// 			ceil($output["count"]/$output["pageSize"]);
	// 	$sql.=" LIMIT ".(($output["pageNo"]-1)*$output["pageSize"]).",".$output["pageSize"];
	// 	        $result = mysqli_query($conn,$sql);
	// 		    $output["data"]=mysqli_fetch_all($result,1);
	// 	echo json_encode($output);
	// }

	
 ?>