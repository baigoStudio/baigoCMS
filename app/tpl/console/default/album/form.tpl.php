<?php if ($albumRow['album_id'] > 0) {
  $title_sub    = $lang->get('Edit');
} else {
  $title_sub    = $lang->get('Add');
}

$cfg = array(
  'title'             => $lang->get('Albums', 'console.common') . ' &raquo; ' . $title_sub,
  'menu_active'       => 'attach',
  'sub_active'        => 'album',
  'baigoValidate'     => 'true',
  'baigoSubmit'       => 'true',
  'baigoCheckall'     => 'true',
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
    <?php include($tpl_include . 'album_menu' . GK_EXT_TPL); ?>
  </ul>

  <form name="album_form" id="album_form" action="<?php echo $hrefRow['submit']; ?>">
    <input type="hidden" name="<?php echo $token['name']; ?>" value="<?php echo $token['value']; ?>">
    <input type="hidden" name="album_id" id="album_id" value="<?php echo $albumRow['album_id']; ?>">

    <div class="row">
      <div class="col-xl-9">
        <div class="card mb-3">
          <div class="card-body">
              <div class="form-group">
                <label><?php echo $lang->get('Name'); ?> <span class="text-danger">*</span></label>
                <input type="text" name="album_name" id="album_name" value="<?php echo $albumRow['album_name']; ?>" class="form-control">
                <small class="form-text" id="msg_album_name"></small>
              </div>

              <div class="form-group">
                <label><?php echo $lang->get('Intro'); ?></label>
                <textarea type="text" name="album_content" id="album_content" class="form-control bg-textarea-md"><?php echo $albumRow['album_content']; ?></textarea>
                <small class="form-text" id="msg_album_content"></small>
              </div>

              <div class="bg-validate-box"></div>
          </div>
          <div class="card-footer">
            <button type="submit" class="btn btn-primary">
              <?php echo $lang->get('Save'); ?>
            </button>
          </div>
        </div>
      </div>

      <div class="col-xl-3">
        <div class="card bg-light">
          <div class="card-body">
            <?php if ($albumRow['album_id'] > 0) { ?>
              <div class="form-group">
                <label class="text-muted font-weight-light"><?php echo $lang->get('ID'); ?></label>
                <div class="form-text font-weight-bolder"><?php echo $albumRow['album_id']; ?></div>
              </div>
            <?php } ?>

            <div class="form-group">
              <label><?php echo $lang->get('Status'); ?> <span class="text-danger">*</span></label>
              <?php foreach ($status as $key=>$value) { ?>
                <div class="form-check">
                  <input type="radio" name="album_status" id="album_status_<?php echo $value; ?>" value="<?php echo $value; ?>" <?php if ($albumRow['album_status'] == $value) { ?>checked<?php } ?> class="form-check-input">
                  <label for="album_status_<?php echo $value; ?>" class="form-check-label">
                    <?php echo $lang->get($value); ?>
                  </label>
                </div>
              <?php } ?>
              <small class="form-text" id="msg_album_status"></small>
            </div>

            <div class="form-group">
              <label><?php echo $lang->get('Template'); ?></label>
              <select name="album_tpl" id="album_tpl" class="form-control">
                <option <?php if (isset($albumRow['album_tpl']) && $albumRow['album_tpl'] == '-1') { ?>selected<?php } ?> value="-1"><?php echo $lang->get('Inherit'); ?></option>
                <?php foreach ($tplRows as $key=>$value) {
                  if ($value['type'] == 'file') { ?>
                    <option <?php if ($albumRow['album_tpl'] == $value['name_s']) { ?>selected<?php } ?> value="<?php echo $value['name_s']; ?>">
                      <?php echo $value['name_s']; ?>
                    </option>
                  <?php }
                } ?>
              </select>
              <small class="form-text" id="msg_album_tpl"></small>
            </div>

            <div class="form-group">
              <label><?php echo $lang->get('Cover'); ?></label>
              <div id="album_attach_img" class="mb-2">
                <?php if (isset($attachRow['attach_thumb']) && !empty($attachRow['attach_thumb'])) { ?>
                  <a data-toggle="modal" href="#modal_xl" data-href="<?php echo $hrefRow['attach-show'], $attachRow['attach_id']; ?>">
                    <img src="<?php echo $attachRow['attach_thumb']; ?>" class="img-fluid">
                  </a>
                <?php } ?>
              </div>

              <div class="input-group mb-3">
                <input type="text" id="album_attach_src" readonly value="<?php if (isset($attachRow['attach_thumb']) && !empty($attachRow['attach_thumb'])) { echo $attachRow['attach_thumb']; } ?>" class="form-control">
                <div class="input-group-append">
                  <button type="button" class="btn btn-outline-secondary" data-toggle="modal" data-target="#modal_xl" data-href="<?php echo $hrefRow['attach-choose']; ?>">
                    <span class="bg-icon"><?php include($tpl_icon . 'image' . BG_EXT_SVG); ?></span>
                      <?php echo $lang->get('Select'); ?>
                  </button>
                </div>
              </div>

              <input type="hidden" name="album_attach_id" id="album_attach_id" value="<?php echo $albumRow['album_attach_id']; ?>">
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
      album_name: {
        length: '1,30'
      },
      album_content: {
        max: 30
      },
      album_status: {
        require: true
      }
    },
    attr_names: {
      album_name: '<?php echo $lang->get('Name'); ?>',
      album_content: '<?php echo $lang->get('Note'); ?>',
      album_status: '<?php echo $lang->get('Status'); ?>'
    },
    type_msg: {
      require: '<?php echo $lang->get('{:attr} require'); ?>',
      max: '<?php echo $lang->get('Max size of {:attr} must be {:rule}'); ?>',
      length: '<?php echo $lang->get('Size of {:attr} must be {:rule}'); ?>',
      checkbox: '<?php echo $lang->get('Choose at least one {:attr}'); ?>'
    },
    msg: {
      loading: '<?php echo $lang->get('Loading'); ?>'
    },
    box: {
      msg: '<?php echo $lang->get('Input error'); ?>'
    }
  };

  $(document).ready(function(){
    var obj_validate_form  = $('#album_form').baigoValidate(opts_validate_form);
    var obj_submit_form    = $('#album_form').baigoSubmit(opts_submit);

    $('#album_form').submit(function(){
      if (obj_validate_form.verify()) {
        obj_submit_form.formSubmit();
      }
    });
    $('#album_form').baigoCheckall();
  });
  </script>

<?php include($tpl_include . 'html_foot' . GK_EXT_TPL);
