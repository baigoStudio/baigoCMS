<?php if ($specRow['spec_id'] > 0) {
  $title_sub    = $lang->get('Edit');
  $str_sub      = 'index';
} else {
  $title_sub    = $lang->get('Add');
  $str_sub      = 'form';
}

$cfg = array(
  'title'             => $lang->get('Special topic', 'console.common') . ' &raquo; ' . $title_sub,
  'menu_active'       => 'spec',
  'sub_active'        => $str_sub,
  'baigoValidate'     => 'true',
  'baigoSubmit'       => 'true',
  'tinymce'           => 'true',
  'upload'            => 'true',
  'datetimepicker'    => 'true',
);

include($tpl_include . 'console_head' . GK_EXT_TPL); ?>

  <ul class="nav mb-3">
    <li class="nav-item">
      <a href="<?php echo $hrefRow['index']; ?>" class="nav-link">
        <span class="bg-icon"><?php include($tpl_icon . 'chevron-left' . BG_EXT_SVG); ?></span>
        <?php echo $lang->get('Back'); ?>
      </a>
    </li>
    <?php include($tpl_include . 'spec_menu' . GK_EXT_TPL); ?>
  </ul>

  <form name="spec_form" id="spec_form" action="<?php echo $hrefRow['submit']; ?>">
    <input type="hidden" name="<?php echo $token['name']; ?>" value="<?php echo $token['value']; ?>">
    <input type="hidden" name="spec_id" id="spec_id" value="<?php echo $specRow['spec_id']; ?>">

    <div class="row">
      <div class="col-xl-9">
        <div class="mb-3">
          <div class="form-group">
            <input type="text" name="spec_name" id="spec_name" value="<?php echo $specRow['spec_name']; ?>" class="form-control form-control-lg" placeholder="<?php echo $lang->get('Name'); ?>">
            <small class="form-text" id="msg_spec_name"></small>
          </div>

          <div class="form-group">
            <label><?php echo $lang->get('Content'); ?></label>
            <div class="mb-2">
              <div class="btn-group btn-group-sm">
                <a class="btn btn-outline-success" data-toggle="modal" href="#modal_xl" data-href="<?php echo $hrefRow['attach-choose']; ?>">
                  <span class="bg-icon"><?php include($tpl_icon . 'photo-video' . BG_EXT_SVG); ?></span>
                  <?php echo $lang->get('Add media'); ?>
                </a>
                <a class="btn btn-outline-secondary" data-toggle="modal" href="#modal_xl" data-href="<?php echo $hrefRow['album-choose']; ?>">
                  <span class="bg-icon"><?php include($tpl_icon . 'images' . BG_EXT_SVG); ?></span>
                  <?php echo $lang->get('Add album'); ?>
                </a>
                <?php if ($specRow['spec_id'] > 0) { ?>
                  <a href="<?php echo $hrefRow['attach'], $specRow['spec_id']; ?>" class="btn btn-outline-secondary">
                    <?php echo $lang->get('Cover management'); ?>
                  </a>
                <?php } ?>
              </div>
            </div>
            <textarea type="text" name="spec_content" id="spec_content" class="form-control tinymce"><?php echo $specRow['spec_content']; ?></textarea>
            <small class="form-text" id="msg_spec_content"></small>
          </div>

          <div class="bg-validate-box"></div>

          <button type="submit" class="btn btn-primary">
            <?php echo $lang->get('Save'); ?>
          </button>
        </div>
      </div>

      <div class="col-xl-3">
        <div class="card bg-light">
          <div class="card-body">
            <?php if ($specRow['spec_id'] > 0) { ?>
              <div class="form-group">
                <label class="text-muted font-weight-light"><?php echo $lang->get('ID'); ?></label>
                <div class="form-text font-weight-bolder"><?php echo $specRow['spec_id']; ?></div>
              </div>
            <?php } ?>

            <div class="form-group">
              <label><?php echo $lang->get('Status'); ?> <span class="text-danger">*</span></label>
              <?php foreach ($status as $key=>$value) { ?>
                <div class="form-check">
                  <input type="radio" name="spec_status" id="spec_status_<?php echo $value; ?>" value="<?php echo $value; ?>" <?php if ($specRow['spec_status'] == $value) { ?>checked<?php } ?> class="form-check-input">
                  <label for="spec_status_<?php echo $value; ?>" class="form-check-label">
                    <?php echo $lang->get($value); ?>
                  </label>
                </div>
              <?php } ?>
              <small class="form-text" id="msg_spec_status"></small>
            </div>

            <div class="form-group">
              <label><?php echo $lang->get('Updated time'); ?></label>
              <input type="text" name="spec_time_update_format" id="spec_time_update_format" value="<?php echo $specRow['spec_time_update_format']['date_time']; ?>" class="form-control input_date">
              <small class="form-text" id="msg_spec_time_update_format"></small>
            </div>

            <div class="form-group">
              <label><?php echo $lang->get('Template'); ?></label>
              <select name="spec_tpl" id="spec_tpl" class="form-control">
                <option <?php if (isset($specRow['spec_tpl']) && $specRow['spec_tpl'] == '-1') { ?>selected<?php } ?> value="-1"><?php echo $lang->get('Inherit'); ?></option>
                <?php foreach ($tplRows as $key=>$value) {
                  if ($value['type'] == 'file') { ?>
                    <option <?php if ($specRow['spec_tpl'] == $value['name_s']) { ?>selected<?php } ?> value="<?php echo $value['name_s']; ?>">
                      <?php echo $value['name_s']; ?>
                    </option>
                  <?php }
                } ?>
              </select>
              <small class="form-text" id="msg_spec_tpl"></small>
            </div>

            <div class="form-group">
              <label><?php echo $lang->get('Cover'); ?></label>
              <div id="spec_attach_img" class="mb-2">
                <?php if (isset($attachRow['attach_thumb']) && !empty($attachRow['attach_thumb'])) { ?>
                  <a data-toggle="modal" href="#modal_xl" data-href="<?php echo $hrefRow['attach-show'], $attachRow['attach_id']; ?>">
                    <img src="<?php echo $attachRow['attach_thumb']; ?>" class="img-fluid">
                  </a>
                <?php } ?>
              </div>

              <div class="input-group mb-3">
                <input type="text" id="spec_attach_src" readonly value="<?php if (isset($attachRow['attach_thumb']) && !empty($attachRow['attach_thumb'])) { echo $attachRow['attach_thumb']; } ?>" class="form-control">
                <div class="input-group-append">
                  <button type="button" class="btn btn-outline-secondary" data-toggle="modal" data-target="#modal_xl" data-href="<?php echo $hrefRow['attach-cover']; ?>">
                    <span class="bg-icon"><?php include($tpl_icon . 'image' . BG_EXT_SVG); ?></span>
                    <?php echo $lang->get('Select'); ?>
                  </button>
                </div>
              </div>

              <input type="hidden" name="spec_attach_id" id="spec_attach_id" value="<?php echo $specRow['spec_attach_id']; ?>">
            </div>
          </div>
          <div class="card-footer">
            <button type="submit" class="btn btn-primary">
              <?php echo $lang->get('Save'); ?>
            </button>
          </div>
        </div>
      </div>
    </div>
  </form>

