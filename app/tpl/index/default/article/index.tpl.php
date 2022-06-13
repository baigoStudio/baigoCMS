<?php $cfg = array(
  'title'             => $articleRow['article_title'],
);

include($tpl_include . 'index_head' . GK_EXT_TPL);
  include($tpl_include . 'breadcrumb' . GK_EXT_TPL); ?>

  <div class="card mb-3">
    <div class="card-body bg-content">
      <h3><?php echo $articleRow['article_title']; ?></h3>

      <div><?php echo $articleRow['article_content']; ?></div>

      <ul class="list-inline">
        <li class="list-inline-item">
          Tags:
        </li>
        <?php if (isset($tagRows)) {
          foreach ($tagRows as $tag_key=>$tag_value) { ?>
            <li class="list-inline-item">
              <a href="<?php echo $tag_value['tag_url']['url']; ?>" target="_blank"><?php echo $tag_value['tag_name']; ?></a>
            </li>
          <?php }
        } ?>
      </ul>
    </div>
  </div>

<?php include($tpl_include . 'index_foot' . GK_EXT_TPL);
include($tpl_include . 'html_foot' . GK_EXT_TPL);
