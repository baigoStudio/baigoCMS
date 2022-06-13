<?php $cfg = array(
  'title'          => $lang->get('Gathering', 'console.common') . ' &raquo; ' . $lang->get('Gathering site', 'console.common'),
  'menu_active'    => 'gather',
  'sub_active'     => 'gsite',
  'help'           => 'step_content',
  'baigoValidate'  => 'true',
  'baigoSubmit'    => 'true',
  'selectInput'    => 'true',
);

include($tpl_include . 'console_head' . GK_EXT_TPL);
  include($tpl_include . 'gsite_head' . GK_EXT_TPL); ?>

  <form name="gsite_form" id="gsite_form" action="<?php echo $hrefRow['content-submit']; ?>">
    <input type="hidden" name="<?php echo $token['name']; ?>" value="<?php echo $token['value']; ?>">
    <input type="hidden" name="gsite_id" id="gsite_id" value="<?php echo $gsiteRow['gsite_id']; ?>">

    <div class="row">
      <div class="col-xl-9">
        <div class="card mb-3">
          <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs">
              <?php foreach ($configContent as $key=>$value) {
                if (isset($value['base'])) { ?>
                  <li class="nav-item">
                    <a class="nav-link<?php if (isset($value['show'])) { ?> active<?php } ?>" data-toggle="tab" href="#tabs_<?php echo $key; ?>">
                      <?php echo $lang->get($value['title']); ?>
                      <span id="extra_msg_<?php echo $key; ?>"></span>
                    </a>
                  </li>
                <?php }
              } ?>
              <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#tabs_filter">
                  <?php echo $lang->get('Filter'); ?>
                  <span id="extra_msg_filter"></span>
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
            <?php foreach ($configContent as $key=>$value) {
              if (isset($value['base'])) { ?>
                <div class="tab-pane<?php if (isset($value['show'])) { ?> active<?php } ?>" id="tabs_<?php echo $key; ?>">
                  <div class="card-body">
                    <?php include($tpl_ctrl . 'gsite_form' . GK_EXT_TPL); ?>
                  </div>
                </div>
              <?php }
            } ?>
            <div class="tab-pane" id="tabs_filter">
              <div class="card-body">
                <p><?php echo $lang->get('The following parameters are only for the content, all HTML attributes will be removed by default'); ?></p>

                <div class="form-group">
                  <label><?php echo $lang->get('Retained tags'); ?></label>
                  <div class="input-group">
                    <span class="input-group-prepend">
                      <a href="#keep_tag_modal" class="btn btn-warning" data-toggle="modal">
                        <span class="bg-icon"><?php include($tpl_icon . 'question-circle' . BG_EXT_SVG); ?></span>
                      </a>
                    </span>
                    <input type="text" name="gsite_keep_tag" id="gsite_keep_tag" value="<?php echo $gsiteRow['gsite_keep_tag']; ?>" class="form-control">
                  </div>
                  <small class="form-text" id="msg_gsite_keep_tag">
                    <?php echo $lang->get('All tags in the content will be removed, except the default retained tags. Please enter other tags to be retained here. Multiple tags should be separated by <kbd>,</kbd>'); ?>
                  </small>
                </div>

                <div class="form-group">
                  <label><?php echo $lang->get('Attribute of image source'); ?></label>
                  <input type="text" name="gsite_img_src" id="gsite_img_src" value="<?php echo $gsiteRow['gsite_img_src']; ?>" class="form-control">
                  <small class="form-text" id="msg_gsite_img_src"><?php echo $lang->get('Default is <code>src</code>'); ?></small>
                </div>

                <div class="form-group">
                  <label><?php echo $lang->get('Filter image'); ?></label>
                  <input type="text" name="gsite_img_filter" id="gsite_img_filter" value="<?php echo $gsiteRow['gsite_img_filter']; ?>" class="form-control">
                  <small class="form-text" id="msg_gsite_img_filter"><?php echo $lang->get('Filter out images with these keywords in the path. Separate multiple keywords with <kbd>,</kbd>'); ?></small>
                </div>

                <div class="form-group">
                  <label><?php echo $lang->get('Retained attributes'); ?></label>
                  <input type="text" name="gsite_attr_allow" id="gsite_attr_allow" value="<?php echo $gsiteRow['gsite_attr_allow']; ?>" class="form-control">
                  <small class="form-text" id="msg_gsite_attr_allow">
                    <?php echo $lang->get('These attributes will be retained, and multiple attributes should be separated by <kbd>,</kbd>'); ?>
                  </small>
                </div>

                <div class="form-group">
                  <label><?php echo $lang->get('Ignore tags'); ?></label>
                  <input type="text" name="gsite_ignore_tag" id="gsite_ignore_tag" value="<?php echo $gsiteRow['gsite_ignore_tag']; ?>" class="form-control">
                  <small class="form-text" id="msg_gsite_ignore_tag">
                    <?php echo $lang->get('All attributes of these tags will be retained, and multiple tags should be separated by <kbd>,</kbd>'); ?>
                  </small>
                </div>

                <label>
                  <?php echo $lang->get('Exception'); ?>
                  <a href="#keep_attr_modal" data-toggle="modal">
                    <span class="bg-icon"><?php include($tpl_icon . 'question-circle' . BG_EXT_SVG); ?></span>
                  </a>
                </label>

                <div id="attr_except">
                  <?php foreach ($gsiteRow['gsite_attr_except'] as $key_attr_except=>$value_attr_except) { ?>
                    <div id="attr_except_group_<?php echo $key_attr_except; ?>" class="form-row" data-count="<?php echo $key_attr_except; ?>">
                      <div class="form-group col-md-4">
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text"><?php echo $lang->get('Tag'); ?></span>
                          </div>
                          <input type="text" name="gsite_attr_except[<?php echo $key_attr_except; ?>][tag]" id="gsite_attr_except_<?php echo $key_attr_except; ?>_tag" value="<?php echo $value_attr_except['tag']; ?>" class="form-control">
                        </div>
                      </div>
                      <div class="form-group col-md-8">
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text"><?php echo $lang->get('Attributes'); ?></span>
                          </div>
                          <input type="text" name="gsite_attr_except[<?php echo $key_attr_except; ?>][attr]" id="gsite_attr_except_<?php echo $key_attr_except; ?>_attr" value="<?php echo $value_attr_except['attr']; ?>" class="form-control">
                          <span class="input-group-append">
                            <button type="button" data-count="<?php echo $key_attr_except; ?>" class="btn btn-info except_del">
                              <span class="bg-icon"><?php include($tpl_icon . 'trash-alt' . BG_EXT_SVG); ?></span>
                            </button>
                          </span>
                        </div>
                      </div>
                    </div>
                  <?php } ?>
                </div>

                <div class="form-group">
                  <button type="button" id="attr_except_add" class="btn btn-info">
                    <span class="bg-icon"><?php include($tpl_icon . 'plus' . BG_EXT_SVG); ?></span>
                  </button>
                </div>

                <small class="form-text">
                  <?php echo $lang->get('The specific attributes of these tags will be retained, and multiple attributes under the same tag should be separated by <kbd>,</kbd>'); ?>
                </small>
              </div>
            </div>
            <div class="tab-pane" id="tabs_more">
              <div class="accordion accordion-flush bg-form-accordion" id="bg-step-content">
                <?php foreach ($configContent as $key=>$value) {
                  if (isset($value['more'])) { ?>
                    <div class="accordion-item">
                      <div class="accordion-header" id="heading-<?php echo $key; ?>">
                        <button class="accordion-button<?php if (!isset($value['show'])) { ?> collapsed<?php } ?>" type="button" data-toggle="collapse" data-target="#bg-form-<?php echo $key; ?>">
                          <?php echo $lang->get($value['title']); ?>
                        </button>
                      </div>

                      <div id="bg-form-<?php echo $key; ?>" class="accordion-collapse collapse<?php if (isset($value['show'])) { ?> show<?php } ?>" data-parent="#bg-step-content">
                        <div class="accordion-body">
                          <?php include($tpl_ctrl . 'gsite_form' . GK_EXT_TPL); ?>
                        </div>
                      </div>
                    </div>
                  <?php }
                } ?>
              </div>
            </div>
          </div>

          <div class="card-footer">
            <div class="bg-validate-box"></div>

            <button type="submit" class="btn btn-primary"><?php echo $lang->get('Save'); ?></button>
          </div>
        </div>

        <div class="card mt-3">
          <div class="card-header py-2"><?php echo $lang->get('Preview'); ?></div>
          <div id="gsite_preview">
            <div class="loading p-3">
              <h4 class="text-info">
                <span class="spinner-grow"></span>
                Loading...
              </h4>
            </div>
          </div>
        </div>

        <div class="card mt-3">
          <div class="card-header py-2"><?php echo $lang->get('Source code'); ?></div>
          <div id="gsite_source">
            <div class="loading p-3">
              <h4 class="text-info">
                <span class="spinner-grow"></span>
                Loading...
              </h4>
            </div>
          </div>
        </div>
      </div>

      <?php include($tpl_include . 'gsite_side' . GK_EXT_TPL); ?>
    </div>
  </form>

