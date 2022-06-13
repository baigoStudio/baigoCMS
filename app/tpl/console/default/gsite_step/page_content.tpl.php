<?php $cfg = array(
  'title'          => $lang->get('Gathering', 'console.common') . ' &raquo; ' . $lang->get('Gathering site', 'console.common'),
  'menu_active'    => 'gather',
  'sub_active'     => 'gsite',
  'help'           => 'step_content#page_content',
  'baigoValidate'  => 'true',
  'baigoSubmit'    => 'true',
  'selectInput'    => 'true',
);

include($tpl_include . 'console_head' . GK_EXT_TPL);
  include($tpl_include . 'gsite_head' . GK_EXT_TPL); ?>

  <form name="gsite_form" id="gsite_form" action="<?php echo $hrefRow['page-content-submit']; ?>">
    <input type="hidden" name="<?php echo $token['name']; ?>" value="<?php echo $token['value']; ?>">
    <input type="hidden" name="gsite_id" id="gsite_id" value="<?php echo $gsiteRow['gsite_id']; ?>">

    <div class="row">
      <div class="col-xl-9">
        <div class="card mb-3">
          <div class="card-header"><?php echo $lang->get('Paging content settings'); ?></div>
          <div class="card-body">
            <?php $key = 'page_content';
            $value = array(
              'title' => 'Paging content settings',
            );
            include($tpl_ctrl . 'gsite_form' . GK_EXT_TPL); ?>
          </div>
          <div class="card-footer">
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
      </div>

      <?php include($tpl_include . 'gsite_side' . GK_EXT_TPL); ?>
    </div>
  </form>

<?php include($tpl_include . 'console_foot' . GK_EXT_TPL);

  include($tpl_include . 'gsite_foot' . GK_EXT_TPL); ?>

  <script type="text/javascript">
  var opts_validate_form = {
    rules: {
      gsite_page_content_selector: {
        length: '1,100'
      },
      gsite_page_content_attr: {
        max: 100
      },
      gsite_page_content_filter: {
        max: 100
      }
    },
    attr_names: {
      gsite_page_content_selector: '<?php echo $lang->get('Selector'); ?>',
      gsite_page_content_attr: '<?php echo $lang->get('Gathering attribute'); ?>',
      gsite_page_content_filter: '<?php echo $lang->get('Filter'); ?>'
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

  $(document).ready(function(){
    var obj_validate_form = $('#gsite_form').baigoValidate(opts_validate_form);
    var obj_submit_form   = $('#gsite_form').baigoSubmit(opts_submit);
    $('#gsite_form').submit(function(){
      if (obj_validate_form.verify()) {
        obj_submit_form.formSubmit();
      }
    });

    $('#gsite_preview').html('<div class="embed-responsive embed-responsive-21by9"><iframe class="embed-responsive-item" scrolling="auto" src="<?php echo $hrefRow['gsite-preview-page-content'], $gsiteRow['gsite_id']; ?>"></iframe></div>');

    $('#gsite_source').html('<div class="embed-responsive embed-responsive-21by9"><iframe class="embed-responsive-item" scrolling="auto" src="<?php echo $hrefRow['gsite-source-page-content'],$gsiteRow['gsite_id']; ?>"></iframe></div>');
  });
  </script>

<?php include($tpl_include . 'html_foot' . GK_EXT_TPL);
