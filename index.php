<?php
  session_start();
  include("include/connect_db.php");
  include("call_function.php");

  if(isset($_GET['action'])){
    if(($_GET['action'] == "loginandregister") && isset($_SESSION['user_type'])){
        header("Location:index.php");
    }
  }

  if(isset($_GET['cateid'])){
      $cate_id = true;
  }else{
      $cate_id = false;
  }

  if(isset($_SESSION['valid_login'])){
      $get_sessiontype = $_SESSION['user_type'];
      if($get_sessiontype == 0){
          $bg_color = "#00bfa5";
          $class_hover = "input-fieldsearchadmin";
      }else if($get_sessiontype == 1){
          $bg_color = "#26c6da";
          $class_hover = "input-fieldsearchmember";
      }
  }else{
          $bg_color = "#ee6e73";
          $get_sessiontype = 3;
          $class_hover = "";
  }

?>

<html>
<head>
<meta charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="../css/materialize.min.css" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <title>CIS Online Shop</title>
    <style>
        .nav-wrapper{
          transition : margin 0.3s;
        }
        html{
            font-family:finalFont !important;
        }
        body{
            overflow:scroll !important;
        }
        tr{
            transition:background-color 0.6s;
        }
        a{
            color:#212121;
        }
        .kuy{
            background-color:red;
        }
        ::placeholder{
            color:white;
        }
        .nav-categories{
            color:white;
        }
        .content-register{
            width:100%
        }
        #textanimate{
            font-weight:400;
            margin:0 auto;
            width: 14em;
            border-right: 2px solid rgba(0,0,0,.75);
            font-size: 200% !important;
            white-space: nowrap;
            overflow: hidden;
            transform: translateY(100%); 
            animation:typewriter 0.8s steps(44) 0.2s 1 normal backwards,
                    blinkTextCursor 500ms steps(44) infinite normal;
        }
        @keyframes typewriter{
            from{width:0;color:black;font-weight:normal;}
            to{width:14em;color:black;font-weight:400;}
        }
        @keyframes blinkTextCursor{
            from{border-right-color:rgba(0,0,0.75);}
            to{border-right-color:transparent;}
        }
        nav,main,footer{
            padding-left:300px;
        }
            @media only screen and (max-width : 992px) {
            nav, main,footer {
                padding-left: 0;
            }
            .side-nav{
                width:270px;
            }
        }
  </style>
