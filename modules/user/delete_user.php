
<?php
        if(isset($_SESSION['valid_login'])){
            if($_SESSION['user_type'] != "0"){
                header("Location:index.php");
            }
        }else{
            echo "<script type='text/javascript'>
            window.location=\"index.php\";
            </script>";
        }
?>

<?php
    if(isset($_GET['us_name']) || isset($_POST['cbkUser'])){
        $link = "&page=".$_GET['page'];
        if(isset($_POST['cbkUser'])){
            $cbkUser_arr = $_POST['cbkUser'];
            foreach($cbkUser_arr as $data_del){
                del_todb($con,$data_del);
            }
        }else{
            del_todb($con,$_GET['us_name']);
        }
        echo "<script type='text/javascript'>
            alert(\"ลบข้อมูลสำเร็จ!!!\");
            window.location='index.php?module=user&action=manage_user".$link."';
            </script>";
    }else{
        echo "<script type='text/javascript'>
            alert(\"ลบข้อมูลสำเร็จ!!!\");
            window.location='index.php?module=user&action=manage_user';
            </script>";
    }

    function del_todb($con,$del_data){
        mysqli_query($con,"DELETE FROM user WHERE us_name='".$del_data."'") or die
        ("error at line 1 : ".mysqli_error($con));
    }

    mysqli_close($con);
?>