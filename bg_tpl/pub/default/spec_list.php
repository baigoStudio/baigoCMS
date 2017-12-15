<?php $cfg = array(
    'title'       => '专题',
    'str_url'     => $this->tplData['urlRow']['spec_url'] . $this->tplData['urlRow']['page_attach'],
    'str_urlMore' => $this->tplData['urlRow']['spec_urlMore'] . $this->tplData['urlRow']['page_attach'],
    'page_ext'    => $this->tplData['urlRow']['page_ext'],
);

include('include' . DS . 'pub_head.php'); ?>

    <ol class="breadcrumb">
        <li><a href="<?php echo BG_URL_ROOT; ?>">首页</a></li>
        <li>专题</li>
    </ol>

    <?php foreach ($this->tplData['specRows'] as $key=>$value) { ?>
        <h4><a href="<?php echo $value['urlRow']['spec_url']; ?>" target="_blank"><?php echo $value['spec_name']; ?></a></h4>
        <hr>
    <?php }

    include('include' . DS . 'page.php');

include('include' . DS . 'pub_foot.php');
include('include' . DS . 'html_foot.php'); ?>