
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
<div class='left-align' style='padding:25px 25px;'>
<form method = "post" action = "index.php?module=categories&action=insert_categories" enctype = "multipart/form-data">
    <h2> ฟอร์มเพิ่มประเภทสินค้า </h2>
    <div class="input-field">
        <input id ="cateName" class="validate" type = "text" name = "txt_cateName">
        <label for="cateName">ชื่อประเภทสินค้า</label>
    </div>
    <div class="row center-align">
        <input type = "submit" name = "submit" value ="เพิ่มประเภทสินค้า" class="btn btn-outline-success">
        <a href='manage_categories.php' class="btn btn-outline-danger">ยกเลิก</a>
    </div>
</form>
</div>
