    <ol class="breadcrumb">
        <li><a href="<?php echo BG_URL_ROOT; ?>">首页</a></li>
        <?php foreach ($this->tplData['cateRow']['cate_trees'] as $key=>$value) { ?>
            <li><a href="<?php echo $value['urlRow']['cate_url']; ?>"><?php echo $value['cate_name']; ?></a></li>
        <?php } ?>
    </ol>