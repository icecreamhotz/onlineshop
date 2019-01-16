
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
        $array_product = url_searchproduct(1);
        $num_per_page = 10;

        if(empty($_GET['page'])){
            $start_row = 0;
            $page_id = '1';
        }else{
            $page_id = $_GET['page'];
            $start_row = ($page_id-1)*$num_per_page;
        }

        $result = mysqli_query($con,"SELECT us_name FROM user ".$array_product['query']."") or die("error at line 1 :".mysqli_error($con));

        $rows = mysqli_num_rows($result);

        $page = ceil($rows/$num_per_page);

        $linkcheckpage = "&page=".$page_id.(isset($_GET['cateid']) ? "&cateid=".$_GET['cateid'] : "");

        $result = mysqli_query($con,"SELECT * FROM user ".$array_product['query']." LIMIT ".$start_row.",".$num_per_page."") or die("error at line 1 :".mysqli_error($con));

        $getstatus = empty($_GET['status']) ? "" : $_GET['status'];

        if($getstatus == ""){
            $link = "เลือกทั้งหมด";
            $status = "checked";
        }else{
            $link = "ยกเลิกเลือกทั้งหมด";
            $status = "";
        }
    ?>
        <div class="center-align" style="padding:25px;">
        <?php 
            if($rows >= 1 ){
        ?>
        <form method="post" action="delete_user.php">
            <h4 class="green-text center-align" style='margin-bottom:25px;'>จัดการข้อมูลสมาชิก</h4>
            <?php echo "<h5 style='display:inline;'>สมาชิกทั้งหมดมีจำนวน </h5><h5 class='red-text' style='display:inline;'>".$rows."</h5> <h5 style='display:inline;'>รายการ</h5>";?>
        <div style="overflow-x:auto;margin-top:25px;">
        <table class="centered striped2 striped white z-depth-1">
            <thead>
                <tr>
                    <th><?php echo "<a href='index.php?module=user&action=manage_user&status=".$status.(isset($_GET['page']) ? "&page=".$page_id : "")."'>$link</a>"?></th>
                    <th>ลำดับ</th>
                    <th>ชื่อผู้ใช้</th>
                    <th>รหัสผ่าน</th>
                    <th>สถานะ</th>
                    <th>แก้ไข</th>
                    <th>รหัสผ่าน</th>
                </tr>
            </thead>
        <?php
            $i = (($num_per_page*$page_id)-10)+1;
            while(list($usname,$uspwd,$ustype) = mysqli_fetch_row($result)){
                echo "<tr>";
                echo "<td>
                        <input type='checkbox' name='cbkUser[]' id='".$usname."' value='".$usname."' ".$getstatus.">
                        <label for='".$usname."'></label>
                    </td>";
                echo "<td>".$i."</td>";
                echo "<td>".$usname."</td>";
                echo "<td>".$uspwd."</td>";
                echo "<td>".($ustype==1 ? "สมาชิก" : "ผู้ดูแลระบบ")."</td>";
                echo "<td><a href='index.php?module=user&action=edit_user_form&us_name=".$usname.$linkcheckpage."'><img src='../images/ic_edit.png'></a></td>";
                echo "<td><a href='index.php?module=user&action=delete_user&us_name=".$usname.$linkcheckpage."' onclick='return confirm(\"คุณต้องการจะลบหรือไม่ ?\");'><img src='../images/ic_delete.png'></a></td>";
                echo "</tr>";
                $i++;
            }
        ?>
        </table>
        </div>

        <div style="margin-top:25px;margin-bottom:25px;">
            <input type="submit" name="submit" value="ลบผู้ใช้ที่เลือก" class="btn waves-effect waves-teal" onclick="return confirm('คุณต้องการที่จะลบทั้งหมดหรือไม่ ?');" style="background-color:#00bfa5;">
            </form>
        </div>

        <ul class="pagination">
            <li class="waves-effect"><a href="<?php if($page_id==1){echo "#";}else{echo "?index.php?module=user&action=manage_user&page=".($page_id-1);} ?>"><i class="material-icons">chevron_left</i></a></li>
        <?php
            for($i=1;$i<=$page;$i++){
                echo "<li class='waves-effect ",($i==$page_id ? "activeadmin" : ""),"'><a href='index.php?module=user&action=manage_user&page=",$i,"'>",$i,"</a></li>";
            }
        ?>
            <li class="waves-effect"><a href="<?php if($page_id==$page){echo "#";}else{echo "index.php?module=user&action=manage_user&page=".($page_id+1);} ?>"><i class="material-icons">chevron_right</i></a></li>
        </div>
        <?php
        echo "</div>";
        }else{
                echo "<div class='card-panel teal lighten-2 left-align'>";
                echo "<h5>ไม่พบข้อมูลที่ค้นหา</h5>";
                echo "</div>";
            }
        ?>
    </div>
<?php
    mysqli_free_result($result);
    mysqli_close($con);
?>