<?php include($tpl_include . 'console_foot' . GK_EXT_TPL);

  include($tpl_include . 'gsite_foot' . GK_EXT_TPL); ?>

  <script type="text/javascript">
  var opts_validate_form = {
    rules: {
      <?php foreach ($configContent as $key=>$value) {
        if (isset($value['require'])) {
          $str_rule = '1';
        } else {
          $str_rule = '0';
        } ?>
        gsite_<?php echo $key; ?>_selector: {
          length: '<?php echo $str_rule; ?>,100'
        },
        gsite_<?php echo $key; ?>_attr: {
          max: 100
        },
        gsite_<?php echo $key; ?>_filter: {
          max: 100
        },
      <?php } ?>
      gsite_keep_tag: {
        max: 300
      },
      gsite_img_filter: {
        max: 100
      },
      gsite_attr_allow: {
        max: 100
      },
      gsite_ignore_tag: {
        max: 300
      }
    },
    attr_names: {
      <?php foreach ($configContent as $key=>$value) { ?>
        gsite_<?php echo $key; ?>_selector: '<?php echo $lang->get('Selector'); ?>',
        gsite_<?php echo $key; ?>_attr: '<?php echo $lang->get('Gathering attribute'); ?>',
        gsite_<?php echo $key; ?>_filter: '<?php echo $lang->get('Filter'); ?>',
      <?php } ?>
      gsite_keep_tag: '<?php echo $lang->get('Retained tags'); ?>',
      gsite_img_filter: '<?php echo $lang->get('Filter image'); ?>',
      gsite_attr_allow: '<?php echo $lang->get('Retained attributes'); ?>',
      gsite_ignore_tag: '<?php echo $lang->get('Ignore tags'); ?>'
    },
    type_msg: {
      length: '<?php echo $lang->get('Size of {:attr} must be {:rule}'); ?>',
      max: '<?php echo $lang->get('Max size of {:attr} must be {:rule}'); ?>'
    },
    msg: {
      loading: '<?php echo $lang->get('Loading'); ?>'
    },
    box: {
      msg: '<?php echo $lang->get('Input error'); ?>'
    }
  };

  function exceptAdd() {
    var count = $('#attr_except > div:last').data('count');
    if (typeof count == 'undefined' || isNaN(count)) {
      count = 0;
    } else {
      ++count;
    }

    $('#attr_except').append('<div id="attr_except_group_' + count + '" class="form-row" data-count="' + count + '">' +
      '<div class="form-group col-md-4">' +
        '<div class="input-group">' +
          '<div class="input-group-prepend">' +
            '<span class="input-group-text"><?php echo $lang->get('Tag'); ?></span>' +
          '</div>' +
          '<input type="text" name="gsite_attr_except[' + count + '][tag]" id="gsite_attr_except_' + count + '_tag" class="form-control">' +
        '</div>' +
      '</div>' +
      '<div class="form-group col-md-8">' +
        '<div class="input-group">' +
          '<div class="input-group-prepend">' +
            '<span class="input-group-text"><?php echo $lang->get('Attributes'); ?></span>' +
          '</div>' +
          '<input type="text" name="gsite_attr_except[' + count + '][attr]" id="gsite_attr_except_' + count + '_attr" class="form-control">' +
          '<span class="input-group-append">' +
            '<button type="button" data-count="' + count + '" class="btn btn-info except_del">' +
              '<span class="bg-icon"><?php include($tpl_icon . 'trash-alt' . BG_EXT_SVG); ?></span>' +
            '</button>' +
          '</span>' +
        '</div>' +
      '</div>' +
    '</div>');
  }

  function exceptDel(count) {
    $('#attr_except_group_' + count).remove();
  }

  $(document).ready(function(){
    var obj_validate_form = $('#gsite_form').baigoValidate(opts_validate_form);
    var obj_submit_form   = $('#gsite_form').baigoSubmit(opts_submit);
    $('#gsite_form').submit(function(){
      if (obj_validate_form.verify()) {
        obj_submit_form.formSubmit();
      }
    });

    $('#attr_except_add').click(function(){
      exceptAdd();
    });

    $('#attr_except').on('click', '.except_del', function(){
      var _count = $(this).data('count');
      exceptDel(_count);
    });

    $('#gsite_preview').html('<div class="embed-responsive embed-responsive-21by9"><iframe class="embed-responsive-item" scrolling="auto" src="<?php echo $hrefRow['gsite-preview-content'], $gsiteRow['gsite_id']; ?>"></iframe></div>');

    $('#gsite_source').html('<div class="embed-responsive embed-responsive-21by9"><iframe class="embed-responsive-item" scrolling="auto" src="<?php echo $hrefRow['gsite-source-content'], $gsiteRow['gsite_id']; ?>"></iframe></div>');
  });
  </script>

<?php include($tpl_include . 'html_foot' . GK_EXT_TPL);
