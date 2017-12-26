<?php 
	require_once("../../init.php");
	function register(){
		global $conn;
		@$uname = $_REQUEST["uname"];
		@$upwd = $_REQUEST["upwd"];

		if($uname&&$upwd){
			$sql = "INSERT INTO shoe_user (uid,uname,upwd) VALUES (null,'$uname',md5('$upwd'))";
			mysqli_query($conn,$sql);
		}
	}
	// register();
	function checkName(){
		global $conn;
		@$uname = $_REQUEST["uname"];
		$sql = "SELECT * FROM shoe_user WHERE uname='$uname'";
		$result = mysqli_query($conn,$sql);
		$users = mysqli_fetch_all($result,1);
		if(count($users)!=0){
			return false;
		}else{
			return true;
		}
	}
	function login(){
		session_start();
		global $conn;
		@$uname = $_REQUEST["uname"];
		@$upwd = $_REQUEST["upwd"];
		@$yzm = $_REQUEST["yzm"];

		$uPattern = '/^[a-zA-Z0-9_]{3,12}$/';
		$pPattern = '/^[a-zA-Z0-9_]{3,12}$/';
		//验证:验证码格式的正则表达式
		$yPattern = '/^[a-zA-Z]{4}$/';

		if(!preg_match($uPattern,$uname)){
		  echo '{"code":-3,"msg":"用户名格式不正确"}';
		  exit;
		}
		if(!preg_match($pPattern,$upwd)){
		  echo '{"code":-3,"msg":"密码格式不正确"}';
		  exit;
		}
		if(!preg_match($yPattern,$yzm)){
		  echo '{"code":-3,"msg":"验证码格式不正确"}';
		  exit;
		}
		// 验证码是否正确
		$code = $_SESSION["code"];
		if($code!=$yzm){
		  echo '{"code":-3,"msg":"验证码不正确"}';
		  exit;
		}

		$sql = "SELECT * FROM shoe_user WHERE uname='$uname' AND upwd=md5('$upwd') AND expire='0'" ;
		$result = mysqli_query($conn,$sql);
		$user = mysqli_fetch_all($result,1);
		if(count($user)!=0){
			$_SESSION['uid'] = $user[0]["uid"];
			echo '{"code":1,"msg":"登录成功"}';
		}else{
			echo '{"code":-1,"msg":"登录失败"}';
		}
	}

	function isLogin(){
		global $conn;
		session_start();
		@$uid = $_SESSION["uid"];
		if($uid){
			$sql = "SELECT uname FROM shoe_user WHERE uid=$uid";
			$result = mysqli_query($conn,$sql);
			$user = mysqli_fetch_all($result,1);
			return ["ok"=>1,"uname"=>$user[0]["uname"]];
		}else{
			return ["ok"=>0];
		}
	}

	function logout(){
		session_start();
		$_SESSION["uid"]=null;
	}



 ?>