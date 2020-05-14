<?php $cfg = array(
    'title'             => '专题',
    'pathInclude'       => $path_tpl . 'include' . DS,
);

include($cfg['pathInclude'] . 'index_head' . GK_EXT_TPL); ?>

    <?php foreach ($specRows as $key=>$value) { ?>
        <h4><a href="<?php echo $value['spec_url']['url']; ?>" target="_blank"><?php echo $value['spec_name']; ?></a></h4>
    <?php }

    include($cfg['pathInclude'] . 'pagination' . GK_EXT_TPL);

include($cfg['pathInclude'] . 'index_foot' . GK_EXT_TPL);
include($cfg['pathInclude'] . 'html_foot' . GK_EXT_TPL);