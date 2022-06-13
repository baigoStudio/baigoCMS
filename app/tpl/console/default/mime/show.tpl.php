<?php $cfg = array(
  'title'         => $lang->get('MIME', 'console.common') . ' &raquo; ' . $lang->get('Show'),
  'menu_active'   => 'attach',
  'sub_active'    => 'mime',
);

include($tpl_include . 'console_head' . GK_EXT_TPL); ?>

  <nav class="nav mb-3">
    <a href="<?php echo $hrefRow['index']; ?>" class="nav-link">
      <span class="bg-icon"><?php include($tpl_icon . 'chevron-left' . BG_EXT_SVG); ?></span>
      <?php echo $lang->get('Back'); ?>
    </a>
  </nav>

  <div class="row">
    <div class="col-xl-9">
      <div class="card mb-3">
        <div class="card-body">
          <div class="form-group">
            <label class="text-muted font-weight-light"><?php echo $lang->get('Extension name'); ?></label>
            <div class="form-text font-weight-bolder"><?php echo $mimeRow['mime_ext']; ?></div>
          </div>

          <div class="form-group">
            <label class="text-muted font-weight-light"><?php echo $lang->get('MIME content'); ?></label>
            <?php foreach ($mimeRow['mime_content'] as $key=>$value) { ?>
              <div class="form-text font-weight-bolder"><?php echo $value; ?></div>
            <?php } ?>
          </div>
        </div>
        <div class="card-footer text-right">
          <a href="<?php echo $hrefRow['edit'], $mimeRow['mime_id']; ?>">
            <span class="bg-icon"><?php include($tpl_icon . 'edit' . BG_EXT_SVG); ?></span>
            <?php echo $lang->get('Edit'); ?>
          </a>
        </div>
      </div>
    </div>

    <div class="col-xl-3">
      <div class="card bg-light">
        <div class="card-body">
          <div class="form-group">
            <label class="text-muted font-weight-light"><?php echo $lang->get('ID'); ?></label>
            <div class="form-text font-weight-bolder"><?php echo $mimeRow['mime_id']; ?></div>
          </div>
        </div>
        <div class="card-footer text-right">
          <a href="<?php echo $hrefRow['edit'], $mimeRow['mime_id']; ?>">
            <span class="bg-icon"><?php include($tpl_icon . 'edit' . BG_EXT_SVG); ?></span>
            <?php echo $lang->get('Edit'); ?>
          </a>
        </div>
      </div>
    </div>
  </div>

<?php include($tpl_include . 'console_foot' . GK_EXT_TPL);
include($tpl_include . 'html_foot' . GK_EXT_TPL);
