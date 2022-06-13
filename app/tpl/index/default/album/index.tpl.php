<?php $cfg = array(
  'title'         => '相册',
  'imageAsync'    => 'true',
);

include($tpl_include . 'index_head' . GK_EXT_TPL); ?>

  <div class="card-columns">
    <?php foreach ($albumRows as $key=>$value) { ?>
      <div class="card">
        <a href="<?php echo $value['album_url']['url']; ?>" target="_blank">
          <img src="{:DIR_STATIC}image/loading.gif" data-src="<?php echo $value['thumb_default']; ?>" data-toggle="async" alt="<?php echo $value['album_name']; ?>" class="card-img-top" id="img_<?php echo $value['album_id']; ?>">
        </a>
        <div class="card-body">
          <a href="<?php echo $value['album_url']['url']; ?>" target="_blank">
            <?php echo $value['album_name']; ?>
          </a>
        </div>
      </div>
    <?php } ?>
  </div>

  <?php include($tpl_include . 'pagination' . GK_EXT_TPL);

include($tpl_include . 'index_foot' . GK_EXT_TPL);
include($tpl_include . 'html_foot' . GK_EXT_TPL);
