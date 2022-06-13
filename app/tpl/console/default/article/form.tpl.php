<?php
if (!function_exists('custom_list_show')) {
  function custom_list_form($arr_customRows, $article_customs = array(), $lang = '') {
    if (!empty($arr_customRows)) {
      foreach ($arr_customRows as $key=>$value) {
        if (isset($value['custom_childs']) && !empty($value['custom_childs'])) { ?>
          <div class="custom_group custom_group_<?php echo $value['custom_cate_id']; ?>">
            <h5>
              <span class="badge badge-secondary"><?php echo $value['custom_name']; ?></span>
            </h5>
          </div>
          <?php custom_list_form($value['custom_childs'], $article_customs, $lang);
        } else { ?>
          <div class="custom_group custom_group_<?php echo $value['custom_cate_id']; ?> form-group">
            <label><?php echo $value['custom_name']; ?></label>

            <?php switch ($value['custom_type']) {
              case 'radio':
                foreach ($value['custom_opt'][$value['custom_type']] as $key_option=>$value_option) { ?>
                  <div class="form-check">
                    <label for="article_customs_<?php echo $value['custom_id']; ?>_<?php echo $key_option ; ?>" class="form-check-label">
                      <input type="radio" id="article_customs_<?php echo $value['custom_id']; ?>_<?php echo $key_option ; ?>" name="article_customs[<?php echo $value['custom_id']; ?>]" value="<?php echo $value_option ; ?>" data-validate="article_customs_<?php echo $value['custom_id']; ?>" <?php if (isset($article_customs['custom_' . $value['custom_id']]) && $article_customs['custom_' . $value['custom_id']] == $value_option) { ?> checked<?php } ?> class="form-check-input">
                      <?php echo $value_option ; ?>
                    </label>
                  </div>
                <?php }
              break;

              case 'select': ?>
                <select id="article_customs_<?php echo $value['custom_id']; ?>" name="article_customs[<?php echo $value['custom_id']; ?>]" class="form-control">
                  <option value=""><?php echo $lang->get('Please select'); ?></option>
                  <?php foreach ($value['custom_opt'][$value['custom_type']] as $key_option=>$value_option) { ?>
                    <option
                      <?php if (isset($article_customs['custom_' . $value['custom_id']]) && $article_customs['custom_' . $value['custom_id']] == $value_option) { ?>
                         selected
                      <?php } ?>
                       value="<?php echo $value_option ; ?>">
                        <?php echo $value_option ; ?>
                    </option>
                  <?php } ?>
                </select>
              <?php break;

              case 'textarea': ?>
                <textarea id="article_customs_<?php echo $value['custom_id']; ?>" name="article_customs[<?php echo $value['custom_id']; ?>]" class="form-control bg-textarea-md">
                  <?php if (isset($article_customs['custom_' . $value['custom_id']])) {
                      echo $article_customs['custom_' . $value['custom_id']];
                  } ?>
                </textarea>
              <?php break;

              default: ?>
                <input type="text" id="article_customs_<?php echo $value['custom_id']; ?>" name="article_customs[<?php echo $value['custom_id']; ?>]" value="<?php if (isset($article_customs['custom_' . $value['custom_id']])) { echo $article_customs['custom_' . $value['custom_id']];} ?>" class="form-control">
              <?php break;
            } ?>

            <small class="form-text" id="msg_article_custom_<?php echo $value['custom_id']; ?>"></small>
          </div>
        <?php }
      }
    }
  }
}

if ($articleRow['article_id'] > 0) {
  $title_sub    = $lang->get('Edit');
  $str_sub      = 'index';
} else {
  $title_sub    = $lang->get('Add');
  $str_sub      = 'form';
}

