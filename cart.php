<?php require_once('Connections/conn_db.php') ?>
<?php (!isset($_SESSION)) ? session_start() : ""; ?>
<?php require_once("php_lib.php") ?>
<!doctype html>
<html lang="zh-TW">

<head>
    <?php require_once("headfile.php"); ?>
    <style type="text/css">
        /* 輸入有錯誤時，顯示紅框*/
        table input:invalid {
            border: solid red 3px;
        }
    </style>
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
                        <?php //require_once("carousel.php"); 
                        ?>
                        <hr>
                        <?php //require_once("product_list.php"); 
                        ?>
                        <?php require_once("cart_content.php"); 
                        ?>
                       
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


</body>
<script type="text/javascript">
   
      //將變更的數量寫入後台資料庫
      $("input").change(function() {
        var qty = $(this).val();
        const cartid = $(this).attr("cartid");
        if(qty <= 0 || qty >= 50) {
            alert("更改數量需大於0以上，以及小於50以下。")
            return false;
        }
        $.ajax({
            url:'change_qty.php',
            type:'post',
            dataType:'json',
            data:{
                cartid: cartid,
                qty: qty,
            },
            success: function(data) {
                if(data.c == true) {
                    //alert(data.m)
                    window.location.reload();
                }else{
                    alert(data.m);
                }
            },
            error: function(data){
                alert("系統目前無法連接到後台資料庫");
            }
        });
    });
</script>


</html>
<?php

?>