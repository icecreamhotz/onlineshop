<?php
    if(isset($_SESSION['valid_login'])){
        if($_SESSION['user_type'] != 0){
            header("Location:index.php");
        }
    }else{
        echo "<script type='text/javascript'>
        window.location=\"index.php\";
        </script>";
    }
?>
<?php
    $result = mysqli_query($con,"SELECT * FROM categories") or die(mysqli_error($con));
    $linkback = "&page=".$_GET['page'].(isset($_GET['cateid']) ? "&cateid=".$_GET['cateid'] : "");
    $linkbackinsert = "&pageend=".$_GET['pageend'].(isset($_GET['cateid']) ? "&cateid=".$_GET['cateid'] : "");
?>
<div class='left-align' style='padding:25px 25px;'>
        <div class="row">
            <form method = "post" action = "index.php?module=products&action=insert_product<?php echo $linkbackinsert;?>" enctype = "multipart/form-data" class="col s12">
                <div class="row">
                    <input type = "hidden" name = "product_id" value = "<?php echo $product_id;?>">
                    <div class="center-align">
                    <h2> ฟอร์มเพิ่มข้อมูลสินค้า </h2>
                    </div>
                    <div class="input-field col s12">
                        <input id="productname" type = "text"  name = "txt_productName"  class="validate" required>
                        <label for="productname">ชื่อสินค้า</label>
                    </div>
                </div>  
                <div class="row">
                    <div class="input-field col s12">
                        <textarea id = "productdetail" class="materialize-textarea" name = "txt_productDetail" required></textarea>
                        <label for="productdetail">รายละเอียด</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input id="txt_priceCommon" type = "number"  name = "txt_priceCommon"  class="validate" required>
                        <label for="txt_priceCommon">ราคาปกติ</label>
                    </div>
                </div>  
                <div class="row">
                    <div class="input-field col s12">
                        <input id="txt_priceSpecial" type = "number"  name = "txt_priceSpecial"  class="validate" required>
                        <label for="txt_priceSpecial">ราคาพิเศษ</label>
                    </div>
                </div>  
                <div class="row">
                    <div class="input-field col s12">
                        <select name="product_cate">
                            <?php
                                $i = 0;
                                while(list($cate_id,$cate_title) = mysqli_fetch_row($result)){
                                    if($i == 0){
                                        echo "<option value = '".$cate_id."' selected>",$cate_title,"</option>";  
                                    }else{
                                        echo "<option value = '".$cate_id."'>",$cate_title,"</option>";   
                                    }
                                    $i=1;
                                }
                            ?>
                        </select>
                        <label>หมวดหมู่</label>
                    </div>
                </div>  

                <input id="test2" name = "rd_country"  type="checkbox"  value="1">
                <label for="test2">ส่งภายในประเทศ</label>
                </label>
                
                <div class="row" style="margin:30px 0;"> 
                    <div class="file-field input-field">
                        <div class="btn">
                            <span>เลือกไฟล์</span>
                            <input type="file" name = "product_pic" >
                        </div>
                        <div class="file-path-wrapper">
                            <input class="file-path validate" type="text">
                        </div>
                    </div>
                </div>
    
                <div class="row">
                    <div class="center-align">
                        <input type = "submit" name = "submit" value ="เพิ่มสินค้า" class="btn btn-outline-success">
                        <a href='index.php?module=products&action=manage_product<?php echo $linkback;?>' class="btn btn-outline-danger">ยกเลิก</a>  
                    </div>
                </div>
            </form>
        </div>
    </div>
<?php
    mysqli_free_result($result);
    mysqli_close($con);
?>