<?php $cfg = array(
  'title'          => $lang->get('Gathering', 'console.common') . ' &raquo; ' . $lang->get('Gathering site', 'console.common'),
  'menu_active'    => 'gather',
  'sub_active'     => 'gsite',
  'selectInput'    => 'true',
  'baigoValidate'  => 'true',
  'baigoSubmit'    => 'true',
);

include($tpl_include . 'console_head' . GK_EXT_TPL);
  include($tpl_include . 'gsite_head' . GK_EXT_TPL); ?>

  <form name="gsite_form" id="gsite_form" action="<?php echo $hrefRow['submit']; ?>">
    <input type="hidden" name="<?php echo $token['name']; ?>" value="<?php echo $token['value']; ?>">
    <input type="hidden" name="gsite_id" id="gsite_id" value="<?php echo $gsiteRow['gsite_id']; ?>">

    <div class="row">
      <div class="col-xl-9">
        <div class="card mb-3">
          <div class="card-body">
            <div class="form-group">
              <label><?php echo $lang->get('Name'); ?> <span class="text-danger">*</span></label>
              <input type="text" name="gsite_name" id="gsite_name" value="<?php echo $gsiteRow['gsite_name']; ?>" class="form-control">
              <small class="form-text" id="msg_gsite_name"></small>
            </div>

            <div class="form-group">
              <label><?php echo $lang->get('URL'); ?> <span class="text-danger">*</span></label>
              <input type="text" name="gsite_url" id="gsite_url" value="<?php echo $gsiteRow['gsite_url']; ?>" class="form-control" placeholder="http://">
              <small class="form-text" id="msg_gsite_url"><?php echo $lang->get('Start with <code>http://</code> or <code>https://</code>'); ?></small>
            </div>

            <div class="form-group">
              <label><?php echo $lang->get('Charset'); ?> <span class="text-danger">*</span></label>
              <div class="input-group">
                <span class="input-group-prepend">
                  <a href="#help_modal" class="btn btn-warning" data-toggle="modal" data-href="<?php echo $hrefRow['gsite-help']; ?>charset" data-size="lg">
                    <span class="bg-icon"><?php include($tpl_icon . 'question-circle' . BG_EXT_SVG); ?></span>
                  </a>
                </span>
                <input type="text" name="gsite_charset" id="gsite_charset" value="<?php echo $gsiteRow['gsite_charset']; ?>" class="form-control" placeholder="UTF-8">
                <span class="input-group-append">
                  <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-toggle="dropdown">
                    <?php echo $lang->get('Common charset'); ?>
                  </button>

                  <div class="dropdown-menu">
                    <?php foreach ($charsetRows as $key=>$value) { ?>
                      <h6 class="dropdown-header"><?php echo $lang->get($value['title'], 'console.charset'); ?></h6>
                      <?php foreach ($value['lists'] as $key_sub=>$value_sub) { ?>
                        <button class="dropdown-item bg-select-input" data-value="<?php echo $key_sub; ?>" data-target="#gsite_charset" type="button">
                          <?php echo $lang->get($key_sub), ' - ', $lang->get($value_sub['title'], 'console.charset'); ?>
                        </button>
                      <?php }
                    } ?>
                  </div>
                </span>
              </div>
              <small class="form-text" id="msg_gsite_charset"></small>
            </div>

            <div class="form-group">
              <label><?php echo $lang->get('Note'); ?></label>
              <input type="text" name="gsite_note" id="gsite_note" value="<?php echo $gsiteRow['gsite_note']; ?>" class="form-control">
              <small class="form-text" id="msg_gsite_note"></small>
            </div>

            <div class="bg-validate-box"></div>
          </div>
          <div class="card-footer">
            <button type="submit" class="btn btn-primary"><?php echo $lang->get('Save'); ?></button>
          </div>
        </div>

        <?php if ($gsiteRow['gsite_id'] > 0) { ?>
          <div class="card my-3">
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
        <?php } ?>
      </div>

      <?php include($tpl_include . 'gsite_side' . GK_EXT_TPL); ?>
    </div>
  </form>

<?php include($tpl_include . 'console_foot' . GK_EXT_TPL);

  include($tpl_include . 'gsite_foot' . GK_EXT_TPL); ?>

  <script type="text/javascript">
  var opts_validate_form = {
    rules: {
      gsite_name: {
        length: '1,300'
      },
      gsite_url: {
        length: '1,900',
        format: 'url'
      },
      gsite_charset: {
        length: '1,100'
      },
      gsite_note: {
        max: 30
      },
      gsite_status: {
        require: true
      },
      gsite_cate_id: {
        require: true
      }
    },
    attr_names: {
      gsite_name: '<?php echo $lang->get('Name'); ?>',
      gsite_url: '<?php echo $lang->get('URL'); ?>',
      gsite_charset: '<?php echo $lang->get('Charset'); ?>',
      gsite_note: '<?php echo $lang->get('Note'); ?>',
      gsite_status: '<?php echo $lang->get('Status'); ?>',
      gsite_cate_id: '<?php echo $lang->get('Belong to category'); ?>'
    },
    type_msg: {
      require: '<?php echo $lang->get('{:attr} require'); ?>',
      length: '<?php echo $lang->get('Size of {:attr} must be {:rule}'); ?>',
      max: '<?php echo $lang->get('Max size of {:attr} must be {:rule}'); ?>'
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
    var obj_validate_form = $('#gsite_form').baigoValidate(opts_validate_form);
    var obj_submit_form   = $('#gsite_form').baigoSubmit(opts_submit);
    $('#gsite_form').submit(function(){
      if (obj_validate_form.verify()) {
        obj_submit_form.formSubmit();
      }
    });
    $('#gsite_source').html('<div class="embed-responsive embed-responsive-21by9"><iframe class="embed-responsive-item" scrolling="auto" src="<?php echo $hrefRow['gsite-source-index'], $gsiteRow['gsite_id']; ?>"></iframe></div>');
  });
  </script>

<?php include($tpl_include . 'html_foot' . GK_EXT_TPL);
