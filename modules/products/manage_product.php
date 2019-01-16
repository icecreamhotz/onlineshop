
    <?php
        if(isset($_SESSION['valid_login'])){
            if($_SESSION['user_type'] != "0"){
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
        
        $rows_per_pages = 15;
        
        if(empty($_GET['page'])){
            $page_id = '1';
            $start_row = 0;  
        }else {
            $page_id = $_GET['page'];
            $start_row = ($page_id-1)*$rows_per_pages;
        }

        
        $array_product = url_searchproduct(1);
 


        $linkcheck = "&page=".$page_id.(isset($_GET['cateid']) ? "&cateid=".$_GET['cateid'] : "");
                    
        ////// query for product ////////////////
        $result = mysqli_query($con,
        "SELECT product_id FROM products ".$array_product['query']."") or die ("Error from line 1 : ".mysqli_error($con));
        $rows = mysqli_num_rows($result); // นับจำนวนแถวที่คิวรี่ออกมาได้

        $page = ceil($rows/$rows_per_pages);

        $linkcheckinsert = "&page=".$page_id."&pageend=".$page.(isset($_GET['cateid']) ? "&cateid=".$_GET['cateid'] : "");
     
        $result = mysqli_query($con,
        "SELECT product_id , 
                product_title , 
                product_sprice ,
                product_pic FROM products ".$array_product['query']." LIMIT ".$start_row.",".$rows_per_pages." ") or die ("Error from line 1 : ".mysqli_error($con));

        $a = empty($_GET['a']) ? "" : $_GET['a'];

        if($a==""){
            $status = "checked";
            $link = "เลือกทั้งหมด";
        }else{
            $link = "ยกเลิกทั้งหมด";
            $status = "";
        }
        //////////////////////////////////////

        //////// query for categories ///////////////
        if(!empty($array_product['cate_id'])){
            $query_cate = mysqli_query($con,
            "SELECT cate_title FROM categories WHERE cate_id ='".$array_product['cate_id']."'") or die ("Error from line 1 : ".mysqli_error($con));
            list($cate_title) = mysqli_fetch_row($query_cate);
        }
        //////////////////////////////////////////////

        echo "<div class='center-align' style='padding:25px 25px;'>";
        if($rows >= 1){
        echo "<h3>แสดงข้อมูลรายการสินค้าทั้งหมด</h3>";
        echo "<h4 style='display:inline;'>สินค้าทั้งหมดมีทั้งหมด </h4><h4 class='red-text' style='display:inline;'>".$rows."</h4> <h4 style='display:inline;'>รายการ</h4>";

    ?>

        <div class="nav-categories" style='width:100%;z-index:999'>
            <h5 class="teal-text" id="cate_dialog">
                <?php 
                    if(empty($array_product['cate_id'])){
                        echo "";
                    }else{
                        echo "หมวดหมู่ : ".$cate_title;
                    }
                ?>
            </h5>
        </div>

        <div class="fixed-action-btn"> 
            <a href="index.php?module=products&action=insert_product_form<?php echo $linkcheckinsert;?>" class="btn-floating btn-large waves-effect waves-light teal"><i class="material-icons">add</i></a>
        </div>

        <!-- html tag !-->
        <form method="post" action="index.php?module=products&action=delete_product<?php echo $linkcheck;?>">
            <div style='overflow-x:auto;'>
                <table class="striped striped2 centered white z-depth-1" style='margin-top:30px;'>
                    <thead>
                        <tr>
                            <th><?php echo "<a href='index.php?module=products&action=manage_product&a=".$status.(isset($_GET['page']) ? "&page=".$page_id : "") ."'>".$link."</a>"; ?></th>
                            <th>รหัสสินค้า</th>
                            <th style='width:900px;text-align:center;'>ชื่อสินค้า</th>
                            <th>ราคาพิเศษ</th>
                            <th>แก้ไข</th>
                            <th>ลบ</th>
                        </tr>
                    </thead>
                <!-- ________ !-->
                <?php
                while(list($product_id,$product_title,$product_name,$product_pic) = mysqli_fetch_row($result)){
                    echo "<tr>";
                    echo "<td>";
                ?>
                        <input type='checkbox' name='multi_del[]' id='<?php echo $product_id;?>' value='<?php echo $product_id;?>' <?php echo $a;?>>
                        <label for='<?php echo $product_id;?>'></label>
                    </td>
                <?php
                    echo "<td>".$product_id."</td>";
                    echo "<td><a href='index.php?module=products&action=product_detail&sendVar=".$product_id."&page=".$page_id.(isset($_GET['cateid']) ? "&cateid=".$_GET['cateid'] : "")."'>".$product_title."</a></td>";
                    echo "<td>".$product_name."</td>";
                    echo "<td><a href='index.php?module=products&action=edit_product_form&product=".$product_id.$linkcheck."'><img src='../images/ic_edit.png'></a></td>";
                    echo "<td align='center'><a href='index.php?module=products&action=delete_product&product=".$product_id."&imgname=".$product_pic.$linkcheck."' onclick='return confirm(\"ลบสินค้านี้หรือไม่ ?\")'><img src='../images/ic_delete.png'></a></td>";
                    echo "<input type='hidden' name='picname[]' value='".$product_pic."'>";
                    echo "<input type='hidden' name='page' value='".$page_id."'>"; 
                    echo "</tr>";
                }
            echo "</table>";
            echo "</div>";
        ?>
        <div class='center-align col s12' style='margin-top:20px;margin-bottom:30px;'>
            <input type="submit" name="del_btn" value="ลบ" class="btn btn-outline-danger" >
        </div>
        <ul class="pagination center-align">
        <li class="waves-effect"><a href="<?php if($page_id==1){echo "#";}else{echo "index.php?module=products&action=manage_product&page=".($page_id-1);} ?>"><i class="material-icons">chevron_left</i></a></li>
                <?php
                    for($i = 1;$i <= $page;$i++){
                        echo "<li class='waves-effect ",($page_id==$i ? "activeadmin" : ""),"'><a href='",$array_product['url'],"&page=",$i,"'>",$i,"</a></li>";
                    }
                ?>
        <li class="waves-effect"><a href="<?php if($page_id==$page){echo "#";}else{echo "index.php?module=products&action=manage_product&page=".($page_id+1);} ?>"><i class="material-icons">chevron_right</i></a></li>
        </ul>

        <?php
            echo "</form>";
            echo "</div>";
        }else{
            echo "<div class='card-panel teal lighten-2' >";
            echo "<h5>ไม่พบข้อมูลที่ค้นหา</h5>";
            echo "</div>";
            echo "</div>";
        }
        
        mysqli_free_result($result); // clear data
        mysqli_close($con);
    ?>
