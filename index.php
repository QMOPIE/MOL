<?php require_once('Connections/conn_db.php') ?>
<?php (!isset($_SESSION)) ? session_start() : ""; ?>
<?php require_once("php_lib.php") ?>
<!doctype html>
<html lang="zh-TW">

<head>
    <?php require_once("headfile.php"); ?>
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
                    <div class="">
                        <br>
                        <img src="images/sale.png" alt="" class="img_control">
                        <a href="#"><img src="images/momo.png" alt="momo" title="momo" class="img_control m-2 hot_border"></a>
                        <a href="#"><img src="images/pchome.png" alt="pchome" title="pchome" class="img_control m-2 hot_border"></a>
                        <a href="#"><img src="images/丁丁.png" alt="丁丁藥局" title="丁丁藥局" class="img_control m-2 hot_border"></a>
                    </div>
                </div>
                <div class="col-md-8">
                    <br>
                    <?php require_once("carousel.php"); ?>
                    <br>
                    <?php require_once("product_list.php"); ?>
                </div>
                <div class="col-md-2">
                    <br>
                    <br>
                    <br>
                    <?php require_once("hot.php"); ?>
                </div>
            </div>
    </section>
    <br>
    <section id="scontent">
        <?php require_once("scontent.php"); ?>
    </section>
    <section id="footer">
        <?php require_once("footer.php"); ?>
    </section>
    <?php require_once("jsfile.php"); ?>
</body>

</html>
<?php

?>