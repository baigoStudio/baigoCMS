<?php $cfg = array(
  'title'             => $cateRow['cate_name'],
);

include($tpl_include . 'index_head' . GK_EXT_TPL);
  include($tpl_include . 'breadcrumb' . GK_EXT_TPL); ?>

  <h3><?php echo $cateRow['cate_name']; ?></h3>

  <?php foreach ($articleRows as $key=>$value) { ?>
    <h4><a href="<?php echo $value['article_url']; ?>" target="_blank"><?php echo $value['article_title']; ?></a></h4>
    <div><?php echo $value['article_time_show_format']['date_time']; ?></div>
    <hr>
    <ul class="list-inline">
      <li class="list-inline-item">
        Tags:
      </li>
      <?php if (isset($value['tagRows'])) {
        foreach ($value['tagRows'] as $tag_key=>$tag_value) { ?>
          <li class="list-inline-item">
            <a href="<?php echo $tag_value['tag_url']['url']; ?>" target="_blank"><?php echo $tag_value['tag_name']; ?></a>
          </li>
        <?php }
      } ?>
    </ul>
  <?php }

  include($tpl_include . 'pagination' . GK_EXT_TPL);

include($tpl_include . 'index_foot' . GK_EXT_TPL);
include($tpl_include . 'html_foot' . GK_EXT_TPL);
