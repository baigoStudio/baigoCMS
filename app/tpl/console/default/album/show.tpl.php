<?php $cfg = array(
  'title'             => $lang->get('Albums', 'console.common') . ' &raquo; ' . $lang->get('Show'),
  'menu_active'       => 'attach',
  'sub_active'        => 'album',
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
          <div class="form-group">
            <label class="text-muted font-weight-light"><?php echo $lang->get('Name'); ?></label>
            <div class="form-text font-weight-bolder"><?php echo $albumRow['album_name']; ?></div>
          </div>

          <div class="form-group">
            <label class="text-muted font-weight-light"><?php echo $lang->get('Intro'); ?></label>
            <div class="form-text font-weight-bolder"><?php echo $albumRow['album_content']; ?></div>
          </div>
        </div>
        <div class="card-footer text-right">
          <a href="<?php echo $hrefRow['album-edit'], $albumRow['album_id']; ?>">
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
            <div class="form-text font-weight-bolder"><?php echo $albumRow['album_id']; ?></div>
          </div>

          <div class="form-group">
            <label class="text-muted font-weight-light"><?php echo $lang->get('Status'); ?></label>
            <div class="form-text font-weight-bolder"><?php $str_status = $albumRow['album_status'];
            include($tpl_include . 'status_process' . GK_EXT_TPL); ?></div>
          </div>

          <div class="form-group">
            <label class="text-muted font-weight-light"><?php echo $lang->get('Cover'); ?></label>
            <div class="mb-2">
              <?php if (isset($attachRow['attach_thumb']) && !empty($attachRow['attach_thumb'])) { ?>
                <a data-toggle="modal" href="#modal_xl" data-href="<?php echo $hrefRow['attach-show'], $attachRow['attach_id']; ?>">
                  <img src="<?php echo $attachRow['attach_thumb']; ?>" class="img-fluid">
                </a>
              <?php } ?>
            </div>

            <small class="form-text"><?php if (isset($attachRow['attach_thumb']) && !empty($attachRow['attach_thumb'])) { echo $attachRow['attach_thumb']; } ?></small>
          </div>
        </div>
        <div class="card-footer text-right">
          <a href="<?php echo $hrefRow['album-edit'], $albumRow['album_id']; ?>">
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
