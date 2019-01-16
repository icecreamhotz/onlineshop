<?php

    if(isset($_SESSION['valid_login'])){
        if($_SESSION['user_type'] == 0){
            if(!isset($_GET['catID'])){
                header("Location:index.php?module=categories&action=manage_categories");
            }else{
                $cat_ID = $_GET['catID'];
                $query_cat = mysqli_query($con,"SELECT * FROM categories WHERE cate_id = '".$cat_ID."'") or die ("Error at query 1 : ".mysqli_error($con));
                list($title_id,$title_cate) = mysqli_fetch_row($query_cat);
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
?>
    <div class='left-align' style='padding:25px 25px;'>
        <form method = "post" action = "index.php?module=categories&action=update_categories">
        <input type="hidden" name="txt_cateID" value="<?php echo $title_id; ?>">
        <h2 style='color:#00bfa5;'>ฟอร์มแก้ไขข้อมูลประเภทสินค้า</h2>
        <div class="row">
            <div class="input-field col s12">
                <input id ="cate_title" class="validate" type = "text" name = "txt_cateTitle"  value = "<?php echo $title_cate;?>" required>
                <label for="cate_title">ประเภทสินค้า</label>
            </div>
        </div>
            <div class="row center-align">
                <input type = "submit" name = "submit" value ="แก้ไขประเภทสินค้า" class="btn waves-effect waves-teal">
                <a href='index.php?module=categories&action=manage_categories' class="btn waves-effect waves-teal">ยกเลิก</a>  
            </div>
        </form>
    </div>
</body>
<?php
    mysqli_free_result($query_cat);
    mysqli_close($con);
?>
</html>