$cfg = array(
  'title'             => $lang->get('Article management', 'console.common') . ' &raquo; ' . $title_sub,
  'menu_active'       => 'article',
  'sub_active'        => $str_sub,
  'baigoValidate'     => 'true',
  'baigoSubmit'       => 'true',
  'baigoTag'          => 'true',
  'datetimepicker'    => 'true',
  'tinymce'           => 'true',
  'upload'            => 'true',
  'tooltip'           => 'true',
);

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

    <?php if ($articleRow['article_id'] > 0 && $gen_open === true) { ?>
      <a href="#gen_modal" data-url="<?php echo $hrefRow['gen'], $articleRow['article_id']; ?>" data-toggle="modal" class="btn btn-outline-primary">
        <span class="bg-icon"><?php include($tpl_icon . 'sync-alt' . BG_EXT_SVG); ?></span>
        <?php echo $lang->get('Generate'); ?>
      </a>
    <?php } ?>
  </div>

  <form name="article_form" id="article_form" action="<?php echo $hrefRow['submit']; ?>">
    <input type="hidden" name="<?php echo $token['name']; ?>" value="<?php echo $token['value']; ?>">
    <input type="hidden" name="article_id" id="article_id" value="<?php echo $articleRow['article_id']; ?>">

    <div class="row">
      <div class="col-xl-9">
        <div class="form-group">
          <input type="text" name="article_title" id="article_title" value="<?php echo $articleRow['article_title']; ?>" class="form-control form-control-lg" placeholder="<?php echo $lang->get('Title'); ?>">
          <small class="form-text" id="msg_article_title"></small>
        </div>

        <div class="form-group">
          <label><?php echo $lang->get('Content'); ?></label>
          <div class="mb-2">
            <div class="btn-group btn-group-sm">
              <a class="btn btn-outline-success" data-toggle="modal" href="#modal_xl" data-href="<?php echo $hrefRow['attach-choose'], $articleRow['article_id']; ?>">
                <span class="bg-icon"><?php include($tpl_icon . 'photo-video' . BG_EXT_SVG); ?></span>
                <?php echo $lang->get('Add media'); ?>
              </a>
              <a class="btn btn-outline-secondary" data-toggle="modal" href="#modal_xl" data-href="<?php echo $hrefRow['album-choose']; ?>">
                <span class="bg-icon"><?php include($tpl_icon . 'images' . BG_EXT_SVG); ?></span>
                <?php echo $lang->get('Add album'); ?>
              </a>
              <?php if ($articleRow['article_id'] > 0) { ?>
                <a href="<?php echo $hrefRow['attach'], $articleRow['article_id']; ?>" class="btn btn-outline-secondary">
                  <?php echo $lang->get('Cover management'); ?>
                </a>
              <?php } ?>
            </div>
          </div>
          <textarea name="article_content" id="article_content" class="form-control tinymce"><?php echo $articleRow['article_content']; ?></textarea>
        </div>

        <div class="bg-validate-box"></div>

        <div class="form-group">
          <button type="submit" class="btn btn-primary">
              <?php echo $lang->get('Save'); ?>
          </button>
        </div>
      </div>

      <div class="col-xl-3">
        <div class="card">
          <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs">
              <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#tabs_base">
                  <?php echo $lang->get('Base'); ?>
                  <span id="extra_msg_base"></span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#tabs_more">
                  <?php echo $lang->get('More'); ?>
                  <span id="extra_msg_more"></span>
                </a>
              </li>
            </ul>
          </div>
          <div class="tab-content">
            <div class="tab-pane active" id="tabs_base">
              <div class="card-body border-bottom">
                <?php if ($articleRow['article_id'] > 0) { ?>
                  <div class="form-group">
                    <?php echo $lang->get('ID'); ?>: <?php echo $articleRow['article_id']; ?>
                  </div>
                <?php } ?>

                <div class="form-group">
                  <label><?php echo $lang->get('Belong to category'); ?> <span class="text-danger">*</span></label>
                  <select name="article_cate_id" id="article_cate_id" class="form-control">
                    <option value=""><?php echo $lang->get('Please select'); ?></option>
                    <?php $check_id = $articleRow['article_cate_id'];
                    include($tpl_include . 'cate_list_option' . GK_EXT_TPL); ?>
                  </select>
                  <small class="form-text" id="msg_article_cate_id"></small>
                </div>

                <div class="form-group">
                  <label><?php echo $lang->get('Status'); ?> <span class="text-danger">*</span></label>
                  <div>
                    <?php foreach ($status as $key=>$value) { ?>
                      <div class="form-check form-check-inline">
                        <input type="radio" name="article_status" id="article_status_<?php echo $value; ?>" value="<?php echo $value; ?>" <?php if ($articleRow['article_status'] == $value) { ?>checked<?php } ?> class="form-check-input">
                        <label for="article_status_<?php echo $value; ?>" class="form-check-label">
                          <?php echo $lang->get($value); ?>
                        </label>
                      </div>
                    <?php } ?>
                  </div>
                  <small class="form-text" id="msg_article_status"></small>
                </div>

                <div class="form-group">
                  <label><?php echo $lang->get('Position'); ?> <span class="text-danger">*</span></label>
                  <div>
                    <?php foreach ($box as $key=>$value) { ?>
                      <div class="form-check form-check-inline">
                        <input type="radio" name="article_box" id="article_box_<?php echo $value; ?>" value="<?php echo $value; ?>" <?php if ($articleRow['article_box'] == $value) { ?>checked<?php } ?> class="form-check-input">
                        <label for="article_box_<?php echo $value; ?>" class="form-check-label">
                          <?php echo $lang->get($value); ?>
                        </label>
                      </div>
                    <?php } ?>
                  </div>
                  <small class="form-text" id="msg_article_box"></small>
                </div>

                <?php if ($gen_open === true) { ?>
                  <div class="form-group">
                    <label><?php echo $lang->get('Status'); ?> <span class="text-danger">*</span></label>
                    <div>
                      <?php foreach ($status_gen as $key=>$value) { ?>
                        <div class="form-check form-check-inline">
                          <input type="radio" name="article_is_gen" id="article_is_gen_<?php echo $value; ?>" value="<?php echo $value; ?>" <?php if ($articleRow['article_is_gen'] == $value) { ?>checked<?php } ?> class="form-check-input">
                          <label for="article_is_gen_<?php echo $value; ?>" class="form-check-label">
                            <?php echo $lang->get($value); ?>
                          </label>
                        </div>
                      <?php } ?>
                    </div>
                    <small class="form-text" id="msg_article_is_gen"></small>
                  </div>
                <?php } ?>

                <div class="form-group">
                  <div class="custom-control custom-switch">
                    <input type="checkbox" <?php if ($articleRow['article_top'] > 0) { ?>checked<?php } ?> id="article_top" name="article_top" value="1" class="custom-control-input">
                    <label for="article_top" class="custom-control-label">
                      <?php echo $lang->get('Sticky'); ?>
                    </label>
                  </div>
                </div>

                <div class="form-group">
                  <label><?php echo $lang->get('Mark'); ?></label>
                  <select name="article_mark_id" class="form-control">
                    <option value=""><?php echo $lang->get('None'); ?></option>
                    <?php foreach ($markRows as $key=>$value) { ?>
                      <option <?php if ($value['mark_id'] == $articleRow['article_mark_id']) { ?>selected<?php } ?> value="<?php echo $value['mark_id']; ?>"><?php echo $value['mark_name']; ?></option>
                    <?php } ?>
                  </select>
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
                        <div id="article_attach_img" class="mb-2">
                          <?php if (isset($attachRow['attach_thumb']) && !empty($attachRow['attach_thumb'])) { ?>
                            <a data-toggle="modal" href="#modal_xl" data-href="<?php echo $hrefRow['attach-show'], $attachRow['attach_id']; ?>">
                              <img src="<?php echo $attachRow['attach_thumb']; ?>" class="img-fluid">
                            </a>
                          <?php } ?>
                        </div>

                        <div class="input-group mb-3">
                          <input type="text" id="article_attach_src" readonly value="<?php if (isset($attachRow['attach_thumb']) && !empty($attachRow['attach_thumb'])) { echo $attachRow['attach_thumb']; } ?>" class="form-control">
                          <div class="input-group-append">
                            <button type="button" class="btn btn-outline-secondary" data-toggle="modal" data-target="#modal_xl" data-href="<?php echo $hrefRow['attach-cover'], $articleRow['article_id']; ?>">
                              <span class="bg-icon"><?php include($tpl_icon . 'image' . BG_EXT_SVG); ?></span>
                              <?php echo $lang->get('Select'); ?>
                            </button>
                          </div>
                        </div>

                        <input type="hidden" name="article_attach_id" id="article_attach_id" value="<?php echo $articleRow['article_attach_id']; ?>">
                      </div>
                    </div>
                  </div>
                </div>

                <div class="accordion-item">
                  <div class="accordion-header" id="heading-time">
                    <button class="accordion-button collapsed" type="button" data-toggle="collapse" data-target="#bg-form-time">
                      <span>
                        <?php echo $lang->get('Time'); ?>
                        <span id="extra_msg_time"></span>
                      </span>
                    </button>
                  </div>

                  <div id="bg-form-time" class="accordion-collapse collapse">
                    <div class="accordion-body">
                      <div class="form-group">
                        <label><?php echo $lang->get('Display time'); ?></label>
                        <input type="text" name="article_time_show_format" id="article_time_show_format" value="<?php echo $articleRow['article_time_show_format']['date_time']; ?>" class="form-control input_date">
                        <small class="form-text" id="msg_article_time_show_format"></small>
                      </div>

                      <div class="form-group">
                        <div class="custom-control custom-switch mb-2">
                          <input type="checkbox" <?php if ($articleRow['article_is_time_pub'] > 0) { ?>checked<?php } ?> name="article_is_time_pub" id="article_is_time_pub" value="1" class="custom-control-input">
                          <label for="article_is_time_pub" class="custom-control-label">
                            <?php echo $lang->get('Scheduled publish'); ?>
                          </label>
                        </div>
                        <div id="time_pub_input" class="collapse <?php if ($articleRow['article_is_time_pub'] > 0) { ?>show<?php } ?>">
                          <input type="text" name="article_time_pub_format" id="article_time_pub_format" value="<?php echo $articleRow['article_time_pub_format']['date_time']; ?>" class="form-control input_date">
                          <small class="form-text" id="msg_article_time_pub_format"></small>
                        </div>
                      </div>

                      <div class="form-group">
                        <div class="custom-control custom-switch mb-2">
                          <input type="checkbox" <?php if ($articleRow['article_is_time_hide'] > 0) { ?>checked<?php } ?> id="article_is_time_hide" name="article_is_time_hide" value="1" class="custom-control-input">
                          <label for="article_is_time_hide" class="custom-control-label">
                            <?php echo $lang->get('Scheduled offline'); ?>
                          </label>
                        </div>
                        <div id="time_hide_input" class="collapse <?php if ($articleRow['article_is_time_hide'] > 0) { ?>show<?php } ?>">
                          <input type="text" name="article_time_hide_format" id="article_time_hide_format" value="<?php echo $articleRow['article_time_hide_format']['date_time']; ?>" class="form-control input_date">
                          <small class="form-text" id="msg_article_time_hide_format"></small>
                        </div>
                      </div>

                      <small class="form-text">
                        <?php $_arr_langReplace = array(
                          'date_time' => date($config['var_extra']['base']['site_date'] . ' ' . $config['var_extra']['base']['site_time_short']),
                        );
                        echo $lang->get('Format: {:date_time}', '', $_arr_langReplace); ?>
                      </small>
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
                      <input type="text" name="article_tag" id="article_tag" class="form-control" placeholder="<?php echo $lang->get('Tags'); ?>">
                      <small class="form-text" id="msg_article_tag">
                        <?php $_arr_langReplace = array(
                          'tag_count'   => $config['var_extra']['visit']['count_tag'],
                        );
                        echo $lang->get('For multiple TAG, please use <kbd>,</kbd> to separate. Up to {:tag_count} tags', '', $_arr_langReplace); ?>
                      </small>
                    </div>
                  </div>
                </div>

                <div class="accordion-item">
                  <div class="accordion-header" id="heading-excerpt">
                    <button class="accordion-button collapsed" type="button" data-toggle="collapse" data-target="#bg-form-excerpt">
                      <span>
                        <?php echo $lang->get('Excerpt'); ?>
                        <span id="extra_msg_excerpt"></span>
                      </span>
                    </button>
                  </div>

                  <div id="bg-form-excerpt" class="accordion-collapse collapse">
                    <div class="accordion-body">
                      <div class="form-group">
                        <select class="form-control" name="article_excerpt_type" id="article_excerpt_type">
                          <?php foreach ($config['console']['excerpt'] as $key=>$value) { ?>
                            <option <?php if ($articleRow['article_excerpt_type'] == $key) { ?>selected<?php } ?> value="<?php echo $key; ?>">
                              <?php echo $lang->get($value); ?>
                            </option>
                          <?php } ?>
                        </select>
                      </div>

                      <div id="group_article_excerpt" class="collapse <?php if ($articleRow['article_excerpt_type'] == 'manual') { ?>show<?php } ?>">
                        <div class="form-group">
                          <textarea name="article_excerpt" id="article_excerpt" class="form-control bg-textarea-sm"><?php echo $articleRow['article_excerpt']; ?></textarea>
                        </div>
                      </div>
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
                        <label><?php echo $lang->get('Source'); ?></label>
                        <input type="text" name="article_source" id="article_source" value="<?php echo $articleRow['article_source']; ?>" class="form-control">
                        <small class="form-text" id="msg_article_source"></small>
                      </div>

                      <div class="form-group">
                        <label><?php echo $lang->get('Author'); ?></label>
                        <input type="text" name="article_author" id="article_author" value="<?php echo $articleRow['article_author']; ?>" class="form-control">
                        <small class="form-text" id="msg_article_author"></small>
                      </div>

                      <div class="form-group">
                        <label><?php echo $lang->get('Source URL'); ?></label>
                        <textarea type="text" name="article_source_url" id="article_source_url" class="form-control bg-textarea-sm"><?php echo $articleRow['article_source_url']; ?></textarea>
                        <small class="form-text" id="msg_article_source"></small>
                      </div>

                      <div class="form-group">
                        <label><?php echo $lang->get('Common source'); ?></label>
                        <select id="article_source_often" class="form-control">
                          <option value=""><?php echo $lang->get('Please select'); ?></option>
                          <?php foreach ($sourceRows as $key=>$value) { ?>
                            <option value="<?php echo $value['source_id']; ?>"><?php echo $value['source_name']; ?></option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="tab-pane" id="tabs_more">
              <div class="card-body border-bottom">
                <div class="custom-control custom-switch">
                  <input type="checkbox" <?php if ($articleRow['cate_ids_check'] > 0) { ?>checked<?php } ?> id="cate_ids_check" name="cate_ids_check" value="1" class="custom-control-input">
                  <label for="cate_ids_check" class="custom-control-label">
                    <?php echo $lang->get('Attached to categories'); ?>
                  </label>
                </div>

                <div id="group_cate_ids" class="collapse <?php if ($articleRow['cate_ids_check'] > 0) { ?>show<?php } ?>">
                  <table class="bg-table">
                    <tbody>
                      <?php $cate_ids = $articleRow['article_cate_ids'];
                      $form_name = 'article';
                      include($tpl_include . 'cate_list_checkbox' . GK_EXT_TPL); ?>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="accordion accordion-flush">
                <?php if ($gen_open === true) { ?>
                  <div class="accordion-item">
                    <div class="accordion-header" id="heading-tpl">
                      <button class="accordion-button collapsed" type="button" data-toggle="collapse" data-target="#bg-form-tpl">
                        <?php echo $lang->get('Template'); ?>
                      </button>
                    </div>

                    <div id="bg-form-tpl" class="accordion-collapse collapse">
                      <div class="accordion-body">
                        <select name="article_tpl" id="article_tpl" class="form-control">
                          <option <?php if (isset($articleRow['article_tpl']) && $articleRow['article_tpl'] == '-1') { ?>selected<?php } ?> value="-1"><?php echo $lang->get('Inherit'); ?></option>
                          <?php foreach ($tplRows as $key=>$value) {
                            if ($value['type'] == 'file') { ?>
                              <option <?php if ($articleRow['article_tpl'] == $value['name_s']) { ?>selected<?php } ?> value="<?php echo $value['name_s']; ?>">
                                <?php echo $value['name_s']; ?>
                              </option>
                            <?php }
                          } ?>
                        </select>
                        <small class="form-text" id="msg_article_tpl"></small>
                      </div>
                    </div>
                  </div>
                <?php } ?>

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
                          <div class="input-group mb-2" id="spec_item_<?php echo $value['spec_id']; ?>">
                            <div class="input-group-prepend">
                              <div class="input-group-text border-success">
                                <input type="hidden" name="article_spec_ids[]" value="<?php echo $value['spec_id']; ?>">
                                <span class="bg-icon text-primary"><?php include($tpl_icon . 'check-circle' . BG_EXT_SVG); ?></span>
                              </div>
                            </div>
                            <input type="text" class="form-control border-success bg-transparent" readonly value="<?php echo $value['spec_name']; ?>">
                            <div class="input-group-append">
                              <button type="button" class="btn btn-success spec_del" data-id="<?php echo $value['spec_id']; ?>">
                                <span class="bg-icon"><?php include($tpl_icon . 'trash-alt' . BG_EXT_SVG); ?></span>
                              </button>
                            </div>
                          </div>
                        <?php } ?>
                      </div>
                      <input type="text" id="spec_key" name="spec_key" placeholder="<?php echo $lang->get('Keyword'); ?>" class="form-control">
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
                      <div id="custom_list">
                        <?php custom_list_form($customRows, $articleRow['article_customs'], $lang); ?>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="accordion-item">
                  <div class="accordion-header" id="heading-link">
                    <button class="accordion-button<?php if (empty($articleRow['article_link'])) { ?> collapsed<?php } ?>" type="button" data-toggle="collapse" data-target="#bg-form-link">
                      <span>
                        <?php echo $lang->get('Jump to'); ?>
                        <span id="extra_msg_link"></span>
                      </span>
                    </button>
                  </div>

                  <div id="bg-form-link" class="accordion-collapse collapse<?php if (!empty($articleRow['article_link'])) { ?> show<?php } ?>">
                    <div class="accordion-body">
                      <textarea type="text" name="article_link" id="article_link" class="form-control bg-textarea-sm"><?php echo $articleRow['article_link']; ?></textarea>
                      <small class="form-text" id="msg_article_link"></small>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer">
            <button type="submit" class="btn btn-primary">
              <?php echo $lang->get('Save'); ?>
            </button>
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
  </form>

