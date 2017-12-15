<?php $cfg = array(
    'title'      => $this->tplData['tagRow']['tag_name'],
    'str_url'    => $this->tplData['tagRow']['urlRow']['tag_url'] . $this->tplData['tagRow']['urlRow']['page_attach'],
    'page_ext'   => $this->tplData['tagRow']['urlRow']['page_ext'],
);

include('include' . DS . 'pub_head.php'); ?>

    <ol class="breadcrumb">
        <li><a href="<?php echo BG_URL_ROOT; ?>">首页</a></li>
        <li>TAG</li>
        <li><?php echo $this->tplData['tagRow']['tag_name']; ?></li>
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