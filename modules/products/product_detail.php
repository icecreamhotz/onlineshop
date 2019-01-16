<?php
    if(!isset($_GET['sendVar']) || !isset($_GET['page'])){
        echo "<script type='text/javascript'>
        window.location=\"index.php\";
        </script>";
    }
?>
<?php

    if(isset($_SESSION['valid_login'])){
        $color_text = (isset($_SESSION['valid_login']) && $_SESSION['user_type'] == 0 ? "#00bfa5" : "#26c6da"); 
    }else{
        $color_text = "#ee6e73";
    }

    echo "<div class='left-align' style='padding:25px 25px;'>";
    $get_productId = $_GET['sendVar'];

    $result = mysqli_query($con,"SELECT * FROM products WHERE product_id = '".$get_productId."'") 
            or die ("Error at line 1 : ".mysqli_error($con));

    list($product_id,
        $product_title,
        $product_detail,
        $product_nprice,
        $product_sprice,
        $product_cate,
        $product_pic,
        $product_ship) = mysqli_fetch_row($result);

    $cate_title_query = mysqli_query($con , "SELECT cate_title FROM categories WHERE cate_id = '".$product_cate."'") 
            or die ("Error at line 2 : ".mysqli_erro($con));
    list($cate_title) = mysqli_fetch_row($cate_title_query);
?>

    <?php
        echo "<h3>แสดงรายละเอียดของสินค้า : ".$product_title."</h1>";
        echo "<div class='center-align'><img src='../images/".(empty($product_pic) ? $product_pic = "no_img.jpg" : $product_pic)."' style='width:300px;height:250px;'></div>";
        $link = "&page=".$_GET['page'].(isset($_GET['cateid']) ? "&cateid=".$_GET['cateid'] : "");
    ?>
    <div style='overflow-x:auto;'>
    <table style='margin-top:50px;margin-left:0px;'>
        <tr>
            <th>รายละเอียด</th>
            <th>ราคาปกติ</th>
            <th>ราคาพิเศษ</th>
            <th>หมวดหมู่</th>
            <th>การขนส่ง</th>
        </tr>
        <tr>
    <?php

        echo "<td><p>".$product_detail."</p></td>";
        echo "<td><p style='color:red;'><strike>".$product_nprice."</strike> บาท</p></td>";
        echo "<td><p style='font-weight:bold;'>".$product_sprice." บาท</p></td>";
        echo "<td><p>".$cate_title."</p></td>";
        echo "<td><p>".($product_ship==1 ? "ส่งภายในประเทศ" : "ส่งจากต่างประเทศ")."</p></td>";
    ?>
        </tr>
    </table>
    </div>  
        <div class="row center-align">
                <?php
                    if(isset($_SESSION['valid_login'])){
                        if($_SESSION['user_type'] == 0){
                            echo "<div class='row center-align'>";
                                echo "<a href='index.php?module=products&action=edit_product_form&product=".$product_id.$link."' class='waves-effect waves-light btn' style='margin-right:20px;margin-top:20px;background-color:#00c853;'>แก้ไขสินค้า</a>";
                                echo "<a href='index.php?module=products&action=delete_product&product=".$product_id."&imgname=".$product_pic.$link."' class='waves-effect waves-light btn' style='margin-top:20px;background-color:#e53935;' onclick='return confirm(\"คุณต้องการลบหรือไม่ ?\");'>ลบสินค้า</a>";
                            echo "</div>";
                        }
                    }
                ?>
                <div style="float: none; margin: 0 auto;">
                    <a href="index.php?module=products&action=<?php echo (!isset($_SESSION['valid_login']) || $_SESSION['user_type'] == 1 ? "select_product" : "manage_product").$link;?>" class="waves-effect waves-light btn" style='margin-top:<?php echo (!isset($_SESSION['valid_login']) || $_SESSION['user_type'] == 1 ? "20" : "10");?>px;background-color:<?php echo $color_text;?>'><?php echo (!isset($_SESSION['valid_login']) || $_SESSION['user_type'] == 1 ? "เลือกชมสินค้า" : "จัดการข้อมูลสินค้า");?></a>
                </div>
        </div>
    </div>
<?php   
    mysqli_free_result($result);
    mysqli_free_result($cate_title_query);
    mysqli_close($con);
?>

