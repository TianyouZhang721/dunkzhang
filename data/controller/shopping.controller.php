<?php 
	require_once("../../init.php");
	function getShoppingBasketIndex(){
    		global $conn;
    		$style = $_REQUEST["style"];
    		$sql = "SELECT * FROM shopping_products WHERE style LIKE '%$style%' LIMIT 0,6";
    		$result = mysqli_query($conn,$sql);
    		$products = mysqli_fetch_all($result,1);
    		echo json_encode($products);
    	}
	function getShoppingBasket(){
		global $conn;
		$style = $_REQUEST["style"];
		$sql = "SELECT * FROM shopping_products WHERE style LIKE '%$style%' LIMIT 0,8";
		$result = mysqli_query($conn,$sql);
		$products = mysqli_fetch_all($result,1);
		echo json_encode($products);
	}

	function getshoppingAll(){
    	global $conn;
    	@$kw = $_REQUEST["kw"];
    	$sql = "SELECT * FROM shopping_products";
    	if($kw==""){
    	    $kw=="";
        }else if($kw!="undefined"){
            $sql .= " WHERE style LIKE '%$kw%'";
        }
//        $sql .= " LIMIT 0,25";
        $result = mysqli_query($conn,$sql);
        $products = mysqli_fetch_all($result,1);
        echo json_encode($products);
    }

	
 ?>