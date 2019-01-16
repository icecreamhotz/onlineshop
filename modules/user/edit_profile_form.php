
    <?php
        if(isset($_SESSION['valid_login'])){
            if($_SESSION['user_type'] != "1"){
                echo "<script type='text/javascript'>
            window.location=\"index.php\";
            </script>";
            }
        }else{
            echo "<script type='text/javascript'>
            window.location=\"index.php\";
            </script>";
        }
    ?>
<?php
    if(!isset($_SESSION['valid_login'])){
        header("Location:index.php");
    }else{
        $result = mysqli_query($con,"SELECT * FROM user WHERE us_name='".$_SESSION['valid_login']."'")
        or die("error at line 1".mysqli_error($con));

        list($us_name,$us_pswd,$us_type) = mysqli_fetch_row($result);
    }
?>
<div class='center-align' style='padding:25px 0px;'>
        <div class="row">
            <h4 style='color:#26c6da;'>ฟอร์มแก้ไขข้อมูลผู้ใช้งาน</h4>
            <div class="col s6 offset-s3 valign">
                <div class="card">
                    <div class="card-image">
                        <img src="../images/no_img.jpg">
                    </div>
                    <form method="post" action="index.php?module=user&action=update_user">
                        <input type="hidden" name="us_type" value="<?php echo $us_type;?>">
                        <div class="card-content center-align grey lighten-3">
                            <span class="card-title" style="color:#26c6da;">แก้ไขข้อมูลผู้ใช้</span>
                            <div class="row">
                                <div class="input-field col s12 editprofile-field">
                                    <i class="material-icons prefix prefix3">face</i>
                                    <input type="hidden" name="txt_usName" value="<?php echo $us_name;?>">
                                    <input type="text" name="ip_txtName" class="validate" data-length="10" maxlength="10" 
                                    value="<?php echo $us_name;?>" disabled>
                                    <label for="username">ชื่อผู้ใช้งาน</label>
                                    <div style="position:absolute; left:0; right:0; top:0; bottom:0; cursor: pointer;" onclick="Materialize.toast('คุณไม่สามารถแก้ไขชื่อผู้ใช้ได้!!!', 1000)"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12 editprofile-field">
                                    <i class="material-icons prefix prefixprofile">https</i>
                                    <input type="password" name="txt_usPswd" class="validate" data-length="10" maxlength="10"  value="<?php echo $us_pswd;?>" required>
                                    <label for="password">รหัสผ่าน</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="center-align blue-text">
                                    <?php echo "สถานะของคุณ : ".($us_type == 0 ? "" : "ผู้ใช้งานระบบ")?>;
                                </div>
                            </div>
                            <div class="row center-align">
                                <input type="submit" name="submit" value="แก้ไขข้อมูล" class="btn waves-effect waves-cyan" style="background-color:#26c6da;">
                                <a href='index.php?module=user&action=manage_user' class="btn waves-effect waves-cyan" style="background-color:#26c6da;">ยกเลิก</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php
    mysqli_free_result($result);
    mysqli_close($con);
?>