  <div class="form-group">
    <label class="text-muted font-weight-light"><?php echo $lang->get('ID'); ?></label>
    <div class="form-text font-weight-bolder"><?php echo $specRow['spec_id']; ?></div>
  </div>

  <div class="form-group">
    <label class="text-muted font-weight-light"><?php echo $lang->get('Status'); ?></label>
    <div class="form-text font-weight-bolder"><?php $str_status = $specRow['spec_status'];
    include($tpl_include . 'status_process' . GK_EXT_TPL); ?></div>
  </div>

  <div class="form-group">
    <label class="text-muted font-weight-light"><?php echo $lang->get('Time'); ?></label>
    <div class="form-text font-weight-bolder"><?php echo $specRow['spec_time_format']['date_time']; ?></div>
  </div>

  <div class="form-group">
    <label class="text-muted font-weight-light"><?php echo $lang->get('Updated time'); ?></label>
    <div class="form-text font-weight-bolder"><?php echo $specRow['spec_time_update_format']['date_time']; ?></div>
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
