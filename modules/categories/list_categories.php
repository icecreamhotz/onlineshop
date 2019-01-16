<?php
    $array_product = array();
    $array_product = url_searchproduct(1);

    $result = mysqli_query($con,"SELECT * FROM categories".$array_product['query'])
    or die("error at line 1 : ".mysqli_error($con));
    $count_row = mysqli_num_rows($result);
?>
    <?php
        if(mysqli_num_rows($result) >= 1){
    ?>
        <div class='center-align' style='padding:25px 25px;'>
        <div style='margin-top:20px;margin-bottom:20px;'>
            <h4 style='display:inline;'>แสดงข้อมูลประเภทสินค้าทั้งหมด </h4>
            <?php echo "<h4 class='red-text' style='display:inline;'>".$count_row."</h4> <h4 style='display:inline;'> รายการ</h4>";?>
        </div>
        <div style="overflow-x:auto;">
        <table class='<?php echo (empty($_SESSION['user_type']) ? "striped" : "striped striped3");?>'>
            <thead>
                <tr>
                    <th style='padding-left:20px;'>ประเภทสินค้า</th>
                </tr>
            </thead>   
            <tbody>
    <?php
        while(list($cate_id,$cate_title) = mysqli_fetch_row($result)){
            echo "<tr>";
            echo "<td style='padding-left:20px;'><a href='index.php?module=products&action=select_product&cateid=",$cate_id,"'>",$cate_title,"</a></td>";
            echo "</tr>";
        }
    ?>
        </table>
        </div>
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
