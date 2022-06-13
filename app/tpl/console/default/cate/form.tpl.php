<?php if ($cateRow['cate_id'] > 0) {
  $title_sub    = $lang->get('Edit');
  $str_sub      = 'index';
} else {
  $title_sub    = $lang->get('Add');
  $str_sub      = 'form';
}

$cfg = array(
  'title'             => $lang->get('Category', 'console.common') . ' &raquo; ' . $title_sub,
  'menu_active'       => 'cate',
  'sub_active'        => $str_sub,
  'baigoValidate'     => 'true',
  'baigoSubmit'       => 'true',
  'tinymce'           => 'true',
  'upload'            => 'true',
);

include($tpl_include . 'console_head' . GK_EXT_TPL); ?>

  <ul class="nav mb-3">
    <li class="nav-item">
      <a href="<?php echo $hrefRow['index']; ?>" class="nav-link">
        <span class="bg-icon"><?php include($tpl_icon . 'chevron-left' . BG_EXT_SVG); ?></span>
        <?php echo $lang->get('Back'); ?>
      </a>
    </li>
    <?php include($tpl_ctrl . 'cate_menu' . GK_EXT_TPL); ?>
  </ul>

  <form name="cate_form" id="cate_form" action="<?php echo $hrefRow['submit']; ?>">
    <input type="hidden" name="<?php echo $token['name']; ?>" value="<?php echo $token['value']; ?>">
    <input type="hidden" name="cate_id" id="cate_id" value="<?php echo $cateRow['cate_id']; ?>">

    <div class="row">
      <div class="col-xl-9">
        <div class="mb-3">
          <div class="form-group">
            <input type="text" name="cate_name" id="cate_name" value="<?php echo $cateRow['cate_name']; ?>" class="form-control form-control-lg" placeholder="<?php echo $lang->get('Name'); ?>">
            <small class="form-text" id="msg_cate_name"></small>
          </div>

          <div class="form-group">
            <label><?php echo $lang->get('Alias'); ?></label>
            <input type="text" name="cate_alias" id="cate_alias" value="<?php echo $cateRow['cate_alias']; ?>" class="form-control">
            <small class="form-text" id="msg_cate_alias"><?php echo $lang->get('Usually used to build URLs'); ?></small>
          </div>

          <div class="form-group">
            <label><?php echo $lang->get('Count of per page'); ?></label>
            <input type="text" name="cate_perpage" id="cate_perpage" value="<?php echo $cateRow['cate_perpage']; ?>" class="form-control">
            <small class="form-text" id="msg_cate_perpage"><?php echo $lang->get('<kbd>0</kbd> is inherit'); ?></small>
          </div>

          <?php if ($cateRow['cate_parent_id'] < 1) { ?>
            <div class="form-group">
              <label><?php echo $lang->get('URL Prefix'); ?></label>
              <input type="text" name="cate_prefix" id="cate_prefix" value="<?php echo $cateRow['cate_prefix']; ?>" class="form-control">
              <small class="form-text" id="msg_cate_prefix"><?php echo $lang->get('Do not add a slash <kbd>/</kbd> at the end'); ?></small>
            </div>
          <?php } ?>

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
                  <?php if ($cateRow['cate_id'] > 0) { ?>
                    <a href="<?php echo $hrefRow['attach'], $cateRow['cate_id']; ?>" class="btn btn-outline-secondary">
                      <?php echo $lang->get('Cover management'); ?>
                    </a>
                  <?php } ?>
                </div>
            </div>
            <textarea name="cate_content" id="cate_content" class="form-control tinymce"><?php echo $cateRow['cate_content']; ?></textarea>
          </div>

          <div class="bg-validate-box"></div>

          <button type="submit" class="btn btn-primary">
            <?php echo $lang->get('Save'); ?>
          </button>
        </div>
      </div>

      <div class="col-xl-3">
        <div class="card bg-light">
          <div class="card-body border-bottom">
            <?php if ($cateRow['cate_id'] > 0) { ?>
              <div class="form-group">
                <label class="text-muted font-weight-light"><?php echo $lang->get('ID'); ?></label>
                <div class="form-text font-weight-bolder"><?php echo $cateRow['cate_id']; ?></div>
              </div>
            <?php } ?>

            <div class="form-group">
              <label><?php echo $lang->get('Status'); ?> <span class="text-danger">*</span></label>
              <?php foreach ($status as $key=>$value) { ?>
                <div class="form-check">
                  <input type="radio" name="cate_status" id="cate_status_<?php echo $value; ?>" value="<?php echo $value; ?>" <?php if ($cateRow['cate_status'] == $value) { ?>checked<?php } ?> class="form-check-input">
                  <label for="cate_status_<?php echo $value; ?>" class="form-check-label">
                    <?php echo $lang->get($value); ?>
                  </label>
                </div>
              <?php } ?>
              <small class="form-text" id="msg_cate_status"></small>
            </div>

            <div class="form-group">
              <label><?php echo $lang->get('Parent category'); ?> <span class="text-danger">*</span></label>
              <select name="cate_parent_id" id="cate_parent_id" class="form-control">
                <option value=""><?php echo $lang->get('Please select'); ?></option>
                <option <?php if ($cateRow['cate_parent_id'] == 0) { ?>selected<?php } ?> value="0"><?php echo $lang->get('As a primary category'); ?></option>
                <?php $check_id = $cateRow['cate_parent_id'];
                $disabled_id = $cateRow['cate_id'];
                include($tpl_include . 'cate_list_option' . GK_EXT_TPL); ?>
              </select>
              <small class="form-text" id="msg_cate_parent_id"></small>
            </div>

            <div class="form-group">
              <label><?php echo $lang->get('Template'); ?> <span class="text-danger">*</span></label>
              <select name="cate_tpl" id="cate_tpl" class="form-control">
                <option value=""><?php echo $lang->get('Please select'); ?></option>
                <option <?php if (isset($cateRow['cate_tpl']) && $cateRow['cate_tpl'] == '-1') { ?>selected<?php } ?> value="-1"><?php echo $lang->get('Inherit'); ?></option>
                <?php foreach ($tplRows as $key=>$value) {
                  if ($value['type'] == 'dir') { ?>
                    <option <?php if (isset($cateRow['cate_tpl']) && $cateRow['cate_tpl'] == $value['name']) { ?>selected<?php } ?> value="<?php echo $value['name']; ?>"><?php echo $value['name']; ?></option>
                  <?php }
                } ?>
              </select>
              <small class="form-text" id="msg_cate_tpl"></small>
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
                    <div id="cate_attach_img" class="mb-2">
                      <?php if (isset($attachRow['attach_thumb']) && !empty($attachRow['attach_thumb'])) { ?>
                        <a data-toggle="modal" href="#modal_xl" data-href="<?php echo $hrefRow['attach-show'], $attachRow['attach_id']; ?>">
                          <img src="<?php echo $attachRow['attach_thumb']; ?>" class="img-fluid">
                        </a>
                      <?php } ?>
                    </div>

                    <div class="input-group mb-3">
                      <input type="text" id="cate_attach_src" readonly value="<?php if (isset($attachRow['attach_thumb']) && !empty($attachRow['attach_thumb'])) { echo $attachRow['attach_thumb']; } ?>" class="form-control">
                      <div class="input-group-append">
                        <button type="button" class="btn btn-outline-secondary" data-toggle="modal" data-target="#modal_xl" data-href="<?php echo $hrefRow['attach-cover'], $cateRow['cate_id']; ?>">
                          <span class="bg-icon"><?php include($tpl_icon . 'image' . BG_EXT_SVG); ?></span>
                          <?php echo $lang->get('Select'); ?>
                        </button>
                      </div>
                    </div>

                    <input type="hidden" name="cate_attach_id" id="cate_attach_id" value="<?php echo $cateRow['cate_attach_id']; ?>">
                  </div>
                </div>
              </div>
            </div>

            <?php if ($gen_open === true && isset($ftp_open) && $cateRow['cate_parent_id'] < 1) { ?>
              <div class="accordion-item">
                <div class="accordion-header" id="heading-ftp">
                  <button class="accordion-button<?php if (empty($cateRow['cate_ftp_host'])) { ?> collapsed<?php } ?>" type="button" data-toggle="collapse" data-target="#bg-form-ftp">
                    <?php echo $lang->get('FTP Issue'); ?>
                  </button>
                </div>

                <div id="bg-form-ftp" class="accordion-collapse collapse<?php if (!empty($cateRow['cate_ftp_host'])) { ?> show<?php } ?>">
                  <div class="accordion-body">
                    <div class="form-group">
                      <label><?php echo $lang->get('FTP Host'); ?></label>
                      <input type="text" name="cate_ftp_host" id="cate_ftp_host" value="<?php echo $cateRow['cate_ftp_host']; ?>" class="form-control">
                      <small class="form-text" id="msg_cate_ftp_host"></small>
                    </div>

                    <div class="form-group">
                      <label><?php echo $lang->get('Host port'); ?></label>
                      <input type="text" name="cate_ftp_port" id="cate_ftp_port" value="<?php echo $cateRow['cate_ftp_port']; ?>" class="form-control">
                      <small class="form-text" id="msg_cate_ftp_port"></small>
                    </div>

                    <div class="form-group">
                      <label><?php echo $lang->get('Username'); ?></label>
                      <input type="text" name="cate_ftp_user" id="cate_ftp_user" value="<?php echo $cateRow['cate_ftp_user']; ?>" class="form-control">
                      <small class="form-text" id="msg_cate_ftp_user"></small>
                    </div>

                    <div class="form-group">
                      <label><?php echo $lang->get('Password'); ?></label>
                      <input type="text" name="cate_ftp_pass" id="cate_ftp_pass" value="<?php echo $cateRow['cate_ftp_pass']; ?>" class="form-control">
                      <small class="form-text" id="msg_cate_ftp_pass"></small>
                    </div>

                    <div class="form-group">
                      <label><?php echo $lang->get('Remote path'); ?></label>
                      <input type="text" name="cate_ftp_path" id="cate_ftp_path" value="<?php echo $cateRow['cate_ftp_path']; ?>" class="form-control">
                      <small class="form-text" id="msg_cate_ftp_path"><?php echo $lang->get('Do not add a slash <kbd>/</kbd> at the end'); ?></small>
                    </div>

                    <div class="form-group">
                      <div class="custom-control custom-switch">
                        <input type="checkbox" name="cate_ftp_pasv" id="cate_ftp_pasv" value="on" <?php if ($cateRow['cate_ftp_pasv'] === 'on') { ?>checked<?php } ?> class="custom-control-input">
                        <label for="cate_ftp_pasv" class="custom-control-label">
                          <?php echo $lang->get('Passive mode'); ?>
                        </label>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            <?php } ?>

            <div class="accordion-item">
              <div class="accordion-header" id="heading-link">
                <button class="accordion-button<?php if (empty($cateRow['cate_link'])) { ?> collapsed<?php } ?>" type="button" data-toggle="collapse" data-target="#bg-form-link">
                  <?php echo $lang->get('Jump to'); ?>
                </button>
              </div>

              <div id="bg-form-link" class="accordion-collapse collapse<?php if (!empty($cateRow['cate_link'])) { ?> show<?php } ?>">
                <div class="accordion-body">
                  <textarea type="text" name="cate_link" id="cate_link" class="form-control bg-textarea-sm"><?php echo $cateRow['cate_link']; ?></textarea>
                  <small class="form-text" id="msg_cate_link"></small>
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
      </div>
    </div>
  </form>

