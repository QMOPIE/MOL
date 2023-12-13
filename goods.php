<?php require_once('Connections/conn_db.php') ?>
<?php (!isset($_SESSION)) ? session_start() : ""; ?>
<?php require_once("php_lib.php") ?>
<!doctype html>
<html lang="zh-TW">

<head>
    <?php require_once("headfile.php"); ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.7/css/jquery.fancybox.min.css">
    <!-- <link rel="stylesheet" href="fancybox-2.1.7/source/jquery.fancybox.css"> -->
</head>

<body>
    <section id="header">
        <?php require_once("navbar.php"); ?>
    </section>
    <section id="content">
        <div class="container">
            <div class="row">
                <div class="col-md-2">
                    <?php require_once("sidebar.php"); ?>

                    <?php require_once("hot.php"); ?>

                    <div class="col-md-10">
                        <br>
                        <?php require_once("breadcrumb.php"); ?>
                        <?php require_once("goods_content.php"); 
                        ?>
                       

                        <!-- <?php require_once('drop-box.php'); ?> -->
                    </div>

                </div>
            </div>
        </div>
    </section>
    <hr>
    <section id="scontent">
        <?php require_once("scontent.php"); ?>
    </section>

    <section id="footer">
        <?php require_once("footer.php"); ?>
    </section>



    <?php require_once("jsfile.php"); ?>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.7/js/jquery.fancybox.min.js"></script>
    <!-- <script type="text/javascript" src="fancybox-2.1.7/source/jquery.fancybox.js"></script> -->
    <script type="text/javascript">
        $(function(){
            //定義在滑鼠滑過圖片檔名填入主圖src中
            $(".card .row.mt-2 .col-md-4 a").mouseover(function(){
                var imgsrc=$(this).children("img").attr("src");
                $("#showGoods").attr({"src": imgsrc});
            });
            //將子圖片放到lightbox展示
            $(".fancybox").fancybox();
        });
    </script>
    <script type="text/javascript">
       
    </script>

</body>

</html>
<?php

?>