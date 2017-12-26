<?php 
	require_once("../../init.php");
	function addCart(){
		global $conn;
		session_start();
		@$uid = $_SESSION["uid"];
		@$product_id = $_REQUEST["sid"];
		@$count = $_REQUEST["count"];
		@$size = $_REQUEST["size"];
		@$color = $_REQUEST["color"];
		if($uid){
			$sql = "SELECT * FROM shoe_cart WHERE user_id=$uid AND product_id=$product_id AND size='$size' AND color='$color'";
			$result = mysqli_query($conn,$sql);
			if(count(mysqli_fetch_all($result,1))){
				$sql = "UPDATE shoe_cart SET count = count+$count WHERE user_id=$uid AND product_id=$product_id";
			}else{
				$sql = "INSERT INTO shoe_cart(user_id,product_id,count,size,color,is_checked) VALUES($uid,$product_id,$count,'$size','$color',0)";
			}
			$result = mysqli_query($conn,$sql);
			$row = mysqli_affected_rows($conn);
			if($row>0){
				echo '{"code":1,"msg":"添加购物车成功"}';
			}

		}
	}

	function getCart(){
		global $conn;
		$output = [];
		session_start();
		$uid = $_SESSION["uid"];
		if($uid){
			$sql = "SELECT iid,product_id,title,price,count,(SELECT sm FROM product_pic WHERE fid=product_id LIMIT 1) as sm,is_checked FROM shoe_cart INNER JOIN shopping_products ON product_id=sid WHERE user_id=$uid";
			
			$result = mysqli_query($conn,$sql);
			$output["data"] = mysqli_fetch_all($result,1);
			$sql = "SELECT count(*) as c FROM shoe_cart WHERE is_checked=1 AND user_id=$uid";
			$result = mysqli_query($conn,$sql);
			$row = mysqli_fetch_all($result,1);
			$output["count"] = $row;
			$sql="SELECT iid,color,size from shoe_cart";
			$result  = mysqli_query($conn,$sql);
			$color = mysqli_fetch_all($result,1);
			$output["colors"] = $color;
			// array_push($output["data"],$color)
			echo json_encode($output);

		}else{
			echo json_encode([]);
		}
	}


	function selectAll(){
		global $conn;
		@$chkAll=$_REQUEST["chkAll"];
		session_start();
		@$uid=$_SESSION["uid"];
		$sql="update shoe_cart set is_checked=$chkAll where user_id=$uid";
		mysqli_query($conn,$sql);

	}

	function selectOne(){
		global $conn;
		@$chkOne=$_REQUEST["chkOne"];
		@$iid=$_REQUEST["iid"];
		$sql="update shoe_cart set is_checked=$chkOne where iid=$iid";
		mysqli_query($conn,$sql);
	}


	function updateCart(){
		global $conn;
		@$iid=$_REQUEST["iid"];
		@$count=$_REQUEST["count"];
		if($count==0)
			$sql="delete from shoe_cart where iid=$iid";
		else
			$sql="update shoe_cart set count=$count where iid=$iid";
		mysqli_query($conn,$sql);
	}


	function getCheckCount(){
		global $conn;
		@$uid = $_REQUEST["uid"];
		if($uid){
			$sql = "SELECT count(*) as c FROM shoe_cart WHERE is_checked=1 AND user_id=$uid";
			$result = mysqli_query($conn,$sql);
			$row = mysqli_fetch_all($result,1);
			echo json_encode($row);
		}
	}

	function getCount(){
	    global $conn;
	    session_start();
	    @$uid = $_SESSION["uid"];
	    if($uid){
	        $sql = "SELECT count(*) as c FROM shoe_cart WHERE user_id=$uid";
	        $result = mysqli_query($conn,$sql);

	        echo json_encode(mysqli_fetch_all($result,1));
	    }
	}
 ?>