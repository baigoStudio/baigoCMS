  <?php if ($sourceRow['source_id'] > 0) {
    $title_sub    = $lang->get('Edit');
  } else {
    $title_sub    = $lang->get('Add');
  } ?>

  <form name="source_form" id="source_form" action="<?php echo $hrefRow['submit']; ?>">
    <input type="hidden" name="<?php echo $token['name']; ?>" value="<?php echo $token['value']; ?>">
    <input type="hidden" name="source_id" id="source_id" value="<?php echo $sourceRow['source_id']; ?>">

    <div class="modal-header">
      <div class="modal-title"><?php echo $lang->get('Article source', 'console.common'), ' &raquo; ', $title_sub; ?></div>
      <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div>

    <div class="modal-body">
      <?php if ($sourceRow['source_id'] > 0) { ?>
        <div class="form-group">
          <label class="text-muted font-weight-light"><?php echo $lang->get('ID'); ?></label>
          <div class="form-text font-weight-bolder"><?php echo $sourceRow['source_id']; ?></div>
        </div>
      <?php } ?>

      <div class="form-group">
        <label><?php echo $lang->get('Name'); ?> <span class="text-danger">*</span></label>
        <input type="text" name="source_name" id="source_name" value="<?php echo $sourceRow['source_name']; ?>" class="form-control">
        <small class="form-text" id="msg_source_name"></small>
      </div>

      <div class="form-group">
        <label><?php echo $lang->get('Author'); ?> <span class="text-danger">*</span></label>
        <input type="text" name="source_author" id="source_author" value="<?php echo $sourceRow['source_author']; ?>" class="form-control">
        <small class="form-text" id="msg_source_author"></small>
      </div>

      <div class="form-group">
        <label><?php echo $lang->get('URL'); ?></label>
        <input type="text" name="source_url" id="source_url" value="<?php echo $sourceRow['source_url']; ?>" class="form-control">
        <small class="form-text" id="msg_source_url"><?php echo $lang->get('Start with <code>http://</code> or <code>https://</code>'); ?></small>
      </div>

      <div class="form-group">
        <label><?php echo $lang->get('Note'); ?></label>
        <input type="text" name="source_note" id="source_note" value="<?php echo $sourceRow['source_note']; ?>" class="form-control">
        <small class="form-text" id="msg_source_note"></small>
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
  var opts_validate_form = {
    rules: {
      source_name: {
        length: '1,300'
      },
      source_author: {
        length: '1,300'
      },
      source_url: {
        max: 900,
        format: 'url'
      },
      source_note: {
        max: 30
      }
    },
    attr_names: {
      source_name: '<?php echo $lang->get('Name'); ?>',
      source_author: '<?php echo $lang->get('Author'); ?>',
      source_url: '<?php echo $lang->get('URL'); ?>',
      source_note: '<?php echo $lang->get('Note'); ?>'
    },
    type_msg: {
      require: '<?php echo $lang->get('{:attr} require'); ?>',
      max: '<?php echo $lang->get('Max size of {:attr} must be {:rule}'); ?>',
      length: '<?php echo $lang->get('Size of {:attr} must be {:rule}'); ?>'
    },
    format_msg: {
      url: '<?php echo $lang->get('{:attr} not a valid url'); ?>'
    },
    msg: {
      loading: '<?php echo $lang->get('Loading'); ?>'
    },
    box: {
      msg: '<?php echo $lang->get('Input error'); ?>'
    }
  };

  $(document).ready(function(){
    var obj_validate_form   = $('#source_form').baigoValidate(opts_validate_form);
    var obj_submit_form     = $('#source_form').baigoSubmit(opts_submit);

    $('#source_form').submit(function(){
      if (obj_validate_form.verify()) {
        obj_submit_form.formSubmit();
      }
    });
  });
  </script>
