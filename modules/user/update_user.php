<?php
    if(isset($_POST['submit'])){
        if(isset($_POST['us_type'])){
            $us_type = $_POST['us_type'];
        }else{
            $us_type = 1;
        }

        $link = "&page=".$_GET['page'];

        mysqli_query($con,"UPDATE user SET 
        us_pswd = '".$_POST['txt_usPswd']."',
        us_type = '".$us_type."'
        WHERE us_name = '".$_POST['txt_usName']."'")
        or die ("error at line 1 : ".mysqli_error($con));
        echo "<script type='text/javascript'>";
        echo "alert(\"แก้ไขข้อมูลเรียบร้อย!!!\");";
        if($_SESSION['user_type'] == 1){
            echo "window.location.href = 'index.php?module=user&action=edit_profile_form".$link."';";
        }else{
            echo "window.location.href = 'index.php?module=user&action=manage_user".$link."';";
        }
            echo "</script>";
    }else{
        header("Location:index.php?module=user&action=manage_user");
    }
    mysqli_close($con);
?>