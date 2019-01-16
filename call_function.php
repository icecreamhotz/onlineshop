<?php
    function url_searchproduct($page){

        $get_action = $_GET['action'];
        $get_cateid = "";
        $query_select = "";
        
        // logic url search
        if(isset($_SESSION['user_type'])){
            $type = $_SESSION['user_type'];
        }else{
            $type = 99;
        }

        if($type == 0){

            $logic_url1 = "manage_product";
            $logic_url2 = "manage_categories";
            $logic_url3 = "manage_user";

        }else if($type == 2){



        }else{

            $logic_url1 = "select_product";
            $logic_url2 = "list_categories";

        }

        if(isset($_SESSION['ei'])){
            if($get_action == "manage_user"){
                $query_select = " WHERE us_name LIKE'%".$_SESSION['ei']."%'";
            }else{
                $query_select=" WHERE product_title LIKE'%".$_SESSION['ei']."%' OR product_detail LIKE'%".$_SESSION['ei']."%'";
            }
        }

        $url_pagination = "index.php?module=products&action=".$logic_url1."";
        //
        if(isset($_GET['cateid']) && isset($_POST['txt_search'])){
           
            $get_cateid = $_GET['cateid'];
            $url_pagination = "index.php?module=products&action=".$logic_url1."&cateid=".$get_cateid.$page;
            $query_select=" WHERE product_cate ='".$get_cateid."' AND (product_title LIKE '%".$_POST['txt_search']."%' OR product_detail LIKE'%".$_POST['txt_search']."%')";
        
        }else if((empty($_GET['cateid']) && isset($_POST['txt_search']) && $get_action == $logic_url1)) {
            $_SESSION['ei'] = $_POST['txt_search'];
            $query_select=" WHERE product_title LIKE'%".$_POST['txt_search']."%' OR product_detail LIKE'%".$_POST['txt_search']."%'";

        }else if(isset($_GET['cateid'])){
           
            $get_cateid = $_GET['cateid'];
            $url_pagination = "index.php?module=products&action=".$logic_url1."&cateid=".$get_cateid;
            $query_select = " WHERE product_cate = '".$get_cateid."'";

        }else if($get_action == "list_categories" || 
                $get_action == "manage_categories"){

                    if(isset($_POST['txt_search'])){
                        $query_select = " WHERE cate_title LIKE'%".$_POST['txt_search']."%'";
                    }
            $url_pagination = "index.php?module=categories&action=".$logic_url2."";

        }else if($get_action == "manage_user"){
            
            if(isset($_POST['txt_search'])){
                $_SESSION['ei'] = $_POST['txt_search'];
                $query_select = " WHERE us_name LIKE'%".$_POST['txt_search']."%'";
            }
            $url_pagination = "index.php?module=user&action=".$logic_url3."";
        }
        //

        

        $ar_product = array("url" => $url_pagination , "query" => $query_select , "cate_id" => $get_cateid);

        return $ar_product;
    }
?>
