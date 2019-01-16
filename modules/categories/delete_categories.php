<?php
    if(!isset($_GET['catID'])){
        header("Location:index.php?module=categories&action=manage_categories");
    }else{
        mysqli_query($con,"DELETE FROM categories WHERE cate_id = '".$_GET['catID']."'")
        or die("error at line 1".mysqli_error($con));
        echo "<script type='text/javascript'>";
        echo "alert('แก้ไขข้อมูลสำเร็จ !!!');";
        echo "window.location.href = 'index.php?module=categories&action=manage_categories'";
        echo "</script>";
    }

    mysqli_close($con);
?>