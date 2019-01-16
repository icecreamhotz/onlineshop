<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
    <?php
        if(isset($_SESSION['valid_login'])){
            $color_text = ($_SESSION['user_type'] == 0 ? "#00bfa5" : "#26c6da"); 
        }else{
            $color_text = "#ee6e73";
        }

        $array_welcome = array("สวัสดีครับผู้ใช้งานระบบทุกท่าน ☺ ","ขอให้สนุกกับการใช้ระบบครับ ^_^","กำลังอยู่ในช่วงทดสอบระบบ :)","ขอบคุณที่ใช้เว็บไซต์ของเราครับ :/","THIS IS CIS ONLINE SHOP :}");
        $random_keys = array_rand($array_welcome,1);
    ?>
    <div class="row" style='height:500px;padding-top:100px;'>
        <div class="col s12 center valign-wrapper">
            <div class="col s12">
                <h2>ยินดีต้อนรับ!</h2>
                <h4 id="textanimate" style='margin-top:10px;line-height:150%;color:white'><?php echo $array_welcome[$random_keys];?></h4>
                <div class="row">
                    <?php
                        if(isset($_SESSION['valid_login'])){
                            echo "<a class='waves-effect waves-light btn' href='index.php?module=user&action=logout' style='margin-top:120px;background-color:$color_text'><i class='material-icons left'>power_settings_new</i>ออกจากระบบ</a>";
                        }else{
                            echo "<a class='waves-effect waves-light btn' href='index.php?module=user&action=loginandregister' style='margin-top:120px;background-color:$color_text'><i class='material-icons left'>account_circle</i>เข้าสู่ระบบ/สมัครสมาชิก</a>";
                        }
                   ?>
                </div>
            </div>
        </div>
    </div>

</body>
</html>