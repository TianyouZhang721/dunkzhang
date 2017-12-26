<?php 

header("Content-Type:application/json");
require("../../controller/user.controller.php");
echo json_encode(isLogin()); 
?>