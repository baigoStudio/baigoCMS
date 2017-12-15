<?php $cfg = array(
    'title'       => $this->tplData['specRow']['spec_name'],
    'str_url'     => $this->tplData['specRow']['urlRow']['spec_url'] . $this->tplData['specRow']['urlRow']['page_attach'],
    'str_urlMore' => $this->tplData['specRow']['urlRow']['spec_urlMore'] . $this->tplData['specRow']['urlRow']['page_attach'],
    'page_ext'    => $this->tplData['specRow']['urlRow']['page_ext'],
);

if (isset($this->tplData['specRow']['is_static'])) {
    $cfg['is_static'] = 'true';
}

include('include' . DS . 'pub_head.php'); ?>

    <ol class="breadcrumb">
        <li><a href="<?php echo BG_URL_ROOT; ?>">首页</a></li>
        <li><a href="<?php echo $this->tplData['urlRow']['spec_url']; ?>">专题</a></li>
        <li><?php echo $this->tplData['specRow']['spec_name']; ?></li>
    </ol>

    <?php foreach ($this->tplData['articleRows'] as $key=>$value) { ?>
        <h3><a href="<?php echo $value['urlRow']['article_url']; ?>" target="_blank"><?php echo $value['article_title']; ?></a></h3>
        <div><?php echo date(BG_SITE_DATE, $value['article_time_show']); ?></div>
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