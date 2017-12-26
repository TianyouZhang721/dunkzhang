<?php
    require("../../init.php");
    function searchNews(){
        global $conn;
        $kw = $_REQUEST["kw"];
        $output = [];
        if($kw){
            $sql = "SELECT * FROM news WHERE title LIKE '%$kw%' OR style LIKE '%$kw%'";
            $result = mysqli_query($conn,$sql);
            $news = mysqli_fetch_all($result,1);
            $output["news"] = $news;
            $sql = "SELECT count(*) as c FROM news WHERE title LIKE '%$kw%' OR style LIKE '%$kw%'";
            $result= mysqli_query($conn,$sql);
            $output["count"] = mysqli_fetch_all($result,1);
            echo json_encode($output);
        }
    }

    function searchProducts(){
            global $conn;
            $kw = $_REQUEST["kw"];
            $output = [];
            if($kw){
                $sql = "SELECT * FROM shopping_products WHERE title LIKE '%$kw%' OR style LIKE '%$kw%'";
                $result = mysqli_query($conn,$sql);
                $products = mysqli_fetch_all($result,1);
                $output["products"] = $products;
                $sql = "SELECT count(*) as c FROM shopping_products WHERE title LIKE '%$kw%' OR style LIKE '%$kw%'";
                $result= mysqli_query($conn,$sql);
                            $output["count"] = mysqli_fetch_all($result,1);
                echo json_encode($output);
            }
        }

    function searchEquip(){
                global $conn;
                $kw = $_REQUEST["kw"];
                $output = [];
                if($kw){
                    $sql = "SELECT * FROM shoe_equipment WHERE title LIKE '%$kw%' OR subtitle LIKE '%$kw%'";
                    $result = mysqli_query($conn,$sql);
                    $equip = mysqli_fetch_all($result,1);
                    $output["equip"] = $equip;
                    $sql = "SELECT count(*) as c FROM shoe_equipment WHERE title LIKE '%$kw%' OR subtitle LIKE '%$kw%'";
                    $result= mysqli_query($conn,$sql);
                                $output["count"] = mysqli_fetch_all($result,1);
                    echo json_encode($output);
                }
            }
?>