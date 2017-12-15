<?php $str_url = $this->tplData['cateRow']['urlRow']['cate_url'];

if (BG_MODULE_GEN < 1) {
    $str_url .= $str_url . 'key-' . $this->tplData['search']['key'] . '/customs-' . $this->tplData['search']['customs'] . '/';
}

$cfg = array(
    'title'       => $this->tplData['cateRow']['cate_name'],
    'str_url'     => $str_url . $this->tplData['cateRow']['urlRow']['page_attach'],
    'str_urlMore' => $this->tplData['cateRow']['urlRow']['cate_urlMore'] . $this->tplData['cateRow']['urlRow']['page_attach'],
    'page_ext'    => $this->tplData['cateRow']['urlRow']['page_ext'],
);

if (isset($this->tplData['cateRow']['is_static'])) {
    $cfg['is_static'] = 'true';
}

include('include' . DS . 'pub_head.php');

    include('include' . DS . 'breadcrumb.php'); ?>

    <!--#include virtual="/cms/call/9.html" -->

    <?php foreach ($this->tplData['articleRows'] as $key=>$value) { ?>
        <h3><a href="<?php echo $value['urlRow']['article_url']; ?>" target="_blank"><?php echo $value['article_title']; ?></a></h3>
        <div><?php echo date(BG_SITE_DATE, $value['article_time_show']); ?></div>

        <div><?php echo $value['article_excerpt']; ?></div>
        <div><a href="<?php echo $value['urlRow']['article_url']; ?>">阅读全文...</a></div>
        <hr>
        <ul class="list-inline">
            <li>
                <span class="glyphicon glyphicon-tags"></span>
                Tags:
            </li>
            <?php if (isset($value['tagRows'])) {
                foreach ($value['tagRows'] as $tag_key=>$tag_value) { ?>
                    <li>
                        <a href="<?php echo $tag_value['urlRow']['tag_url']; ?>"><?php echo $tag_value['tag_name']; ?></a>
                    </li>
                <?php }
            } ?>
        </ul>
    <?php }

    include('include' . DS . 'page.php');

include('include' . DS . 'pub_foot.php');
include('include' . DS . 'html_foot.php'); ?>