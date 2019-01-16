<?php
    if(empty($_FILES['product_pic']['name'])){
        $pic_name = "";
    } else {
        $tmp_name = $_FILES['product_pic']['tmp_name']; // address tmp file
        $pic_name = $_FILES['product_pic']['name']; // filename
    
        $char = str_shuffle("biyttiigfnbgetohteieimviriiiwi00025145_");
        $time = str_shuffle(date("YmdHis"));
    
        $sum_char = substr("$char.$time",0,15);
    
        $pic_name = $sum_char.$pic_name;
    //copy tmp file to folder img
    copy($tmp_name,"../images/".$pic_name); //copy tmp file to folder img
    }

    $choice_country = (empty($_POST['rd_country']) ? $choice_country = 0 : $choice_country = 1);

    $insert_sql = "INSERT INTO products VALUES ('',
    '".$_POST['txt_productName']."',
    '".$_POST['txt_productDetail']."',
    '".$_POST['txt_priceCommon']."',
    '".$_POST['txt_priceSpecial']."',
    '".$_POST['product_cate']."',
    '".$pic_name."',
    '".$choice_country."')";

    mysqli_query($con , $insert_sql) or die ("Error query 1 : ".mysqli_error($con));

    if(isset($_GET['cateid'])){    
        $queryp = mysqli_query($con,"SELECT product_id FROM products WHERE product_cate='".$_POST['product_cate']."'");
        $row = mysqli_num_rows($queryp);
        $page = ceil($row/15);
        $linkbackinsert = "&page=".$page.(isset($_GET['cateid']) ? "&cateid=".$_POST['product_cate'] : "");
        echo $linkbackinsert;
        mysqli_free_result($queryp);
    }else{
        $linkbackinsert = "&page=".$_GET['pageend'].(isset($_GET['cateid']) ? "&cateid=".$_POST['product_cate'] : "");
    }

    mysqli_close($con);
    echo "<script type='text/javascript'>";
    echo "alert('เพิ่มข้อมูลสำเร็จ !!!');";
    echo "window.location.href = 'index.php?module=products&action=manage_product$linkbackinsert'";
    echo "</script>";
?>