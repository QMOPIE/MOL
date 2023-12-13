<?php
//取得收件者地址資料
$SQLstring = sprintf("SELECT * ,city.Name AS ctName,town.Name AS toName FROM addbook,city,town WHERE emailid='%d' AND setdefault='1' AND addbook.myzip=town.Post AND town.AutoNo=city.AutoNo", $_SESSION['emailid']);
$addbook_rs = $link->query($SQLstring);
if ($addbook_rs && $addbook_rs->rowCount() != 0) {
    $data = $addbook_rs->fetch();
    $cname = $data['cname'];
    $mobile = $data['mobile'];
    $myzip = $data['myzip'];
    $address = $data['address'];
    $ctName = $data['ctName'];
    $toName = $data['toName'];
} else {
    $cname = "";
    $mobile = "";
    $myzip = "";
    $address = "";
    $ctName = "";
    $toName = "";
} ?>


<h3>會員：<?php echo $_SESSION['cname']; ?>結帳作業</h3>
<div class="row">
    <div class="card" style="width:30rem;">
        <div class="card-header" style="color:#007bff;"><i class="fas fa-truck fa-flip-horizontal me-1"></i>
            配送資訊
        </div>
        <div class="card-body">
            <h4 class="card-title">收件人資訊:</h4>
            <h5 class="card-title">姓名：<?php echo $cname; ?></h5>
            <p class="card-text">電話：<?php echo $mobile; ?></p>
            <p class="card-text">郵遞區號：<?php echo $myzip . $ctName . $toName; ?></p>
            <p class="card-text">地址：<?php echo $address; ?></p>
            <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">選擇其他收件人</button>
        </div>
    </div>
    <div class="card ml-3" style="width:50rem;">
        <div class="card-header" style="color:#000;"><i class="fas fa-credit-card me-1">付款方式</i>
        </div>
        <div class="card-body pl-3 pt-2 pb-2">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="home-tab" data-bs-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true" style="color:#007bff !important;font-size:14pt;">貨到付款</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="profile-tab" data-bs-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false" style="color:#007bff !important;font-size:14pt;">信用卡</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="contact-tab" data-bs-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false" style="color:#007bff !important; font-size:14pt;">銀行轉帳</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="contact-tab" data-bs-toggle="tab" href="#epay" role="tab" aria-controls="epay" aria-selected="false" style="color:#007bff !important; font-size:14pt;">電子支付</button>
                </li>

            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <h4 class="card-title pt-3">付款人資訊:</h4>
                    <h5 class="card-title">姓名：<?php echo $cname; ?></h5>
                    <p class="card-text">電話：<?php echo $mobile; ?></p>
                    <p class="card-text">郵遞區號：<?php echo $myzip . $ctName . $toName; ?></p>
                    <p class="card-text">地址：<?php echo $address; ?></p>
                </div>
                <div class="tab-pane fade pl-2" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <h4 class="card-title pt-3">選擇付款帳戶:</h4>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col" width="5%">#</th>
                                <th scope="col" width="25%">信用卡系統</th>
                                <th scope="col" width="35%">發卡銀行</th>
                                <th scope="col" width="35%">信用卡號</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row"><input type="radio" name="creditCard" id="creditCard[]" checked></th>
                                <td><img src="images/Visa_Inc._logo.svg" alt="visa" class="img-fluid"></td>
                                <td>玉山商業銀行</td>
                                <td>1234 ****</td>
                            </tr>
                            <tr>
                                <th scope="row"><input type="radio" name="creditCard" id="creditCard[]"></th>
                                <td><img src="images/MasterCard_Logo.svg" alt="master" class="img-fluid"></td>
                                <td>玉山商業銀行</td>
                                <td>1234 ****</td>
                            </tr>
                            <tr>
                                <th scope="row"><input type="radio" name="creditCard" id="creditCard[]"></th>
                                <td><img src="images/UnionPay_logo.svg" alt="unionpay" class="img-fluid"></td>
                                <td>玉山商業銀行</td>
                                <td>1234 ****</td>
                            </tr>
                        </tbody>
                    </table>
                    <hr>
                    <button type="button" class="btn btn-outline-success">使用信用卡付款</button>
                </div>

                <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                    <h4 class="card-title pt-3">ATM匯款資訊</h4>
                    <img src="images/Cathay-bk-rgb-db.svg" alt="cathay" class="img-fluid">
                    <h5 class="card-title">匯款銀行：國泰世華銀行 銀
                        行代碼：013</h5>
                    <h5 class="card-title">姓名：林小強</h5>
                    <p class="card-text">匯款帳號：1234-4567-7890-
                        1234</p>
                    <p class="card-text">匯款帳號：1234-4567-7890-
                        1234</p>
                </div>

                <div class="tab-pane fade" id="epay" role="tabpanel" aria-labelledby="epay-tab">
                    <h4 class="card-title pt-3">選擇電子支付方式</h4>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col" width="5%">#</th>
                                <th scope="col" width="25%">電子支付系統</th>
                                <th scope="col" width="70%">電子支付公司</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row"><input type="radio" name="epay" id="epay[]" checked></th>
                                <td><img src="images/Apple_Pay_logo.svg" alt="applepay" class="img-fluid"></td>
                                <td>Apple Pay</td>
                            </tr>
                            <tr>
                                <th scope="row"><input type="radio" name="epay" id="epay[]"></th>
                                <td><img src="images/Line_pay_logo.svg" alt="applepay" class="img-fluid"></td>
                                <td>Line Pay</td>
                            </tr>
                            <tr>
                                <th scope="row"><input type="radio" name="epay" id="epay[]"></th>
                                <td><img src="images/JKOPAY_logo.svg" alt="jkopay" class="img-fluid"></td>
                                <td>JKOPAY</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <?php
    //建立結帳表格資料庫查詢
    $SQLstring = "SELECT * FROM cart,product,product_img WHERE ip='" . $_SERVER['REMOTE_ADDR'] . "' AND orderid is NULL AND cart.p_id=product_img.p_id AND cart.p_id=product.p_id AND product_img.sort=1 ORDER BY cartid DESC";
    $cart_rs = $link->query($SQLstring);
    $pTotal = 0; //設定累加變數$pTotal
    ?>
    <div class="table-responsive-md" style="width:80%;">
        <table class="table table-hover mt-3">
            <thead>
                <tr class="bg-primary" style="color: white;">
                    <td width="10%">產品編號</td>
                    <td width="10%">圖片</td>
                    <td width="30%">名稱</td>
                    <td width="15%">價格</td>
                    <td width="15%">數量</td>
                    <td width="20%">小計</td>
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
            <tfoot class="text-center">
                <tr>
                    <td colspan="7">累計:<?php echo $pTotal; ?></td>
                </tr>
                <tr>
                    <td colspan="7">運費:100</td>
                </tr>
                <tr>
                    <td colspan="7" class="color_red">總計:<?php echo $pTotal + 100; ?></td>
                </tr>
                <tr>
                    <td colspan="7">
                        <button type="button" id="btn04" name="btn04" class="btn btn-danger "><i class="fas fa-cart-arrow-down pr-2"></i>確認結帳</button>
                        <button type="button" id="btn05" name="btn05" class="btn btn-warning " onclick="window.history.go(-1)"><i class="fas fa-undo-alt pr-2"></i>回上一頁</button>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>