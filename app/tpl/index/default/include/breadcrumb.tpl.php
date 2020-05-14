    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo $dir_root; ?>">首页</a></li>
        <?php if (isset($cateRow['cate_breadcrumb'])) {
            foreach ($cateRow['cate_breadcrumb'] as $key=>$value) { ?>
                <li class="breadcrumb-item"><a href="<?php echo $value['cate_url']['url']; ?>"><?php echo $value['cate_name']; ?></a></li>
            <?php }
        } ?>
    </ol>