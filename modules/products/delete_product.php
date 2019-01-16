<?php
    if(isset($_GET['product']) && isset($_GET['page'])){
        $link = "&page=".$_GET['page'].(isset($_GET['cateid']) ? "&cateid=".$_GET['cateid'] : "");
        $pic_name = $_GET['imgname'];
        delete_pic($pic_name);
        query_delete($con,$_GET['product']);
        echo "<script type='text/javascript'>
        alert('ลบข้อมูลสำเร็จ !!!');
        window.location= 'index.php?module=products&action=manage_product".$link."';
        </script>";
    } else {
        $multi_del = $_POST['multi_del'];
        $pic_name = $_POST['picname'];
        $i = 0;
        foreach($multi_del as $product_id){
            $del_pic = $pic_name[$i];
            delete_pic($del_pic);
            query_delete($con,$product_id);
            $i++;
        }
        mysqli_free_result($update_query);
        mysqli_close($con);
        echo "<script type='text/javascript'>";
        echo "alert('ลบข้อมูลสำเร็จ !!!');";
        echo "</script>";
        header("Location:index.php?module=products&action=manage_product".$link."");
    }

    function delete_pic($get_pic){
        $pic_path = "../images/".$get_pic."";
        if(file_exists($pic_path)){
            unlink("../images/".$get_pic."");
        }
    }

    function query_delete($con_get,$product_id_get){
        $query_delete = "DELETE FROM products WHERE product_id='".$product_id_get."'";
        mysqli_query($con_get,$query_delete) or die (mysqli_error($con_get));
    }

    mysqli_close($con);
?>