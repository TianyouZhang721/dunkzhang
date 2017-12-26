<?php 
	require_once("../../init.php");
//	轮播图
	function getCarousel(){
		global $conn;
		$sql = "SELECT * FROM banner_carousel";
		$result = mysqli_query($conn,$sql);
		echo json_encode(mysqli_fetch_all($result,1));
	}

	function getShopping(){
	    global $conn;
	    @$style = $_REQUEST["style"];
	    if($style){
	    	$sql = "SELECT * FROM shopping_products WHERE style LIKE '%$style%' LIMIT 0,6";
	    	$result = mysqli_query($conn,$sql);
	    	$products = mysqli_fetch_all($result,1);
	    	echo json_encode($products);
	    }
	}
	 // getShopping();
	function getNews(){
		global $conn;
		@$style = $_REQUEST["style"];
		if($style){
			$sql = "SELECT * FROM news WHERE style LIKE '%$style%' LIMIT 0,8";
			$result = mysqli_query($conn,$sql);
			$products = mysqli_fetch_all($result,1);
			echo json_encode($products);
		}
	}

	function getDetails(){
		global $conn;
		@$sid = $_REQUEST["sid"];
		$output = [];
		if($sid){
			$sql = "SELECT sid,img,title,label,price,size,color,detail FROM shopping_products WHERE sid=$sid";

			$result = mysqli_query($conn,$sql);
			$familys = mysqli_fetch_all($result,1);

			$output["familys"] = $familys;
			$sql = "SELECT sm FROM product_pic WHERE fid=$sid";
			$result = mysqli_query($conn,$sql);
			$imgs = mysqli_fetch_all($result,1);
			$output["imgs"] = $imgs;
			echo json_encode($output);
		}
	}


	function searchHelper(){
		global $conn;
		@$kw=$_REQUEST["term"];//?term=mac 256g
		$sql="select * from shopping_products ";
		if($kw){
			$kws=explode(" ",$kw);
			for($i=0;$i<count($kws);$i++){
				$kws[$i]=" title like '%".$kws[$i]."%' ";
			}
			$sql.=" where ".implode(" and ",$kws);
		}
		$sql.=" limit 10";
		$result=mysqli_query($conn,$sql);
		echo json_encode(mysqli_fetch_all($result,1));
	}
	
 ?>