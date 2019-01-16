<?php
    if(!(empty($_POST['txt_usName']) && empty($_POST['txt_usPswd']))){
        $txt_usName = $_POST['txt_usName'];
        $txt_usPswd = $_POST['txt_usPswd'];

        $rs = mysqli_query($con,"SELECT * FROM user WHERE us_name='".$txt_usName."' AND us_pswd='".$txt_usPswd."'")
        or die("error = ".mysqli_error($con));

        list($us_name,$us_pwd,$us_type) = mysqli_fetch_row($rs);

        if($txt_usName == $us_name && $txt_usPswd == $us_pwd){
            $_SESSION['valid_login'] = $us_name;
            $_SESSION['user_type'] = $us_type;
            $status = "คุณ ".$us_name;
            echo "<script type='text/javascript'>
            alert(\"ยินดีต้อนรับ ".$status."!!!\");
            window.location.href='index.php';
            </script>";
        }else{
            echo "<script type='text/javascript'>
            alert(\"ไม่พบข้อมูลในระบบ!!!\");
            window.location.href='index.php?module=user&action=loginandregister';
            </script>";
        }
    }
    mysqli_free_result($rs);
    mysqli_close($con);
?>