<?php include($tpl_include . 'console_foot' . GK_EXT_TPL);

  include($tpl_include . 'modal_xl' . GK_EXT_TPL); ?>

  <script type="text/javascript">
  var sourceJson = <?php echo $sourceJson; ?>;

  var opts_validate_form = {
    rules: {
      article_cate_id: {
        require: true
      },
      article_title: {
        length: '1,300'
      },
      article_excerpt: {
        max: 900
      },
      article_status: {
        require: true
      },
      article_box: {
        require: true
      },
      article_link: {
        max: 900
      },
      article_time_show_format: {
        format: 'date_time'
      },
      article_time_pub_format: {
        format: 'date_time'
      },
      article_time_hide_format: {
        format: 'date_time'
      }
    },
    attr_names: {
      article_cate_id: '<?php echo $lang->get('Belong to category'); ?>',
      article_title: '<?php echo $lang->get('Title'); ?>',
      article_excerpt: '<?php echo $lang->get('Excerpt'); ?>',
      article_status: '<?php echo $lang->get('Status'); ?>',
      article_box: '<?php echo $lang->get('Position'); ?>',
      article_link: '<?php echo $lang->get('Jump to'); ?>',
      article_time_show_format: '<?php echo $lang->get('Display time'); ?>',
      article_time_pub_format: '<?php echo $lang->get('Scheduled publish'); ?>',
      article_time_hide_format: '<?php echo $lang->get('Scheduled offline'); ?>'
    },
    type_msg: {
      require: '<?php echo $lang->get('{:attr} require'); ?>',
      max: '<?php echo $lang->get('Max size of {:attr} must be {:rule}'); ?>',
      length: '<?php echo $lang->get('Size of {:attr} must be {:rule}'); ?>'
    },
    format_msg: {
      date_time: '<?php echo $lang->get('{:attr} not a valid datetime'); ?>'
    },
    extra_boxes: {
      article_cate_id: '#extra_msg_base',
      article_excerpt: '#extra_msg_base,#extra_msg_excerpt',
      article_status: '#extra_msg_base',
      article_box: '#extra_msg_base',
      article_link: '#extra_msg_more,#extra_msg_link',
      article_time_show_format: '#extra_msg_base,#extra_msg_time',
      article_time_pub_format: '#extra_msg_base,#extra_msg_time',
      article_time_hide_format: '#extra_msg_base,#extra_msg_time'
    },
    box: {
      msg: '<?php echo $lang->get('Input error'); ?>'
    }
  };

  function customProcess(cate_id) {
    $('.custom_group').hide();
    $('.custom_group_0').show();
    $('.custom_group_' + cate_id).show();
  }

  function excerptProcess(excerpt_type) {
    if (excerpt_type == 'manual') {
      $('#group_article_excerpt').collapse('show');
    } else {
      $('#group_article_excerpt').collapse('hide');
    }
  }

  function cateIdsProcess(is_checked) {
    if (is_checked) {
      $('#group_cate_ids').collapse('show');
    } else {
      $('#group_cate_ids').collapse('hide');
    }
  }

  function timePub(is_checked) {
    if (is_checked) {
      $('#time_pub_input').collapse('show');
    } else {
      $('#time_pub_input').collapse('hide');
    }
  }

  function timeHide(is_checked) {
    if (is_checked) {
      $('#time_hide_input').collapse('show');
    } else {
      $('#time_hide_input').collapse('hide');
    }
  }

  function specAdd(spec_id, spec_name) {
    if ($('#spec_item_' + spec_id).length < 1) {
      var _spec_list_html = '<div class="input-group mb-2" id="spec_item_' + spec_id + '">' +
        '<div class="input-group-prepend">' +
          '<div class="input-group-text border-success">' +
            '<input type="hidden" name="article_spec_ids[]" value="' + spec_id + '">' +
            '<span class="bg-icon text-primary"><?php include($tpl_icon . 'check-circle' . BG_EXT_SVG); ?></span>' +
          '</div>' +
        '</div>' +
        '<input type="text" class="form-control border-success bg-transparent" readonly value="' + spec_name + '">' +
        '<div class="input-group-append">' +
          '<button type="button" class="btn btn-success spec_del" data-id="' + spec_id + '">' +
            '<span class="bg-icon"><?php include($tpl_icon . 'trash-alt' . BG_EXT_SVG); ?></span>' +
          '</button>' +
        '</div>' +
      '</div>';

      $('#spec_list').append(_spec_list_html);
    }
  }

  function specDel(id) {
    $('#spec_item_' + id).remove();
  }

  $(document).ready(function(){
    $('#article_excerpt_type').change(function(){
      var _excerpt_type = $(this).val();

      excerptProcess(_excerpt_type);
    });

    customProcess('<?php echo $articleRow['article_cate_id']; ?>');

    $('#article_cate_id').change(function(){
      var _cate_id = $(this).val();
      customProcess(_cate_id);
    });

    opts_submit['replaces'] = 'article_id';

    var obj_validate_form   = $('#article_form').baigoValidate(opts_validate_form);
    var obj_submit_form     = $('#article_form').baigoSubmit(opts_submit);

    $('#article_form').submit(function(){
      if (obj_validate_form.verify()) {
        tinyMCE.triggerSave();
        obj_submit_form.formSubmit();
      }
    });

    $('.input_date').datetimepicker(opts_datetimepicker);

    $('#article_is_time_pub').click(function(){
      var _is_checked = $(this).prop('checked');
      timePub(_is_checked);
    });

    $('#article_is_time_hide').click(function(){
      var _is_checked = $(this).prop('checked');
      timeHide(_is_checked);
    });

    $('#cate_ids_check').click(function(){
      var _is_checked = $(this).prop('checked');
      cateIdsProcess(_is_checked);
    });

    $('#article_source_often').change(function(){
      var _source_id = $(this).val();
      $('#article_source').val(sourceJson[_source_id].source_name);
      $('#article_source_url').val(sourceJson[_source_id].source_url);
      $('#article_author').val(sourceJson[_source_id].source_author);
    });

    var _obj_tag = $('#article_tag').baigoTag({
      maxTags: <?php echo $config['var_extra']['visit']['count_tag']; ?>,
      remote: {
        url: '<?php echo $hrefRow['tag-typeahead']; ?>%KEY',
        wildcard: '%KEY'
      }
    });

    _obj_tag.add(<?php echo $articleRow['article_tags_json']; ?>);

    var specsData = new Bloodhound({
      datumTokenizer: Bloodhound.tokenizers.whitespace,
      queryTokenizer: Bloodhound.tokenizers.whitespace,
      remote: {
        url: '<?php echo $hrefRow['spec-typeahead']; ?>%KEY',
        wildcard: '%KEY'
      }
    });

    specsData.initialize();

    var _obj_spec = $('#spec_key').typeahead(
      {
        highlight: true
      },
      {
        source: specsData.ttAdapter(),
        display: 'spec_name'
      }
    );

    _obj_spec.bind('typeahead:select', function(ev, suggestion) {
      specAdd(suggestion.spec_id, suggestion.spec_name);
      $('#spec_key').typeahead('val', '');
    });

    $('#spec_list').on('click', '.spec_del', function(){
      var _id  = $(this).data('id');
      specDel(_id);
    });
  });
  </script>

<?php include($tpl_include . 'html_foot' . GK_EXT_TPL);
