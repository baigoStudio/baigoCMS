  <?php if ($tagRow['tag_id'] > 0) {
    $title_sub    = $lang->get('Edit');
  } else {
    $title_sub    = $lang->get('Add');
  } ?>

  <form name="tag_form" id="tag_form" action="<?php echo $hrefRow['submit']; ?>">
    <input type="hidden" name="<?php echo $token['name']; ?>" value="<?php echo $token['value']; ?>">
    <input type="hidden" name="tag_id" id="tag_id" value="<?php echo $tagRow['tag_id']; ?>">

    <div class="modal-header">
      <div class="modal-title"><?php echo $lang->get('Tag', 'console.common'), ' &raquo; ', $title_sub; ?></div>
      <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div>
    <div class="modal-body">
      <?php if ($tagRow['tag_id'] > 0) { ?>
        <div class="form-group">
          <label class="text-muted font-weight-light"><?php echo $lang->get('ID'); ?></label>
          <div class="form-text font-weight-bolder"><?php echo $tagRow['tag_id']; ?></div>
        </div>
      <?php } ?>

      <div class="form-group">
        <label><?php echo $lang->get('Name'); ?> <span class="text-danger">*</span></label>
        <input value="<?php echo $tagRow['tag_name']; ?>" name="tag_name" id="tag_name" class="form-control">
        <small class="form-text" id="msg_tag_name"></small>
      </div>

      <div class="form-group">
        <label><?php echo $lang->get('Template'); ?></label>
        <select name="tag_tpl" id="tag_tpl" class="form-control">
          <option <?php if (isset($tagRow['tag_tpl']) && $tagRow['tag_tpl'] == '-1') { ?>selected<?php } ?> value="-1"><?php echo $lang->get('Inherit'); ?></option>
          <?php foreach ($tplRows as $key=>$value) {
            if ($value['type'] == 'file') { ?>
              <option <?php if ($tagRow['tag_tpl'] == $value['name_s']) { ?>selected<?php } ?> value="<?php echo $value['name_s']; ?>">
                <?php echo $value['name_s']; ?>
              </option>
            <?php }
          } ?>
        </select>
        <small class="form-text" id="msg_tag_tpl"></small>
      </div>

      <div class="form-group">
        <label><?php echo $lang->get('Status'); ?> <span class="text-danger">*</span></label>
        <div>
          <?php foreach ($status as $key=>$value) { ?>
            <div class="form-check-inline">
              <input type="radio" name="tag_status" id="tag_status_<?php echo $value; ?>" value="<?php echo $value; ?>" <?php if ($tagRow['tag_status'] == $value) { ?>checked<?php } ?> class="form-check-input">
              <label for="tag_status_<?php echo $value; ?>" class="form-check-label">
                <?php echo $lang->get($value); ?>
              </label>
            </div>
          <?php } ?>
        </div>
        <small class="form-text" id="msg_tag_status"></small>
      </div>

      <div class="bg-validate-box"></div>
    </div>
    <div class="modal-footer">
      <button type="submit" class="btn btn-primary btn-sm">
        <?php echo $lang->get('Save'); ?>
      </button>
      <button type="button" class="btn btn-outline-secondary btn-sm" data-dismiss="modal">
        <?php echo $lang->get('Close', 'console.common'); ?>
      </button>
    </div>
  </form>

  <script type="text/javascript">
  var opts_validate_modal = {
    rules: {
      tag_name: {
        length: '1,30'
      },
      tag_status: {
        require: true
      }
    },
    attr_names: {
      tag_name: '<?php echo $lang->get('Name'); ?>',
      tag_status: '<?php echo $lang->get('Status'); ?>'
    },
    type_msg: {
      length: '<?php echo $lang->get('Size of {:attr} must be {:rule}'); ?>',
      require: '<?php echo $lang->get('{:attr} require'); ?>'
    },
    msg: {
      loading: '<?php echo $lang->get('Loading'); ?>'
    },
    box: {
      msg: '<?php echo $lang->get('Input error'); ?>'
    }
  };

  $(document).ready(function(){
    var obj_validate_modal   = $('#tag_form').baigoValidate(opts_validate_modal);
    var obj_submit_modal     = $('#tag_form').baigoSubmit(opts_submit);

    $('#tag_form').submit(function(){
      if (obj_validate_modal.verify()) {
        obj_submit_modal.formSubmit();
      }
    });
  });
  </script>
