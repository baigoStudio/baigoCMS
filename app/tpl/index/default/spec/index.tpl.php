<?php $cfg = array(
  'title'             => '专题',
);

include($tpl_include . 'index_head' . GK_EXT_TPL); ?>

  <?php foreach ($specRows as $key=>$value) { ?>
    <h4><a href="<?php echo $value['spec_url']['url']; ?>" target="_blank"><?php echo $value['spec_name']; ?></a></h4>
  <?php }

  include($tpl_include . 'pagination' . GK_EXT_TPL);

include($tpl_include . 'index_foot' . GK_EXT_TPL);
include($tpl_include . 'html_foot' . GK_EXT_TPL);
