<?php $str_sub = 'index';
$title = $lang->get('Attachment', 'console.common') . ' &raquo; ';

if ($attachRow['attach_id'] > 0) {
  $title  .= $lang->get('Edit');
} else {
  $title  .= $lang->get('Upload');
  $str_sub = 'form';

  if ($albumRow['album_id'] > 0) {
    $title  = $lang->get('Albums', 'console.common') . ' &raquo; ' . $albumRow['album_name'] . ' &raquo; ' . $lang->get('Upload');
    $str_sub = 'album';
  }
}

$cfg = array(
  'title'             => $title,
  'menu_active'       => 'attach',
  'sub_active'        => $str_sub,
  'baigoValidate'     => 'true',
  'baigoSubmit'       => 'true',
  'tooltip'           => 'true',
  'upload'            => 'true',
  'typeahead'         => 'true',
  'imageAsync'        => 'true',
);

include($tpl_include . 'console_head' . GK_EXT_TPL); ?>

  <ul class="nav mb-3">
    <li class="nav-item">
      <a href="<?php echo $hrefRow['index']; ?>" class="nav-link">
        <span class="bg-icon"><?php include($tpl_icon . 'chevron-left' . BG_EXT_SVG); ?></span>
        <?php echo $lang->get('Back'); ?>
      </a>
    </li>
    <?php include($tpl_include . 'album_menu' . GK_EXT_TPL); ?>
  </ul>

  <div class="row">
    <div class="col-xl-9">
      <div class="card mb-3">
        <div class="card-body">
          <?php if ($attachRow['attach_id'] > 0) {
            include($tpl_ctrl . 'head' . GK_EXT_TPL);
          } else {
            include($tpl_ctrl . 'upload_form' . GK_EXT_TPL);
          } ?>
        </div>
      </div>

      <?php if ($albumRow['album_id'] > 0) { ?>
        <div class="card mb-3">
          <div class="card-header">
            <?php echo $albumRow['album_name']; ?>
          </div>
          <div class="card-body">
            <?php echo $albumRow['album_content']; ?>
          </div>

          <?php if (!empty($attachRows)) { ?>
            <div class="table-responsive">
              <table class="table">
                <thead>
                  <tr>
                    <th>&nbsp;</th>
                    <th><?php echo $lang->get('Images in album'); ?></th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($attachRows as $key=>$value) { ?>
                    <tr>
                      <td class="text-nowrap bg-td-xs">
                        <a href="<?php echo $hrefRow['show'], $value['attach_id']; ?>">
                          <img src="{:DIR_STATIC}image/loading.gif" data-src="<?php echo $value['attach_thumb']; ?>" data-toggle="async" alt="<?php echo $value['attach_name']; ?>" width="60">
                        </a>
                      </td>
                      <td>
                        <div class="mb-3"><?php echo $value['attach_name']; ?></div>
                        <div class="d-flex justify-content-between">
                          <a href="<?php echo $hrefRow['show'], $value['attach_id']; ?>">
                            <span class="bg-icon"><?php include($tpl_icon . 'eye' . BG_EXT_SVG); ?></span>
                            <?php echo $lang->get('Show'); ?>
                          </a>

                          <span>
                            <?php $str_status = $value['attach_box'];
                            include($tpl_include . 'status_process' . GK_EXT_TPL); ?>
                          </span>
                        </div>
                      </td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          <?php } ?>
        </div>
      <?php } ?>
    </div>

    <div class="col-xl-3">
      <?php if ($attachRow['attach_id'] > 0) { ?>
        <form name="attach_form" id="attach_form" action="<?php echo $hrefRow['submit']; ?>">
          <input type="hidden" name="<?php echo $token['name']; ?>" value="<?php echo $token['value']; ?>">
          <input type="hidden" name="attach_id" id="attach_id" value="<?php echo $attachRow['attach_id']; ?>">

          <div class="card bg-light">
            <div class="card-body">
              <div class="form-group">
                <label class="text-muted font-weight-light"><?php echo $lang->get('ID'); ?></label>
                <div class="form-text font-weight-bolder"><?php echo $attachRow['attach_id']; ?></div>
              </div>

              <div class="form-group">
                <label><?php echo $lang->get('Original name'); ?></label>
                <input type="text" value="<?php echo $attachRow['attach_name']; ?>" readonly class="form-control">
              </div>

              <div class="form-group">
                <label><?php echo $lang->get('Extension'); ?> <span class="text-danger">*</span></label>
                <input type="text" name="attach_ext" id="attach_ext" value="<?php echo $attachRow['attach_ext']; ?>" class="form-control">
                <small class="form-text" id="msg_attach_ext"></small>
              </div>

              <div class="form-group">
                <label><?php echo $lang->get('MIME'); ?></label>
                <input type="text" name="attach_mime" id="attach_mime" value="<?php echo $attachRow['attach_mime']; ?>" class="form-control">
                <small class="form-text" id="msg_attach_mime"></small>
              </div>

              <div class="form-group">
                <label><?php echo $lang->get('Note'); ?></label>
                <input type="text" name="attach_note" id="attach_note" value="<?php echo $attachRow['attach_note']; ?>" class="form-control">
                <small class="form-text" id="msg_attach_note"></small>
              </div>

              <div class="form-group">
                <label><?php echo $lang->get('Status'); ?> <span class="text-danger">*</span></label>
                <?php foreach ($box as $key=>$value) { ?>
                  <div class="form-check">
                    <input type="radio" name="attach_box" id="attach_box_<?php echo $value; ?>" value="<?php echo $value; ?>" <?php if ($attachRow['attach_box'] == $value) { ?>checked<?php } ?> class="form-check-input">
                    <label for="attach_box_<?php echo $value; ?>" class="form-check-label">
                      <?php echo $lang->get($value); ?>
                    </label>
                  </div>
                <?php } ?>
                <small class="form-text" id="msg_attach_box"></small>
              </div>

              <?php include($tpl_ctrl . 'addon_form' . GK_EXT_TPL); ?>

              <div class="bg-validate-box"></div>
            </div>
            <div class="card-footer">
              <button type="submit" class="btn btn-primary">
                <?php echo $lang->get('Save'); ?>
              </button>
            </div>
          </div>
        </form>
      <?php } else { ?>
        <div class="card bg-light">
          <div class="card-body">
            <?php include($tpl_ctrl . 'addon_form' . GK_EXT_TPL); ?>
          </div>
        </div>
      <?php } ?>
    </div>
  </div>

<?php include($tpl_include . 'console_foot' . GK_EXT_TPL);

  if ($attachRow['attach_id'] > 0) {
    include($tpl_ctrl . 'script' . GK_EXT_TPL);
  } else {
    include($tpl_ctrl . 'upload_script' . GK_EXT_TPL);
  }

  include($tpl_ctrl . 'addon_script' . GK_EXT_TPL); ?>

  <script type="text/javascript">
  var opts_validate_form = {
    rules: {
      attach_note: {
        max: 1000
      },
      attach_ext: {
        length: '1,5'
      },
      attach_mime: {
        length: '1,100'
      },
      attach_box: {
        require: true
      }
    },
    attr_names: {
      attach_note: '<?php echo $lang->get('Note'); ?>',
      attach_ext: '<?php echo $lang->get('Extension'); ?>',
      attach_mime: '<?php echo $lang->get('MIME'); ?>',
      attach_box: '<?php echo $lang->get('Status'); ?>'
    },
    type_msg: {
      require: '<?php echo $lang->get('{:attr} require'); ?>',
      length: '<?php echo $lang->get('Size of {:attr} must be {:rule}'); ?>'
    },
    msg: {
      loading: '<?php echo $lang->get('Loading'); ?>',
      ajax_err: '<?php echo $lang->get('Server side error'); ?>'
    },
    box: {
      msg: '<?php echo $lang->get('Input error'); ?>'
    }
  };

  $(document).ready(function(){
    var obj_validate_form   = $('#attach_form').baigoValidate(opts_validate_form);
    var obj_submit_form     = $('#attach_form').baigoSubmit(opts_submit);

    $('#attach_form').submit(function(){
      if (obj_validate_form.verify()) {
        obj_submit_form.formSubmit();
      }
    });
  });
  </script>

<?php include($tpl_include . 'html_foot' . GK_EXT_TPL);
