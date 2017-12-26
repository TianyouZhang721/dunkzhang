<?php 
	require_once("../../init.php");
	function addComment(){
		global $conn;
		session_start();
		@$uid = $_SESSION["uid"];
		@$comment = $_REQUEST['comment'];
		@$reply = $_REQUEST["reply"];
		@$news_id = $_REQUEST["news_id"];
		$time=intval(time());
		$sql = "SELECT uname FROM shoe_user WHERE uid=$uid";
		$result = mysqli_query($conn,$sql);
		$users = mysqli_fetch_row($result);
		$uname = json_encode($users[0]);
		if(!$reply){
			$reply = "";
		}
		if(!$comment){
			$comment = "";
		}
		$sql = "INSERT INTO comments(uname,comment,reply,item_like,liked,timer,news_id) VALUES($uname,'$comment','$reply',0,'0',$time,$news_id)";
		$result = mysqli_query($conn,$sql);
		$row = mysqli_affected_rows($conn);
		if($row>0){
			echo '{"code":1,"msg":"添加评论成功"}';
		}
	}

	// function addHuifu(){
	// 	global $conn;
	// 	session_start();
	// 	@$uid = $_SESSION["uid"];
	// 	@$reply = $_REQUEST["reply"];
	// 	@$news_id = $_REQUEST["news_id"];
	// 	@$timer = $_REQUEST["timer"];
		
	// 	$sql = "SELECT uname FROM shoe_user WHERE uid=$uid";
	// 	$result = mysqli_query($conn,$sql);
	// 	$users = mysqli_fetch_row($result);
	// 	$uname = json_encode($users[0]);
	// 	$sql = "UPDATE comments SET pname=$uname AND reply='$reply' WHERE news_id=$news_id AND timer=$timer";
	// 	$result = mysqli_query($conn,$sql);
	// 	$row = mysqli_affected_rows($conn);
	// 	if($row>0){
	// 		echo '{"code":1,"msg":"添加评论成功"}';
	// 	}
	// }

	function loadComment(){
		global $conn;
		session_start();
		@$uid = $_SESSION['uid'];
		@$news_id = $_REQUEST["news_id"];
		$output = [];
		if($uid){
			$sql = "SELECT uname FROM shoe_user WHERE uid=$uid";
			$result = mysqli_query($conn,$sql);
			$uname = mysqli_fetch_row($result);
			$output["uname"] = $uname;
		}else{
			$output["uname"] = "";
		}
		$sql = "SELECT * FROM comments WHERE news_id=$news_id ORDER BY timer DESC";
		$result = mysqli_query($conn,$sql);
		$comments = mysqli_fetch_all($result,1);
		$output["comments"] = $comments;
		echo json_encode($output);
	}

	function addLike(){
		global $conn;
		@$news_id = $_REQUEST["news_id"];
		@$item_like = $_REQUEST['item_like'];
		@$timer = $_REQUEST["timer"];
		$sql = "SELECT item_like,liked FROM comments WHERE news_id=$news_id AND timer=$timer";
		$result = mysqli_query($conn,$sql);
		$like = mysqli_fetch_all($result,1);
		$count = $like[0]["item_like"]+1;
		$liked = $like[0]["liked"];
		$sql = "UPDATE comments SET item_like = $count";
		if($liked=="1"){
			$sql .= ",liked='0'";
		}else{
			$sql .= ",liked='1'";
		}
		$sql .= "  WHERE news_id=$news_id AND timer=$timer";
		$result = mysqli_query($conn,$sql);
		$row = mysqli_affected_rows($conn);
		if($row>=0){
			echo '{"code":1,"msg":"修改成功"}';
		}else{
			echo '{"code":-1,"msg":"修改失败"}';
		}
	}
 ?>