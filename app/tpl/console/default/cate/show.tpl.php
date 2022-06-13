<?php $cfg = array(
  'title'             => $lang->get('Category', 'console.common') . ' &raquo; ' . $lang->get('Show'),
  'menu_active'       => 'cate',
  'sub_active'        => 'index',
  'baigoSubmit'       => 'true',
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

  <form name="cate_form" id="cate_form" action="<?php echo $hrefRow['duplicate']; ?>">
    <input type="hidden" name="<?php echo $token['name']; ?>" value="<?php echo $token['value']; ?>">
    <input type="hidden" name="cate_id" id="cate_id" value="<?php echo $cateRow['cate_id']; ?>">

    <div class="row">
      <div class="col-xl-9">
        <div class="card mb-3">
          <div class="card-body">
            <div class="form-group">
              <label class="text-muted font-weight-light"><?php echo $lang->get('Name'); ?></label>
              <div class="form-text font-weight-bolder"><?php echo $cateRow['cate_name']; ?></div>
            </div>

            <div class="form-group">
              <label class="text-muted font-weight-light"><?php echo $lang->get('Alias'); ?></label>
              <div class="form-text font-weight-bolder"><?php echo $cateRow['cate_alias']; ?></div>
              <small class="form-text"><?php echo $lang->get('Usually used to build URLs'); ?></small>
            </div>

            <div class="form-group">
              <label class="text-muted font-weight-light"><?php echo $lang->get('Count of per page'); ?></label>
              <div class="form-text font-weight-bolder"><?php echo $cateRow['cate_perpage']; ?></div>
            </div>

            <?php if ($cateRow['cate_parent_id'] < 1) { ?>
              <div class="form-group">
                <label class="text-muted font-weight-light"><?php echo $lang->get('URL Prefix'); ?></label>
                <div class="form-text font-weight-bolder"><?php echo $cateRow['cate_prefix']; ?></div>
              </div>
            <?php } ?>

            <div class="form-group">
              <label class="text-muted font-weight-light"><?php echo $lang->get('Content'); ?></label>
              <div class="form-text font-weight-bolder"><?php echo $cateRow['cate_content']; ?></div>
            </div>

            <div class="form-group">
              <label class="text-muted font-weight-light"><?php echo $lang->get('Jump to'); ?></label>
              <div class="form-text font-weight-bolder"><?php echo $cateRow['cate_link']; ?></div>
            </div>

            <?php if (isset($ftp_open) && $cateRow['cate_parent_id'] < 1) { ?>
              <div class="form-group">
                <label class="text-muted font-weight-light"><?php echo $lang->get('FTP Host'); ?></label>
                <div class="form-text font-weight-bolder"><?php echo $cateRow['cate_ftp_host']; ?></div>
              </div>

              <div class="form-group">
                <label class="text-muted font-weight-light"><?php echo $lang->get('Host port'); ?></label>
                <div class="form-text font-weight-bolder"><?php echo $cateRow['cate_ftp_port']; ?></div>
              </div>

              <div class="form-group">
                <label class="text-muted font-weight-light"><?php echo $lang->get('Username'); ?></label>
                <div class="form-text font-weight-bolder"><?php echo $cateRow['cate_ftp_user']; ?></div>
              </div>

              <div class="form-group">
                <label class="text-muted font-weight-light"><?php echo $lang->get('Password'); ?></label>
                <div class="form-text font-weight-bolder"><?php echo $cateRow['cate_ftp_pass']; ?></div>
              </div>

              <div class="form-group">
                <label class="text-muted font-weight-light"><?php echo $lang->get('Remote path'); ?></label>
                <div class="form-text font-weight-bolder"><?php echo $cateRow['cate_ftp_path']; ?></div>
              </div>

              <div class="form-group">
                <div class="custom-control custom-switch">
                  <input type="checkbox" <?php if ($cateRow['cate_ftp_pasv'] === 'on') { ?>checked<?php } ?> class="custom-control-input" disabled>
                  <label for="cate_ftp_pasv" class="custom-control-label">
                    <?php echo $lang->get('Passive mode'); ?>
                  </label>
                </div>
              </div>
            <?php } ?>
          </div>
          <div class="card-footer">
            <div class="d-flex justify-content-between">
              <button type="submit" class="btn btn-primary">
                <?php echo $lang->get('Duplicate'); ?>
              </button>

              <a href="<?php echo $hrefRow['edit'], $cateRow['cate_id']; ?>">
                <span class="bg-icon"><?php include($tpl_icon . 'edit' . BG_EXT_SVG); ?></span>
                <?php echo $lang->get('Edit'); ?>
              </a>
            </div>
          </div>
        </div>
      </div>

      <div class="col-xl-3">
        <div class="card bg-light">
          <div class="card-body">
            <?php include($tpl_ctrl . 'cate_info' . GK_EXT_TPL); ?>
          </div>
          <div class="card-footer text-right">
            <a href="<?php echo $hrefRow['edit'], $cateRow['cate_id']; ?>">
              <span class="bg-icon"><?php include($tpl_icon . 'edit' . BG_EXT_SVG); ?></span>
              <?php echo $lang->get('Edit'); ?>
            </a>
          </div>
        </div>
      </div>
    </div>
  </form>

<?php include($tpl_include . 'console_foot' . GK_EXT_TPL);

  include($tpl_include . 'modal_xl' . GK_EXT_TPL); ?>

  <script type="text/javascript">
  $(document).ready(function(){
    var obj_submit_form     = $('#cate_form').baigoSubmit(opts_submit);

    $('#cate_form').submit(function(){
      obj_submit_form.formSubmit();
    });
  });
  </script>

<?php include($tpl_include . 'html_foot' . GK_EXT_TPL);
