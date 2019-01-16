<?php
    if(!isset($_POST['submit'])){
        echo "<script type='text/javascript'>
            window.location=\"index.php?module=user&action=loginandregister\";
            </script>";
    }else{
        $result = mysqli_query($con,"SELECT us_name FROM user WHERE us_name='".trim($_POST['txt_usName'])."'") or die ("error line 1 : ".mysqli_error($con));
        $num = mysqli_num_rows($result);
        if($num > 0){
            echo "<script type='text/javascript'>
            alert(\"ขออภัย ชื่อผู้ใช้นี้มีแล้ว!!!\");
            window.location=\"index.php?module=user&action=loginandregister#register\";
            </script>";
        }else{
            mysqli_query($con,"INSERT INTO user(us_name,us_pswd) VALUE
            ('".trim($_POST['txt_usName'])."',
            '".$_POST['txt_usPswd']."')");
            echo "<script type='text/javascript'>
            alert(\"สมัครสมาชิกสำเร็จ!!!\");
            window.location.href = 'index.php?module=user&action=loginandregister';
            </script>";
        }

    }
    mysqli_close($con);
?>