<?php $cfg = array(
  'title'          => $lang->get('Gathering', 'console.common') . ' &raquo; ' . $lang->get('Gathering site', 'console.common'),
  'menu_active'    => 'gather',
  'sub_active'     => 'gsite',
  'baigoSubmit'    => 'true',
);

include($tpl_include . 'console_head' . GK_EXT_TPL); ?>

  <nav class="nav mb-3">
    <a href="<?php echo $hrefRow['index']; ?>" class="nav-link">
      <span class="bg-icon"><?php include($tpl_icon . 'chevron-left' . BG_EXT_SVG); ?></span>
      <?php echo $lang->get('Back'); ?>
    </a>
  </nav>

  <form name="gsite_form" id="gsite_form" action="<?php echo $hrefRow['duplicate']; ?>">
    <input type="hidden" name="<?php echo $token['name']; ?>" value="<?php echo $token['value']; ?>">
    <input type="hidden" name="gsite_id" id="gsite_id" value="<?php echo $gsiteRow['gsite_id']; ?>">

    <div class="row">
      <div class="col-xl-9">
        <div class="card mb-3">
          <div class="card-body">
            <div class="form-group">
              <label class="text-muted font-weight-light"><?php echo $lang->get('Name'); ?></label>
              <div class="form-text font-weight-bolder"><?php echo $gsiteRow['gsite_name']; ?></div>
            </div>

            <div class="form-group">
              <label class="text-muted font-weight-light"><?php echo $lang->get('URL'); ?></label>
              <div class="form-text font-weight-bolder"><?php echo $gsiteRow['gsite_url']; ?></div>
            </div>

            <div class="form-group">
              <label class="text-muted font-weight-light"><?php echo $lang->get('Charset'); ?> <span class="text-danger">*</span></label>
              <div class="form-text font-weight-bolder"><?php echo $gsiteRow['gsite_charset']; ?></div>
            </div>

            <div class="form-group">
              <label class="text-muted font-weight-light"><?php echo $lang->get('Note'); ?></label>
              <div class="form-text font-weight-bolder"><?php echo $gsiteRow['gsite_note']; ?></div>
            </div>

            <div class="bg-validate-box"></div>
          </div>
          <div class="card-footer">
            <div class="d-flex justify-content-between">
              <button type="submit" class="btn btn-primary">
                <?php echo $lang->get('Duplicate'); ?>
              </button>

              <a href="<?php echo $hrefRow['edit'], $gsiteRow['gsite_id']; ?>">
                <span class="bg-icon"><?php include($tpl_icon . 'edit' . BG_EXT_SVG); ?></span>
                <?php echo $lang->get('Edit'); ?>
              </a>
            </div>
          </div>
        </div>

        <?php if ($gsiteRow['gsite_id'] > 0) { ?>
          <div class="card my-3">
            <div class="card-header"><?php echo $lang->get('Source code'); ?></div>
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

<?php include($tpl_include . 'console_foot' . GK_EXT_TPL); ?>

  <script type="text/javascript">
  $(document).ready(function(){
    var obj_submit_form   = $('#gsite_form').baigoSubmit(opts_submit);
    $('#gsite_form').submit(function(){
      obj_submit_form.formSubmit();
    });

    $('#gsite_source').html('<div class="embed-responsive embed-responsive-21by9"><iframe class="embed-responsive-item" scrolling="auto" src="<?php echo $hrefRow['gsite-source-index'], $gsiteRow['gsite_id']; ?>"></iframe></div>');
  });
  </script>

<?php include($tpl_include . 'html_foot' . GK_EXT_TPL);
