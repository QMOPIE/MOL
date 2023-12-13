<div class="sidebar">
    <a href="index.php"><img src="images/child.png" alt="" class="child_logo"></a>
</div>
<?php
$SQLstring = "SELECT * FROM pyclass WHERE level=1 ORDER BY sort";
$pyclass01 = $link->query($SQLstring);
$i = 1;
?>
<div class="accordion" id="accordionExample">
    <?php while ($pyclass01_Rows = $pyclass01->fetch()) {
        $i = $pyclass01_Rows['classid']; ?>
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingOne<?php echo $i; ?>">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne<?php echo $i; ?>" aria-expanded="true" aria-controls="collapseOne<?php echo $i; ?>"><i class="fas <?php echo $pyclass01_Rows['fonticon']; ?>"></i>&nbsp&nbsp<?php echo $pyclass01_Rows['cname']; ?>
                </button>
            </h2>
            <?php
            if(isset($_GET['p_id'])){   //如果使用產品查詢，需取得類別編號上一層類別
                $SQLstring =sprintf("SELECT uplink FROM pyclass,product WHERE pyclass.classid=product.classid AND p_id=%d" ,$_GET['p_id']);
                $classid_rs = $link->query($SQLstring);
                $data = $classid_rs->fetch();
                $ladder = $data['uplink'];

            //使用第一層類別查詢
            }elseif(isset($_GET['level']) && $_GET['level'] == 1) {
                $ladder = $_GET['classid'];
            }elseif (isset($_GET['classid'])) { //如果使用類別查詢需取得上一層類別 
                $SQLstring = "SELECT uplink FROM pyclass where level=2 and classid=" . $_GET['classid'];
                $classid_rs = $link->query($SQLstring);
                $data = $classid_rs->fetch();
                $ladder = $data['uplink'];
            } else {
                $ladder = 1;
            }
            //列出產品類別第二層
            $SQLstring = sprintf("SELECT * FROM pyclass where level=2 and uplink=%d order by sort", $pyclass01_Rows['classid']);
            $pyclass02 = $link->query($SQLstring);
            ?>
            <div id="collapseOne<?php echo $i; ?>" class="accordion-collapse collapse <?php echo ($i == $ladder) ? 'show' : ''; ?>" aria-labelledby="headingOne<?php echo $i; ?>" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    <table class="table">
                        <tbody>
                            <?php while ($pyclass02_Rows = $pyclass02->fetch()) { ?>
                                <tr>
                                    <td ><a  class="sidebar_color" href="drugstore.php?classid=<?php echo $pyclass02_Rows['classid']; ?>"><?php echo $pyclass02_Rows['cname']; ?></td>
                                </tr>
                            <?php  } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php $i++;
    }  ?>
</div>