<?php $cfg = array(
  'title'             => $lang->get('Special topic', 'console.common') . ' &raquo; ' . $lang->get('Show'),
  'menu_active'       => 'spec',
  'sub_active'        => 'index',
);

include($tpl_include . 'console_head' . GK_EXT_TPL); ?>

  <ul class="nav mb-3">
    <li class="nav-item">
      <a href="<?php echo $hrefRow['index']; ?>" class="nav-link">
        <span class="bg-icon"><?php include($tpl_icon . 'chevron-left' . BG_EXT_SVG); ?></span>
        <?php echo $lang->get('Back'); ?>
      </a>
    </li>
    <?php include($tpl_include . 'spec_menu' . GK_EXT_TPL); ?>
  </ul>

  <div class="row">
    <div class="col-xl-9">
      <div class="card mb-3">
        <div class="card-body">
          <div class="form-group">
            <label class="text-muted font-weight-light"><?php echo $lang->get('Name'); ?></label>
            <div class="form-text font-weight-bolder"><?php echo $specRow['spec_name']; ?></div>
          </div>

          <div class="form-group">
            <label class="text-muted font-weight-light"><?php echo $lang->get('Content'); ?></label>
            <div class="form-text font-weight-bolder"><?php echo $specRow['spec_content']; ?></div>
          </div>
        </div>
        <div class="card-footer text-right">
          <a href="<?php echo $hrefRow['edit'], $specRow['spec_id']; ?>">
            <span class="bg-icon"><?php include($tpl_icon . 'edit' . BG_EXT_SVG); ?></span>
            <?php echo $lang->get('Edit'); ?>
          </a>
        </div>
      </div>
    </div>

    <div class="col-xl-3">
      <div class="card bg-light">
        <div class="card-body">
          <?php include($tpl_ctrl . 'spec_info' . GK_EXT_TPL); ?>
        </div>
        <div class="card-footer text-right">
          <a href="<?php echo $hrefRow['edit'], $specRow['spec_id']; ?>">
            <span class="bg-icon"><?php include($tpl_icon . 'edit' . BG_EXT_SVG); ?></span>
            <?php echo $lang->get('Edit'); ?>
          </a>
        </div>
      </div>
    </div>
  </div>

<?php include($tpl_include . 'console_foot' . GK_EXT_TPL);

  include($tpl_include . 'modal_xl' . GK_EXT_TPL);

include($tpl_include . 'html_foot' . GK_EXT_TPL);
