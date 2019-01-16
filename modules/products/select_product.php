<?php
    $num_per_page = 15;

    if(isset($_GET['page'])){
        $page = $_GET['page'];
        $start_row = ($page-1)*$num_per_page;
    }else{
        $page = 1;
        $start_row = 0;
    }

    $array_product = url_searchproduct(1);

    $result = mysqli_query($con,
    "SELECT product_id FROM products".$array_product['query']) or die ("Error from line 1 : ".mysqli_error($con));
            
    $count_row = mysqli_num_rows($result);
    $page_all = ceil($count_row / $num_per_page);

    $result = mysqli_query($con,
        "SELECT product_id , 
                product_title , 
                product_sprice FROM products".$array_product['query']." ORDER BY product_id ASC LIMIT ".$start_row.",".$num_per_page) or die ("Error from line 1 : ".mysqli_error($con));

    if(!empty($array_product['cate_id'])){
        $query_cate = mysqli_query($con,
        "SELECT cate_title FROM categories WHERE cate_id ='".$array_product['cate_id']."'") or die ("Error from line 1 : ".mysqli_error($con));
        list($cate_title) = mysqli_fetch_row($query_cate);
    }
?>


        <!-- html tag !-->
        <div class='center-align' style='padding:25px 25px;'>
        <?php 
            if($count_row>=1)
            {
        ?>
        <div style='margin-top:20px;margin-bottom:20px;'>
            <h4 style='display:inline;'>แสดงข้อมูลรายการสินค้าทั้งหมด </h4>
            <?php echo "<h4 class='red-text' style='display:inline;'>".$count_row."</h4> <h4 style='display:inline;'>รายการ</h4>";?>
        </div>
        <div class="nav-categories" style='width:100%'>
            <h5 class="<?php echo (isset($_SESSION['user_type']) ? "cyan" : "pink");?>-text" id="cate_dialog">
                <?php 
                    if(empty($array_product['cate_id'])){
                        echo "";
                    }else{
                        echo "หมวดหมู่ : ".$cate_title;
                    }
                ?>
            </h5>
        </div>

        <div style="overflow-x:auto;">
        <table class="centered <?php echo (empty($_SESSION['user_type']) ? "striped" : "striped striped3");?>">
            <thead>
                <tr>
                    <th>รหัสสินค้า</th>
                    <th>ชื่อสินค้า</th>
                    <th>ราคาพิเศษ</th>
                </tr>
            </thead>
        <!-- ________ !-->
        <?php
            echo "<tbody>";
        while(list($product_id,$product_title,$product_name) = mysqli_fetch_row($result)){
            echo "<tr>";
            echo "<td>".$product_id."</td>";
            echo "<td><a href='index.php?module=products&action=product_detail&sendVar=".$product_id."&page=".$page.(isset($_GET['cateid']) ? "&cateid=".$_GET['cateid'] : "")."'>".$product_title."</a></td>";
            echo "<td>".$product_name."</td>";
            echo "</tr>";
        }
            echo "</tbody>";
        echo "</table>";
        echo "</div>";
        ?>
        <?php
            $active_css = (empty($_SESSION['user_type']) ? "active" : "activemember");
        ?>
            <ul class="pagination center-align">
            <li class="waves-effect"><a href="<?php echo($page == 1 ? "#" : "index.php?module=products&action=select_product&page=".($page-1));?>"><i class="material-icons">chevron_left</i></a></li>
                <?php
                    for($i = 1;$i <= $page_all;$i++){
                        echo "<li class='waves-effect ",($page==$i ? $active_css : ""),"'><a href='",$array_product['url']
                        ,"&page=",$i,"'>",$i,"</a></li>";
                    }
                ?>
            <li class="waves-effect"><a href="<?php echo($page == $page_all ? "#" : "index.php?module=products&action=select_product&page=".($page+1));?>"><i class="material-icons">chevron_right</i></a></li>
            </ul>
        </div>
        <?php
        }else{
        ?>

        <div class="card-panel <?php echo (empty($_SESSION['user_type']) ? "red" : "cyan"); ?> accent-2" >
            <?php
               echo "<h5>ไม่พบข้อมูลที่ค้นหา</h5>";
            ?>
        </div>
    
        <?php
            }
        ?>
<?php
        echo "</div>";
        
        mysqli_free_result($result); // clear data
        mysqli_close($con);
?>