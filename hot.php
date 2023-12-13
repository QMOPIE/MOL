<?php
//建立熱銷商品查詢
$SQLstring = "SELECT * FROM hot,product,product_img WHERE hot.p_id=product_img.p_id AND hot.p_id=product.p_id AND product_img.sort=1 order by h_sort";
$hot = $link->query($SQLstring);
?>
<div class="card text-center mt-3" style="border:none;">
<br>
    <div class="card-body">
        <img src="images/hot.png" alt="" class="img_control">
    </div>
    <?php while ($data = $hot->fetch()) { ?>
        <div class="m-2 hot_border">
            <a href="goods.php?p_id=<?php echo $data['p_id']; ?>">
            <img src="product_img/<?php echo $data['img_file']; ?>" class="card-img-top" alt="HOT<?php echo $data['h_sort']; ?>" title="<?php echo $data['p_name']; ?>"></a>
        </div>
    <?php } ?>
</div>
</div>