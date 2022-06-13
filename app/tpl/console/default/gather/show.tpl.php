<?php $cfg = array(
  'title'             => $lang->get('Gathering', 'console.common') . ' &raquo; ' . $lang->get('Show'),
  'menu_active'       => 'gather',
  'sub_active'        => 'approve',
  'tooltip'           => 'true',
);

include($tpl_include . 'console_head' . GK_EXT_TPL); ?>

  <nav class="nav mb-3">
    <a href="<?php echo $hrefRow['index']; ?>" class="nav-link">
      <span class="bg-icon"><?php include($tpl_icon . 'chevron-left' . BG_EXT_SVG); ?></span>
      <?php echo $lang->get('Back'); ?>
    </a>
  </nav>

  <div class="row">
    <div class="col-xl-9">
      <div class="card">
        <div class="card-body">
          <div class="form-group">
            <h3><?php echo $gatherRow['gather_title']; ?></h3>
          </div>

          <div class="form-group">
            <div class="text-wrap text-break bg-content"><?php echo $gatherRow['gather_content']; ?></div>
          </div>
        </div>

        <div class="card-footer d-flex justify-content-between">
          <div class="btn-group mr-3">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#store_modal" data-id="<?php echo $gatherRow['gather_id']; ?>"><?php echo $lang->get('Store'); ?></button>
            <button type="button" class="btn btn-outline-primary" data-target="#store_modal" data-toggle="modal" data-id="<?php echo $gatherRow['gather_id']; ?>" data-enforce="enforce"><?php echo $lang->get('Store enforce'); ?></button>
          </div>

          <a href="<?php echo $hrefRow['article-add'], $gatherRow['gather_id']; ?>">
            <span class="bg-icon"><?php include($tpl_icon . 'edit' . BG_EXT_SVG); ?></span>
            <?php echo $lang->get('Edit and store'); ?>
          </a>
        </div>
      </div>
    </div>

    <div class="col-xl-3">
      <div class="card bg-light">
        <div class="card-body">
          <div class="form-group">
            <label class="text-muted font-weight-light"><?php echo $lang->get('ID'); ?></label>
            <div class="form-text font-weight-bolder"><?php echo $gatherRow['gather_id']; ?></div>
          </div>

          <div class="form-group">
            <label class="text-muted font-weight-light"><?php echo $lang->get('Belong to category'); ?></label>
            <div class="form-text font-weight-bolder">
              <?php if (isset($cateRow['cate_name'])) {
                $str_cateBeadcrumb = '';

                if (isset($cateRow['cate_breadcrumb'])) {
                  foreach ($cateRow['cate_breadcrumb'] as $key_cate=>$value_cate) {
                    $str_cateBeadcrumb .= $value_cate['cate_name'];

                    if ($value_cate['cate_end'] < 1) {
                      $str_cateBeadcrumb .= ' &raquo; ';
                    }
                  }
                } ?>
                <a href="<?php echo $hrefRow['cate-show'], $cateRow['cate_id']; ?>" data-toggle="tooltip" data-placement="bottom" title="<?php echo $str_cateBeadcrumb; ?>" target="_blank">
                  <?php echo $cateRow['cate_name']; ?>
                </a>
              <?php } ?>
            </div>
          </div>

          <div class="form-group">
            <label class="text-muted font-weight-light"><?php echo $lang->get('Status'); ?></label>
            <div class="form-text font-weight-bolder"><?php $str_status = $gatherRow['gather_status'];
              include($tpl_include . 'status_process' . GK_EXT_TPL); ?></div>
          </div>

          <div class="form-group">
            <label class="text-muted font-weight-light"><?php echo $lang->get('Article ID'); ?></label>
            <div class="form-text font-weight-bolder"><?php echo $gatherRow['gather_article_id']; ?></div>
          </div>

          <div class="form-group">
            <label class="text-muted font-weight-light"><?php echo $lang->get('Display time'); ?></label>
            <div class="form-text font-weight-bolder"><?php echo $gatherRow['gather_time_show_format']['date_time']; ?></div>
          </div>

          <div class="form-group">
            <label class="text-muted font-weight-light"><?php echo $lang->get('Source'); ?></label>
            <div class="form-text font-weight-bolder"><?php echo $gatherRow['gather_source']; ?></div>
          </div>

          <div class="form-group">
            <label class="text-muted font-weight-light"><?php echo $lang->get('Author'); ?></label>
            <div class="form-text font-weight-bolder"><?php echo $gatherRow['gather_author']; ?></div>
          </div>

          <div class="form-group">
            <label class="text-muted font-weight-light"><?php echo $lang->get('Source URL'); ?></label>
            <div class="form-text font-weight-bolder">
              <a href="<?php echo $gatherRow['gather_source_url']; ?>" target="_blank"><?php echo $gatherRow['gather_source_url']; ?></a>
            </div>
          </div>
        </div>
        <div class="card-footer text-right">
          <a href="<?php echo $hrefRow['article-add'], $gatherRow['gather_id']; ?>">
            <span class="bg-icon"><?php include($tpl_icon . 'edit' . BG_EXT_SVG); ?></span>
            <?php echo $lang->get('Edit and store'); ?>
          </a>
        </div>
      </div>
    </div>
  </div>

<?php include($tpl_include . 'console_foot' . GK_EXT_TPL);

  include($tpl_ctrl . 'gather_foot' . GK_EXT_TPL);

include($tpl_include . 'html_foot' . GK_EXT_TPL);
