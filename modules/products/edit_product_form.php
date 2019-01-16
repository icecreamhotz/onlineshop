<?php 
     if(isset($_SESSION['valid_login'])){
        if($_SESSION['user_type'] == 0){
            if(!isset($_GET['product']) || empty($_GET['product']) || !isset($_GET['page'])){
                echo "<script type='text/javascript'>
                window.location=\"index.php?module=products&action=manage_product\";
                </script>";
            }else{
                $result = mysqli_query($con , "SELECT * FROM products WHERE product_id = '".$_GET['product']."'") or die ("Error on query 1 : ".mysqli_error($con));
            }
        }else{
            echo "<script type='text/javascript'>
        window.location=\"index.php\";
        </script>";
        }
    }else{
        echo "<script type='text/javascript'>
        window.location=\"index.php\";
        </script>";
    }
    list($product_id,
    $product_title,
    $product_detail,    
    $product_nprice,
    $product_sprice,
    $product_cate,
    $product_pic,
    $product_ship) = mysqli_fetch_row($result);

    $ct = mysqli_query($con,"SELECT * FROM categories");

    $link = "&page=".$_GET['page'].(isset($_GET['cateid']) ? "&cateid=".$_GET['cateid'] : "");
?>
    <div class='left-align' style='padding:25px 25px;'>
        <div class="row">
            <form method = "post" action = "index.php?module=products&action=update_product<?php echo $link;?>" enctype = "multipart/form-data" class="col s12">
                <div class="row">
                    <input type = "hidden" name = "product_id" value = "<?php echo $product_id;?>">
                    <div class="center-align">
                    <h2 style='color:#00bfa5;'> ฟอร์มแก้ไขข้อมูลสินค้า </h2>
                        <?php echo (empty($product_pic) ? "<img src='../images/no_img.jpg'>" : "<img src='../images/".$product_pic."'>")?>
                    </div>
                    <div class="input-field col s12">
                        <input id="productname" type = "text"  name = "txt_productName" value = "<?php echo $product_title;?>" class="validate">
                        <label for="productname">ชื่อสินค้า</label>
                    </div>
                </div>  
                <div class="row">
                    <div class="input-field col s12">
                        <textarea id = "productdetail" class="materialize-textarea" name = "txt_productDetail"><?php echo $product_detail;?></textarea>
                        <label for="productdetail">รายละเอียด</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input id="txt_priceCommon" type = "number"  name = "txt_priceCommon"  class="validate" value = "<?php echo $product_nprice;?>">
                        <label for="txt_priceCommon">ราคาปกติ</label>
                    </div>
                </div>  
                <div class="row">
                    <div class="input-field col s12">
                        <input id="txt_priceSpecial" type = "number"  name = "txt_priceSpecial"  class="validate" value = "<?php echo $product_sprice;?>">
                        <label for="txt_priceSpecial">ราคาพิเศษ</label>
                    </div>
                </div>  
                <div class="row">
                    <div class="input-field col s12">
                        <select name="product_cate">
                            <?php
                                while(list($cate_id,$cate_title) = mysqli_fetch_row($ct)){
                                    echo "<option value = '".$cate_id."'",($cate_id == $product_cate ? "selected" : ""),">",$cate_title,"</option>";   
                                }
                            ?>
                        </select>
                        <label>หมวดหมู่</label>
                    </div>
                </div>  

                <input id="test2" name = "rd_country"  type="checkbox"  value="1" <?php echo ($product_ship == 1 ? "checked" : "");?>>
                <label for="test2">ส่งภายในประเทศ</label>
                </label>
                
                <div class="row" style="margin:30px 0;"> 
                    <div class="file-field input-field">
                        <div class="btn">
                            <span>เลือกไฟล์</span>
                            <input type="file" name = "product_pic">
                        </div>
                        <div class="file-path-wrapper">
                            <input class="file-path validate" type="text">
                        </div>
                    </div>
                </div>
    
                <div class="row">
                    <div class="center-align">
                        <input type = "submit" name = "submit" value ="แก้สินค้า" class="btn waves-effect waves-teal" onclick="return confirm('คุณต้องการแก้ไขหรือไม่ ?');">
                        <a href='index.php?module=products&action=manage_product<?php echo $link;?>' class="btn waves-effect waves-teal">ยกเลิก</a>  
                    </div>
                </div>
            </form>
        </div>
    </div>
<?php
    mysqli_free_result($result);
    mysqli_close($con);
?>