<?php include($tpl_include . 'console_foot' . GK_EXT_TPL);

  include($tpl_include . 'modal_xl' . GK_EXT_TPL); ?>

  <script type="text/javascript">
  var opts_validate_form = {
    rules: {
      cate_name: {
        length: '1,300'
      },
      cate_alias: {
        max: 300,
        format: 'alpha_dash',
        ajax: {
          url: '<?php echo $hrefRow['check']; ?>',
          attach: {
            selectors: ['#cate_id', '#cate_parent_id'],
            keys: ['cate_id', 'cate_parent_id']
          }
        }
      },
      cate_perpage: {
        format: 'int'
      },
      cate_prefix: {
        max: 3000
      },
      cate_link: {
        max: 900
      },
      cate_parent_id: {
        require: true
      },
      cate_tpl: {
        require: true
      },
      cate_status: {
        require: true
      },
      cate_ftp_host: {
        max: 3000
      },
      cate_ftp_port: {
        max: 5
      },
      cate_ftp_user: {
        max: 300
      },
      cate_ftp_path: {
        max: 3000
      }
    },
    attr_names: {
      cate_name: '<?php echo $lang->get('Name'); ?>',
      cate_alias: '<?php echo $lang->get('Alias'); ?>',
      cate_perpage: '<?php echo $lang->get('Count of per page'); ?>',
      cate_prefix: '<?php echo $lang->get('URL Prefix'); ?>',
      cate_link: '<?php echo $lang->get('Jump to'); ?>',
      cate_parent_id: '<?php echo $lang->get('Parent category'); ?>',
      cate_tpl: '<?php echo $lang->get('Template'); ?>',
      cate_status: '<?php echo $lang->get('Status'); ?>',
      cate_ftp_host: '<?php echo $lang->get('FTP Host'); ?>',
      cate_ftp_port: '<?php echo $lang->get('Host port'); ?>',
      cate_ftp_user: '<?php echo $lang->get('Username'); ?>',
      cate_ftp_path: '<?php echo $lang->get('Remote path'); ?>'
    },
    type_msg: {
      require: '<?php echo $lang->get('{:attr} require'); ?>',
      max: '<?php echo $lang->get('Max size of {:attr} must be {:rule}'); ?>',
      length: '<?php echo $lang->get('Size of {:attr} must be {:rule}'); ?>'
    },
    format_msg: {
      'int': '<?php echo $lang->get('{:attr} must be integer'); ?>',
      alpha_dash: '<?php echo $lang->get('{:attr} must be alpha-numeric, dash, underscore'); ?>'
    },
    msg: {
      loading: '<?php echo $lang->get('Loading'); ?>'
    },
    box: {
      msg: '<?php echo $lang->get('Input error'); ?>'
    }
  };

  function showMore() {
    var _cate_parent = $('#cate_parent_id').val();
    if (_cate_parent < 1) {
      $('#ftp_form').show();
    } else {
      $('#ftp_form').hide();
    }
  }

  $(document).ready(function(){
    showMore();
    $('#cate_parent_id').change(function(){
      showMore();
    });

    var obj_validate_form  = $('#cate_form').baigoValidate(opts_validate_form);
    var obj_submit_form     = $('#cate_form').baigoSubmit(opts_submit);

    $('#cate_form').submit(function(){
      if (obj_validate_form.verify()) {
        tinyMCE.triggerSave();
        obj_submit_form.formSubmit();
      }
    });
  });
  </script>

<?php include($tpl_include . 'html_foot' . GK_EXT_TPL);