</head>
<body>
    
    <!--- Js for background ?-->
    <script type="text/javascript">
    var cate_id = <?=json_encode($cate_id)?>;
    var user_type = <?=json_encode($get_sessiontype)?>;
    </script>
    <!--- _______________ ?-->
    
    <nav style='background-color:<?php echo $bg_color;?>; !important'>
        <div class="nav-wrapper" id="nav-wrap" style='background-color:<?php echo $bg_color;?>;'>    
            <a href="#" data-activates="slide-out" class="button-collapse show-on-large" id="btnshow" ><i class="material-icons">menu</i></a>                    
            <a href="#" class="brand-logo" id="brand">CIS Online Shop</a>
            <?php 
                $get_action = empty($_GET['action']) ? "" : $_GET['action'];
                if($get_action == "select_product" ||
                $get_action == "list_categories" ||
                $get_action == "manage_product" ||
                $get_action == "manage_categories" ||
                $get_action == "manage_user"){
                    // hover border

                    if(isset($_GET['module'])){
                        if($_GET['module'] == "products"){
                            $title_placeholder = "ค้นหาสินค้าหรือรายละเอียดสินค้า";
                        }else if($_GET['module'] == "categories"){
                            $title_placeholder = "ค้นหาหมวดหมู่สินค้า";
                        }else{
                            $title_placeholder = "ค้นหาผู้ใช้งาน";
                        }
                    }

                    $page = isset($_GET['page']) ? "&page=".$_GET['page'] : "";

                    if(empty($_GET['page'])){
                        unset($_SESSION['ei']);
                    }

                    $array_product = url_searchproduct($page);   
                
                    if(isset($_SESSION['ei'])) {
                        $value_search = $_SESSION['ei']; 
                    }else if(isset($_POST['txt_search'])){ 
                        $value_search = $_POST['txt_search']; 
                    }else{
                        $value_search = "";
                    }

                    echo "<ul id='nav-mobile' class='right hide-on-med-and-down'>";
                    echo "<li>";
                    echo "<form method='post' action='",$array_product['url'],"'>";
                    echo "<div class='input-fieldsearch ".$class_hover."' style='position:absolute !important;top:0 !important;right:0 !important;z-index:0 !important'>";
                    echo "<input id='search' name='txt_search' type='search' placeholder='".$title_placeholder."' onfocusout='focusOutfunc()' 
                    value='".$value_search."'>";
                    echo "<label class='label-icon' for='search'><i class='material-icons' style='position:absolute;top:0;color:white;margin-left:10px'>search</i></label>";
                    echo "<i class='material-icons'>close</i>";
                    echo "</div>";
                    echo "</form>";
                    echo "</li>";     
                    echo "</ul>";
                }
            ?>
            <ul class="side-nav" id="slide-out">
                <?php include('include/menu.php');?>
            </ul>
        </div>
    </nav>

    <main>
        <?php
            if(!isset($_SESSION['valid_login']) && isset($_GET['module']) && $_GET['action'] != "loginandregister"){
        ?>
        <div class="content-register">
            <div class="container white z-depth-2" style="margin-top:20px;" id="register-content">
                <div class="card-panel lighten-3 " style='background-color:<?php echo "#ee6e738c;";?>font-weight:bold'>
                    <div class="row center-align">
                        คุณยังไม่ได้เข้าสู่ระบบ กรุณาเข้าสู่ระบบ !!
                    </div>
                    <div class="row center-align">
                        <a class="waves-effect waves-light btn" href='index.php?module=user&action=loginandregister' style='background-color:<?php echo "#ee6e738f;";?>'><i class="material-icons left">account_circle</i>เข้าสู่ระบบ/สมัครสมาชิก</a>
                    </div>
                </div>
            </div>
        </div>
        <?php
            }
        ?>

        <div class="container white z-depth-2" style="margin-top:<?php echo (isset($_GET['module']) && !isset($_SESSION['valid_login']) && $_GET['action'] != "loginandregister" ? "20px;" : "50px;");?><?php echo (!isset($_GET['module']) && !isset($_GET['action']) ? "background-color:$bg_color !important;" : "");?>;">
            <div class="row">
                <?php
                    if(empty($_GET['module'])){
                        $module = "home";
                        $action = "home.php";
                    }else{
                        $module = $_GET['module'];
                        $action = $_GET['action'].".php";
                    }
                if($action == "loginandregister.php"){
                    include("include/login_form.html");
                }else{
                    include("modules/$module/$action");
                }
                ?>
            </div>
        </div>
    </main>

    

    <footer class="page-footer" style='margin-top:0px;background-color:<?php echo $bg_color;?>;'>
          <div class="container">
            <div class="row">
              <div class="col l4 s12">
                <h5 class="white-text">CIS Online Shop</h5>
                <p class="grey-text text-lighten-4">เว็บไซต์นี้เป็นส่วนหนึ่งของวิชา Web Programming ใช้เพื่อการศึกษา</p>
              </div>
              <div class="col l3 offset-l1 s1">
              <h5 class="white-text">Special Thanks</h5>
                <p class="grey-text text-lighten-4">Aj.Tewa Promnuchanont</p>
              </div>
              <div class="col l2 offset-l1 s12">
                <h5 class="white-text">Contact me</h5>
                <ul class="follow">
                  <li><a class="white-text" href="https://www.facebook.com/bbestz.anucha">Facebook</a></li>
                  <li><a class="white-text" href="https://www.youtube.com/channel/UCapwIEQDGdyt_rEh_9e796A?view_as=subscriber">Youtube</a></li>
                  <li><a class="white-text" href="https://www.instagram.com/l3estzzzzzz/">Instagram</a></li>
                  <li><a class="white-text" href="https://plus.google.com/u/0/113643736148958985179">Google</a></li>
                </ul>
              </div>
            </div>
          </div>
          <div class="footer-copyright">
            <div class="container">
                <div class="row" style='padding-top:20px;'>
                    <div class="col s8">
                        Design by Anucha Phudtapranee is an Business Information Systems with a major in Software Development , Used <a class="grey-text text-lighten-3" href="http://materializecss.com/" style='text-decoration:underline'>Materialize</a> Framework in the development
                    </div>
                    <div class="col s4">
                        <a class="grey-text text-lighten-4 right">Copyright 2018 Web Programming 2/60</a>
                    </div>
                </div>
            </div>
          </div>
        </footer>
    

  <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
  <script type="text/javascript" src="../js/materialize.min.js"></script>
  <script type="text/javascript" src="../js/event_css.js"></script>
</body>
</html>
