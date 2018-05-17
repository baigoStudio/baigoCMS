<?php function custom_list($arr_customRows, $article_customs = array()) {
    if (!fn_isEmpty($arr_customRows)) {
        foreach ($arr_customRows as $key=>$value) {
            if (isset($value['custom_childs']) && !fn_isEmpty($value['custom_childs'])) { ?>
                <h5>
                    <span class="badge badge-secondary"><?php echo $value['custom_name'] ; ?></span>
                </h5>
            <?php } else { ?>
                <div class="form-group">
                    <label><?php echo $value['custom_name'] ; ?></label>
                    <div class="form-text">
                        <?php if (isset($article_customs['custom_' . $value['custom_id']])) {
                            echo $article_customs['custom_' . $value['custom_id']];
                        } ?>
                    </div>
                </div>
            <?php }

            if (isset($value['custom_childs']) && !fn_isEmpty($value['custom_childs'])) {
                custom_list($value['custom_childs'], $article_customs);
            }
        }
    }
}

$cfg = array(
    'title'  => $this->tplData['articleRow']['article_title'],
);

include('include' . DS . 'pub_head.php'); ?>

    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo BG_URL_ROOT; ?>">首页</a></li>
        <?php foreach ($this->tplData['articleRow']['cateRow']['cate_trees'] as $key=>$value) { ?>
            <li class="breadcrumb-item"><a href="<?php echo $value['urlRow']['cate_url']; ?>"><?php echo $value['cate_name']; ?></a></li>
        <?php } ?>
    </ol>

    <h3><?php echo $this->tplData['articleRow']['article_title']; ?></h3>
    <div><?php echo date(BG_SITE_DATE . ' ' . BG_SITE_TIMESHORT, $this->tplData['articleRow']['article_time_show']); ?></div>

    <div><?php echo fn_ubb($this->tplData['articleRow']['article_content']); ?></div>

    <?php //print_r($this->tplData['articleRow']['article_customs'];

    if (isset($this->tplData['articleRow']['article_customs'])) {
        custom_list($this->tplData['customRows'], $this->tplData['articleRow']['article_customs']);
    }

    print_r(fn_callAttach(2600));
    print_r(fn_callDisplay(10)); ?>

    <hr>

    <ul class="list-inline">
        <li class="list-inline-item">
            <span class="oi oi-tags"></span>
            Tags:
        </li>

        <?php foreach ($this->tplData['articleRow']['tagRows'] as $tag_key=>$tag_value) { ?>
            <li class="list-inline-item"><a href="<?php echo $tag_value['urlRow']['tag_url']; ?>"><?php echo $tag_value['tag_name']; ?></a></li>
        <?php } ?>
    </ul>

    <ul class="list-unstyled">
        <?php foreach ($this->tplData['associateRows'] as $key=>$value) { ?>
            <li><a href="<?php echo $value['urlRow']['article_url']; ?>"><?php echo $value['article_title']; ?></a></li>
        <?php } ?>
    </ul>

<?php include('include' . DS . 'pub_foot.php');
include('include' . DS . 'html_foot.php');