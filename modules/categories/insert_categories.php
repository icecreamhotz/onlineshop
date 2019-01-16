<?php
    if(!isset($_POST['submit'])){
        header("Location:index.php?module=categories&action=manage_categories");
    }else{
        $insert = "INSERT INTO categories (cate_title) VALUES ('".$_POST['txt_cateName']."')";

        mysqli_query($con,$insert) or die ("Error at query 1 : ".mysqli_error($con));

        mysqli_close($con);
        
        echo "<script type='text/javascript'>";
        echo "alert('เพิ่มข้อมูลสำเร็จ !!!');";
        echo "window.location.href = 'index.php?module=categories&action=manage_categories'";
        echo "</script>";
    }
?>