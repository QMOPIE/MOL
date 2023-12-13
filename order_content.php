<?php
//建立訂單查詢
$maxRows_rs = 5; //分頁設定數量
$pageNum_rs = 0; //起始頁=0
if (isset($_GET['pageNum_order_rs'])) {
    $pageNum_rs = $_GET['pageNum_order_rs'];
}
$startRow_rs = $pageNum_rs * $maxRows_rs;

//列出uorder資料表查詢
$queryFirst = sprintf("SELECT uorder.orderid,uorder.create_date,uorder.remark,ms1.msname AS howpay,ms2.msname AS status ,addbook.*FROM uorder,addbook,multiselect AS ms1,multiselect AS ms2 WHERE ms2.msid=uorder.status AND ms1.msid=uorder.howpay AND uorder.emailid='%d' AND uorder.addressid=addbook.addressid ORDER BY uorder.create_date DESC", $_SESSION['emailid']);
$query = sprintf("%s LIMIT %d,%d", $queryFirst, $startRow_rs, $maxRows_rs);
$order_rs = $link->query($query);
$i = 21; //控制第一筆訂單開啟
?>
<h3>訂單查詢</h3>
<?php if ($order_rs->rowCount() != 0) { ?>
    <div class="accordion" id="accordion_order">
        <?php while ($data01 = $order_rs->fetch()) { ?>
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingOne<?php echo $i; ?>">
                    <a class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne<?php echo $i; ?>" aria-expanded="true" aria-controls="collapseOne<?php echo $i; ?>">
                        <div class="table-responsive-md" style="width:100%">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <td width="10%">訂單編號</td>
                                        <td width="20%">下單日期時間</td>
                                        <td width="15%">付款方式</td>
                                        <td width="15%">訂單狀態</td>
                                        <td width="10%">收件人</td>
                                        <td width="20%">地址</td>
                                        <td width="10%">備註說明</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><?php echo $data01['orderid']; ?></td>
                                        <td><?php echo $data01['create_date']; ?></td>
                                        <td><?php echo $data01['howpay']; ?></td>
                                        <td><?php echo $data01['status']; ?></td>
                                        <td><?php echo $data01['cname']; ?></td>
                                        <td><?php echo $data01['address']; ?></td>
                                        <td><?php echo $data01['remark']; ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </a>
                </h2>
                <div id="collapseOne<?php echo $i; ?>" class="accordion-collapse collapse <?php echo ($i == 21) ? 'show' : ""; ?>" aria-labelledby="headingOne<?php echo $i; ?>" data-bs-parent="#accordion_order">
                    <div class="accordion-body">
                        <?php
                        //處理訂單詳細商品資料列表查詢
                        $SQLstring = sprintf("SELECT *,ms1.msname AS status FROM cart,product,product_img,multiselect AS ms1 WHERE cart.orderid ='%s' AND ms1.msid=cart.status AND cart.p_id=product_img.p_id AND product.p_id=product_img.p_id AND cart.p_id=product.p_id AND product_img.sort=1 ORDER BY cart.create_date DESC", $data01['orderid']);
                        $cart_rs = $link->query($SQLstring);
                        $pTotal = 0;
                         ?>
                        <div class="table-responsive-md" style="width:100%;">
                            <table class="table table-hover mt-3">
                                <thead>
                                    <tr class="bg-primary" style="color: white;">
                                        <td width="10%">產品編號</td>
                                        <td width="10%">圖片</td>
                                        <td width="30%">名稱</td>
                                        <td width="10%">價格</td>
                                        <td width="10%">數量</td>
                                        <td width="15%">小計</td>
                                        <td width="15%">狀態</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($cart_data = $cart_rs->fetch()) { ?>
                                        <tr>
                                            <td><?php echo $cart_data['p_id']; ?></td>
                                            <td><img src="product_img/<?php echo $cart_data['img_file']; ?>" alt="<?php echo $cart_data['p_name']; ?>" class="img-fluid"></td>
                                            <td><?php echo $cart_data['p_name']; ?></td>
                                            <td>
                                                <h4 class="color_e600a0 pt-1"><?php echo $cart_data['p_price']; ?></h4>
                                            </td>
                                            <td><?php echo $cart_data['qty']; ?></td>
                                            <td>
                                                <h4 class="color_e600a0 pt-1"><?php echo $cart_data['p_price'] * $cart_data['qty']; ?></h4>
                                            </td>
                                        </tr>
                                    <?php $pTotal += $cart_data['p_price'] * $cart_data['qty'];
                                    } ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="7">累計:<?php echo $pTotal; ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="7">運費:100</td>
                                    </tr>
                                    <tr>
                                        <td colspan="7" class="color_red">總計:<?php echo $pTotal + 100; ?></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        <?php $i++;
        } ?>
    </div>
    <?php   //取得目前頁數
    if (isset($_GET['totalRows_rs'])) {
        $totalRows_rs = $_GET['totalRows_rs'];
    } else {
        $all_rs = $link->query($queryFirst);
        $totalRows_rs = $all_rs->rowCount();
    }
    $totalPages_rs = ceil($totalRows_rs / $maxRows_rs) - 1;
    //呼叫分頁功能函數
    $prev_rs = "&laquo";
    $next_rs = "&raquo";
    $separator = "|";
    $max_links = 20;
    $pages_rs = buildNavigation($pageNum_rs, $totalPages_rs, $prev_rs, $next_rs, $separator, $max_links, true, 3, "order_rs");
    ?>
    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center">
            <?php echo $pages_rs[0] . $pages_rs[1] . $pages_rs[2]; ?>
        </ul>
    </nav>

<?php } else { ?>
    <div class="alert alert-info" role="alert">
        抱歉！目前還沒有任何的訂單。
    </div>
<?php } ?>