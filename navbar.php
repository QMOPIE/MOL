<nav class="navbar navbar-expand-lg navbar-light fixed-top">
    <div class="container">
        <a class="navbar-brand" href="index.php"><img src="images/logo.png" class="img-fluid rounded-circle" alt="電商藥粧"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <?php
        //讀取後台購物車內產品數量
        $SQLstring = "SELECT * FROM cart WHERE orderid is NULL AND ip='" . $_SERVER['REMOTE_ADDR'] . "'";
        $cart_rs = $link->query($SQLstring);
        ?>

        <?php
        //列出產品類別第一層
        $SQLstring = "SELECT * FROM pyclass WHERE level=1 ORDER by sort";
        $pyclass01 = $link->query($SQLstring);
        ?>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <div class="offset-1">
                <form name="search" id="search" action="drugstore.php" method="get">
                    <div class="input-group formBox">
                        <input type="text" name="search_name" id="search_name" class="form-control form_bg" placeholder="Search..." value="<?php echo (isset($_GET['search_name'])) ? $_GET['search_name'] : ''; ?>" required>
                        <span class="input-group-btn"><button class="btn btn-default icon_bg" type="submit"><i class="fas fa-search fa-lg" style="color:#fff;"></i></button></span>
                    </div>
                </form>
            </div>
            <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
            <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        關於我們
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">認識企業文化</a></li>
                        <li><a class="dropdown-item" href="#">全台門市資訊</a></li>
                        <li><a class="dropdown-item" href="#">銷售平台</a></li>
                        <li><a class="dropdown-item" href="#">聯絡我們</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">產品資訊</a>
                    <ul class="dropdown-menu">
                        <?php while ($pyclass01_Rows = $pyclass01->fetch()) { ?>
                            <li class="nav-item dropend">
                                <a class="dropdown-item dropdown-toggle" href="#"><?php echo $pyclass01_Rows['cname']; ?></a>
                                <?php
                                //列出產品類別第二層
                                $SQLstring = sprintf("SELECT * FROM pyclass where level=2 and uplink=%d order by sort", $pyclass01_Rows['classid']);
                                $pyclass02 = $link->query($SQLstring);
                                ?>

                                <ul class="dropdown-menu">
                                    <?php while ($pyclass02_Rows = $pyclass02->fetch()) { ?>
                                        <li><a class="dropdown-item" href="drugstore.php?classid=<?php echo $pyclass02_Rows['classid']; ?>"><?php echo $pyclass02_Rows['cname']; ?></a></li>
                                    <?php } ?>
                                </ul>
                            </li>
                        <?php } ?>
                    </ul>
                </li>
                <li class="nav-item"><a class="nav-link active" href="register.php">會員註冊</a></li>
                <?php if (isset($_SESSION['login'])) { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="javascript:void(0);" onclick="btn_confirmLink('是否確定登出?','logout.php')">會員登出</a>
                    </li>
                <?php } else { ?>
                    <li class="nav-item"><a class="nav-link active" href="login.php">會員中心</a></li>
                <?php } ?>
                <li class="nav-item"><a class="nav-link active" href="cart.php">購物車<span class="badge text-bg-danger"><?php echo ($cart_rs) ? $cart_rs->rowCount() : ''; ?></span></a></li>
                <li class="nav-item"><a class="nav-link active" href="orderlist.php">查訂單</a></li>

                <!-- 使用PHP函數外加類別功能 -->
                <?php //multiList01(); 
                ?>
            </ul>
        </div>
    </div>
</nav>
<?php
function multiList01()
{
    global $link;
    //列出產品類別第一層
    $SQLstring = "SELECT * FROM pyclass WHERE level=1 ORDER by sort";
    $pyclass01 = $link->query($SQLstring);
?>
    <?php while ($pyclass01_Rows = $pyclass01->fetch()) { ?>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><?php echo $pyclass01_Rows['cname']; ?></a>
            <ul class="dropdown-menu">
                <?php
                //列出產品類別第二層
                $SQLstring = sprintf("SELECT * FROM pyclass where level=2 and uplink=%d order by sort", $pyclass01_Rows['classid']);
                $pyclass02 = $link->query($SQLstring);
                ?>
                <?php while ($pyclass02_Rows = $pyclass02->fetch()) { ?>
                    <li><a class="dropdown-item" href="drugstore.php?classid=<?php echo $pyclass02_Rows['classid']; ?>">
                            <?php echo $pyclass02_Rows['cname']; ?></a></li>
                <?php } ?>
            </ul>
        </li>
    <?php } ?>
<?php } ?>