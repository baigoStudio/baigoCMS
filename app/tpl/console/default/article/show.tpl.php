<?php
$cfg = array(
  'title'             => $lang->get('Article management', 'console.common') . ' &raquo; ' . $lang->get('Show'),
  'menu_active'       => 'article',
  'sub_active'        => 'index',
  'tooltip'           => 'true',
);

if ($is_ajax) { ?>
  <div class="modal-header">
    <div class="modal-title"><?php echo $cfg['title']; ?></div>
    <button type="button" class="close" data-dismiss="modal">&times;</button>
  </div>

  <div class="modal-body">
    <?php include($tpl_ctrl . 'head' . GK_EXT_TPL); ?>
  </div>

  <div class="modal-footer">
    <button type="button" class="btn btn-outline-secondary btn-sm" data-dismiss="modal">
      <?php echo $lang->get('Close', 'console.common'); ?>
    </button>
  </div>

<?php } else {

  if (!function_exists('custom_list_show')) {
    function custom_list_show($arr_customRows, $article_customs = array()) {
      if (!empty($arr_customRows)) {
        foreach ($arr_customRows as $key=>$value) {
          if (isset($value['custom_childs']) && empty($value['custom_childs'])) { ?>
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <div class="input-group-text">
                  <?php echo $value['custom_name']; ?>
                </div>
              </div>
              <input type="text" class="form-control bg-transparent" readonly value="<?php if (isset($article_customs['custom_' . $value['custom_id']])) { echo $article_customs['custom_' . $value['custom_id']]; } ?>">
            </div>
          <?php } else { ?>
            <h6>
              <span class="badge badge-secondary"><?php echo $value['custom_name']; ?></span>
            </h6>
          <?php }

          if (isset($value['custom_childs'])) {
            custom_list_show($value['custom_childs'], $article_customs);
          }
        }
      }
    }
  }

  include($tpl_include . 'console_head' . GK_EXT_TPL); ?>

  <div class="d-flex justify-content-between align-items-start">
    <ul class="nav mb-3">
      <li class="nav-item">
        <a href="<?php echo $hrefRow['index']; ?>" class="nav-link">
          <span class="bg-icon"><?php include($tpl_icon . 'chevron-left' . BG_EXT_SVG); ?></span>
          <?php echo $lang->get('Back'); ?>
        </a>
      </li>
      <?php include($tpl_ctrl . 'article_menu' . GK_EXT_TPL); ?>
    </ul>

    <?php if ($gen_open === true) { ?>
      <a href="#gen_modal" data-url="<?php echo $hrefRow['gen'], $articleRow['article_id']; ?>" data-toggle="modal" class="btn btn-outline-primary">
        <span class="bg-icon"><?php include($tpl_icon . 'sync-alt' . BG_EXT_SVG); ?></span>
        <?php echo $lang->get('Generate'); ?>
      </a>
    <?php } ?>
  </div>

  <div class="row">
    <div class="col-xl-9">
      <?php include($tpl_ctrl . 'head' . GK_EXT_TPL); ?>

      <div class="form-group text-right">
        <a href="<?php echo $hrefRow['edit'], $articleRow['article_id']; ?>">
          <span class="bg-icon"><?php include($tpl_icon . 'edit' . BG_EXT_SVG); ?></span>
          <?php echo $lang->get('Edit'); ?>
        </a>
      </div>
    </div>

    <div class="col-xl-3">
      <div class="card">
        <div class="card-header">
          <ul class="nav nav-tabs card-header-tabs">
            <li class="nav-item">
              <a class="nav-link active" data-toggle="tab" href="#tabs_base"><?php echo $lang->get('Base'); ?></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" data-toggle="tab" href="#tabs_more"><?php echo $lang->get('More'); ?></a>
            </li>
          </ul>
        </div>
        <div class="tab-content">
          <div class="tab-pane active" id="tabs_base">
            <div class="card-body border-bottom">
              <div class="form-group">
                <?php echo $lang->get('ID'); ?>: <?php echo $articleRow['article_id']; ?>
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
                <div class="form-text font-weight-bolder"><?php $str_status = $articleRow['article_status'];
                include($tpl_include . 'status_process' . GK_EXT_TPL); ?></div>
              </div>

              <div class="form-group">
                <label class="text-muted font-weight-light"><?php echo $lang->get('Position'); ?></label>
                <div class="form-text font-weight-bolder"><?php $str_status = $articleRow['article_box'];
                include($tpl_include . 'status_process' . GK_EXT_TPL); ?></div>
              </div>

              <div class="form-group">
                <label class="text-muted font-weight-light"><?php echo $lang->get('Mark'); ?></label>
                <div class="form-text font-weight-bolder">
                  <?php if (isset($markRow['mark_name'])) { echo $markRow['mark_name']; } ?>
                </div>
              </div>
            </div>

            <div class="accordion accordion-flush bg-form-accordion">
              <div class="accordion-item">
                <div class="accordion-header" id="heading-cover">
                  <button class="accordion-button collapsed" type="button" data-toggle="collapse" data-target="#bg-form-cover">
                    <?php echo $lang->get('Cover'); ?>
                  </button>
                </div>

                <div id="bg-form-cover" class="accordion-collapse collapse">
                  <div class="accordion-body">
                    <div class="form-group">
                      <div class="mb-2">
                        <?php if (isset($attachRow['attach_thumb']) && !empty($attachRow['attach_thumb'])) { ?>
                          <a data-toggle="modal" href="#modal_xl" data-href="<?php echo $hrefRow['attach-show'], $attachRow['attach_id']; ?>">
                            <img src="<?php echo $attachRow['attach_thumb']; ?>" class="img-fluid">
                          </a>
                        <?php } ?>
                      </div>

                      <small class="form-text"><?php if (isset($attachRow['attach_thumb']) && !empty($attachRow['attach_thumb'])) { echo $attachRow['attach_thumb']; } ?></small>
                    </div>
                  </div>
                </div>
              </div>

              <div class="accordion-item">
                <div class="accordion-header" id="heading-time">
                  <button class="accordion-button collapsed" type="button" data-toggle="collapse" data-target="#bg-form-time">
                    <?php echo $lang->get('Time'); ?>
                  </button>
                </div>

                <div id="bg-form-time" class="accordion-collapse collapse">
                  <div class="accordion-body">
                    <div class="form-group">
                      <label class="text-muted font-weight-light"><?php echo $lang->get('Display time'); ?></label>
                      <div class="form-text font-weight-bolder"><?php echo $articleRow['article_time_show_format']['date_time']; ?></div>
                    </div>

                    <div class="form-group">
                      <div class="custom-control custom-switch">
                        <input type="checkbox" <?php if ($articleRow['article_is_time_pub'] > 0) { ?>checked<?php } ?>  class="custom-control-input" disabled>
                        <label for="article_is_time_pub" class="custom-control-label">
                          <?php echo $lang->get('Scheduled publish'); ?>
                        </label>
                      </div>
                      <?php if ($articleRow['article_is_time_pub'] > 0) { ?>
                        <div class="form-text font-weight-bolder"><?php echo $articleRow['article_time_pub_format']['date_time']; ?></div>
                      <?php } ?>
                    </div>

                    <div class="form-group">
                      <div class="custom-control custom-switch">
                        <input type="checkbox" <?php if ($articleRow['article_is_time_hide'] > 0) { ?>checked<?php } ?>  class="custom-control-input" disabled>
                        <label for="article_is_time_hide" class="custom-control-label">
                          <?php echo $lang->get('Scheduled offline'); ?>
                        </label>
                      </div>
                      <?php if ($articleRow['article_is_time_hide'] > 0) { ?>
                        <div class="form-text font-weight-bolder"><?php echo $articleRow['article_time_hide_format']['date_time']; ?></div>
                      <?php } ?>
                    </div>
                  </div>
                </div>
              </div>

              <div class="accordion-item">
                <div class="accordion-header" id="heading-tag">
                  <button class="accordion-button collapsed" type="button" data-toggle="collapse" data-target="#bg-form-tag">
                    <?php echo $lang->get('Tag'); ?>
                  </button>
                </div>

                <div id="bg-form-tag" class="accordion-collapse collapse">
                  <div class="accordion-body">
                    <div class="bg-tag-list">
                      <?php foreach ($articleRow['article_tags'] as $key=>$value) { ?>
                        <div class="bg-tag-item"><?php echo $value; ?></div>
                      <?php } ?>
                    </div>
                  </div>
                </div>
              </div>

              <div class="accordion-item">
                <div class="accordion-header" id="heading-excerpt">
                  <button class="accordion-button collapsed" type="button" data-toggle="collapse" data-target="#bg-form-excerpt">
                    <?php echo $lang->get('Excerpt'); ?>
                  </button>
                </div>

                <div id="bg-form-excerpt" class="accordion-collapse collapse">
                  <div class="accordion-body">
                    <div class="form-text font-weight-bolder"><?php echo $articleRow['article_excerpt']; ?></div>
                  </div>
                </div>
              </div>

              <div class="accordion-item">
                <div class="accordion-header" id="heading-source">
                  <button class="accordion-button collapsed" type="button" data-toggle="collapse" data-target="#bg-form-source">
                    <?php echo $lang->get('Source'); ?>
                  </button>
                </div>

                <div id="bg-form-source" class="accordion-collapse collapse">
                  <div class="accordion-body">
                    <div class="form-group">
                      <label class="text-muted font-weight-light"><?php echo $lang->get('Source'); ?></label>
                      <div class="form-text font-weight-bolder"><?php echo $articleRow['article_source']; ?></div>
                    </div>

                    <div class="form-group">
                      <label class="text-muted font-weight-light"><?php echo $lang->get('Author'); ?></label>
                      <div class="form-text font-weight-bolder"><?php echo $articleRow['article_author']; ?></div>
                    </div>

                    <div class="form-group">
                      <label class="text-muted font-weight-light"><?php echo $lang->get('Source URL'); ?></label>
                      <div class="form-text font-weight-bolder"><?php echo $articleRow['article_source_url']; ?></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="tab-pane" id="tabs_more">
            <div class="card-body border-bottom">
              <div class="custom-control custom-switch">
                <input type="checkbox" <?php if ($articleRow['cate_ids_check'] > 0) { ?>checked<?php } ?> class="custom-control-input" disabled>
                <label for="cate_ids_check" class="custom-control-label">
                  <?php echo $lang->get('Attached to categories'); ?>
                </label>
              </div>

              <?php if ($articleRow['cate_ids_check'] > 0) { ?>
                <div>
                  <table class="bg-table">
                    <tbody>
                      <?php $cate_ids = $articleRow['article_cate_ids'];
                      $is_edit        = false;
                      include($tpl_include . 'cate_list_checkbox' . GK_EXT_TPL); ?>
                    </tbody>
                  </table>
                </div>
              <?php } ?>
            </div>

            <div class="accordion accordion-flush bg-form-accordion">
              <div class="accordion-item">
                <div class="accordion-header" id="heading-spec">
                  <button class="accordion-button collapsed" type="button" data-toggle="collapse" data-target="#bg-form-spec">
                    <?php echo $lang->get('Special topic'); ?>
                  </button>
                </div>

                <div id="bg-form-spec" class="accordion-collapse collapse">
                  <div class="accordion-body">
                    <div id="spec_list">
                      <?php foreach ($specRows as $key=>$value) { ?>
                        <div>
                          <span class="bg-icon text-success"><?php include($tpl_icon . 'check-circle' . BG_EXT_SVG); ?></span>
                          <a href="<?php echo $hrefRow['spec-show'], $value['spec_id']; ?>" target="_blank"><?php echo $value['spec_name']; ?></a>
                        </div>
                      <?php } ?>
                    </div>
                  </div>
                </div>
              </div>

              <div class="accordion-item">
                <div class="accordion-header" id="heading-custom">
                  <button class="accordion-button collapsed" type="button" data-toggle="collapse" data-target="#bg-form-custom">
                    <?php echo $lang->get('Custom fields'); ?>
                  </button>
                </div>

                <div id="bg-form-custom" class="accordion-collapse collapse">
                  <div class="accordion-body">
                    <?php if (isset($articleRow['article_customs'])) {
                      custom_list_show($customRows, $articleRow['article_customs']);
                    } ?>
                  </div>
                </div>
              </div>

              <div class="accordion-item">
                <div class="accordion-header" id="heading-link">
                  <button class="accordion-button<?php if (empty($articleRow['article_link'])) { ?> collapsed<?php } ?>" type="button" data-toggle="collapse" data-target="#bg-form-link">
                    <?php echo $lang->get('Jump to'); ?>
                  </button>
                </div>

                <div id="bg-form-link" class="accordion-collapse collapse<?php if (!empty($articleRow['article_link'])) { ?> show<?php } ?>">
                  <div class="accordion-body">
                    <div class="form-text font-weight-bolder"><?php echo $articleRow['article_link']; ?></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="card-footer text-right">
          <a href="<?php echo $hrefRow['edit'], $articleRow['article_id']; ?>">
            <span class="bg-icon"><?php include($tpl_icon . 'edit' . BG_EXT_SVG); ?></span>
            <?php echo $lang->get('Edit'); ?>
          </a>
        </div>
      </div>

      <?php if (!empty($articleRow['article_link'])) { ?>
        <div class="alert alert-warning mt-3">
          <span class="bg-icon"><?php include($tpl_icon . 'exclamation-triangle' . BG_EXT_SVG); ?></span>
          <?php echo $lang->get('Warning! This article is a hyperlink'); ?>
        </div>
      <?php } ?>
    </div>
  </div>

  <?php include($tpl_include . 'console_foot' . GK_EXT_TPL);

    include($tpl_include . 'modal_xl' . GK_EXT_TPL);

  include($tpl_include . 'html_foot' . GK_EXT_TPL);
}