<?php include($tpl_include . 'console_foot' . GK_EXT_TPL);

  include($tpl_include . 'modal_xl' . GK_EXT_TPL); ?>

  <script type="text/javascript">
  var opts_validate_form = {
    rules: {
      spec_name: {
        length: '1,300'
      },
      spec_content: {
        max: 3000
      },
      spec_status: {
        require: true
      },
      spec_time_update_format: {
        format: 'date_time'
      }
    },
    attr_names: {
      spec_name: '<?php echo $lang->get('Name'); ?>',
      spec_content: '<?php echo $lang->get('Content'); ?>',
      spec_status: '<?php echo $lang->get('Status'); ?>',
      spec_time_update_format: '<?php echo $lang->get('Updated time'); ?>'
    },
    type_msg: {
      require: '<?php echo $lang->get('{:attr} require'); ?>',
      max: '<?php echo $lang->get('Max size of {:attr} must be {:rule}'); ?>',
      length: '<?php echo $lang->get('Size of {:attr} must be {:rule}'); ?>',
      checkbox: '<?php echo $lang->get('Choose at least one {:attr}'); ?>'
    },
    format_msg: {
      date_time: '<?php echo $lang->get('{:attr} not a valid datetime'); ?>'
    },
    msg: {
      loading: '<?php echo $lang->get('Loading'); ?>'
    },
    box: {
      msg: '<?php echo $lang->get('Input error'); ?>'
    }
  };

  $(document).ready(function(){
    var obj_validate_form   = $('#spec_form').baigoValidate(opts_validate_form);
    var obj_submit_form     = $('#spec_form').baigoSubmit(opts_submit);

    $('#spec_form').submit(function(){
      if (obj_validate_form.verify()) {
        tinyMCE.triggerSave();
        obj_submit_form.formSubmit();
      }
    });

    $('.input_date').datetimepicker(opts_datetimepicker);
  });
  </script>

<?php include($tpl_include . 'html_foot' . GK_EXT_TPL);
