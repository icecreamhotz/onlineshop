<?php
    if(!isset($_POST['submit'])){
        header("Location:index.php?module=categories&action=manage_categories");
    }else{
        $cate_ID = $_POST['txt_cateID'];
        $new_title = $_POST['txt_cateTitle'];
        mysqli_query($con,"UPDATE categories SET cate_title ='".$new_title."' WHERE cate_id ='".$cate_ID."'");
        echo "<script type='text/javascript'>";
        echo "alert('แก้ไขข้อมูลสำเร็จ !!!');";
        echo "window.location.href = 'index.php?module=categories&action=manage_categories'";
        echo "</script>";
    }

    mysqli_close($con);
?>